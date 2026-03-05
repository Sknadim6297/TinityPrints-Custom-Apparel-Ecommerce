<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RefundRequest;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product.images', 'items.product', 'refundRequest'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.images', 'items.product', 'refundRequest'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.order-details', compact('order'));
    }

    public function requestRefund(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->refundRequest && $order->refundRequest->status !== RefundRequest::STATUS_REFUND_REJECTED) {
            throw ValidationException::withMessages([
                'refund' => 'A refund request already exists for this order.',
            ]);
        }

        $validated = $request->validate([
            'reason_code' => 'required|in:defect,damaged,wrong_item,quality_issue,size_issue,changed_mind,other',
            'description' => 'required|string|max:1500',
            'evidence' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,webm,mkv|max:51200',
        ]);

        $productType = $this->resolveProductType($order);
        $this->validateRefundEligibility($order, $productType, $validated['reason_code']);

        $evidencePath = $request->file('evidence')->store('refund-evidence', 'public');

        $reasonLabels = [
            'defect' => 'Product Defect',
            'damaged' => 'Product Damaged',
            'wrong_item' => 'Wrong Item Delivered',
            'quality_issue' => 'Quality Issue',
            'size_issue' => 'Size/Fit Issue',
            'changed_mind' => 'Changed Mind',
            'other' => 'Other',
        ];

        $refund = RefundRequest::create([
            'ticket_id' => $this->generateRefundTicketId(),
            'order_id' => $order->id,
            'reason' => $reasonLabels[$validated['reason_code']] ?? 'Other',
            'reason_code' => $validated['reason_code'],
            'description' => $validated['description'],
            'proof_path' => $evidencePath,
            'evidence_path' => $evidencePath,
            'product_type' => $productType,
            'status' => RefundRequest::STATUS_REFUND_REQUESTED,
            'delivery_date' => $order->order_status === 'delivered' ? $order->updated_at : null,
        ]);

        $order->update(['order_status' => 'refund_requested']);

        AdminNotifier::notifyAll(
            'New refund request',
            'Refund ticket ' . $refund->ticket_id . ' submitted for order ' . $order->order_number . '.',
            'warning',
            route('admin.refunds.index'),
            'Review request',
            ['refund_id' => $refund->id, 'order_id' => $order->id, 'ticket_id' => $refund->ticket_id]
        );

        return redirect()->route('orders')->with('success', 'Refund request submitted successfully.');
    }

    public function respondRefundRequest(Request $request, RefundRequest $refund)
    {
        $refund->load('order');

        if (!$refund->order || $refund->order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($refund->status !== RefundRequest::STATUS_PENDING_CUSTOMER_RESPONSE) {
            throw ValidationException::withMessages([
                'refund' => 'This refund ticket is not waiting for customer response.',
            ]);
        }

        $validated = $request->validate([
            'customer_response' => 'required|string|max:1500',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,webm,mkv|max:51200',
        ]);

        $updates = [
            'customer_response' => $validated['customer_response'],
            'customer_response_at' => now(),
            'status' => RefundRequest::STATUS_UNDER_REVIEW,
            'admin_note' => null,
        ];

        if ($request->hasFile('evidence')) {
            if ($refund->evidence_path) {
                Storage::disk('public')->delete($refund->evidence_path);
            }

            $newEvidence = $request->file('evidence')->store('refund-evidence', 'public');
            $updates['evidence_path'] = $newEvidence;
            $updates['proof_path'] = $newEvidence;
        }

        $refund->update($updates);

        if ($refund->order) {
            $refund->order->update(['order_status' => 'under_review']);
        }

        AdminNotifier::notifyAll(
            'Refund customer response received',
            'Customer replied on refund ticket ' . $refund->ticket_id . '.',
            'info',
            route('admin.refunds.index'),
            'Review response',
            ['refund_id' => $refund->id, 'order_id' => $refund->order_id, 'ticket_id' => $refund->ticket_id]
        );

        return back()->with('success', 'Your response has been submitted.');
    }

    private function resolveProductType(Order $order): string
    {
        if ($order->design_request_id || $order->custom_design_status !== 'not_required') {
            return 'custom';
        }

        $hasLimitedItem = $order->items()->whereHas('product', function ($query) {
            $query->where('is_limited_edition', true);
        })->exists();

        return $hasLimitedItem ? 'limited' : 'normal';
    }

    private function validateRefundEligibility(Order $order, string $productType, string $reasonCode): void
    {
        $defectReasons = ['defect', 'damaged'];

        if ($productType === 'normal' && $order->order_status !== 'delivered') {
            throw ValidationException::withMessages([
                'refund' => 'Refunds for normal products are allowed after delivery only.',
            ]);
        }

        if ($productType === 'limited') {
            if ($order->order_status !== 'delivered') {
                throw ValidationException::withMessages([
                    'refund' => 'Limited edition refunds are allowed after delivery only.',
                ]);
            }

            if (!in_array($reasonCode, $defectReasons, true)) {
                throw ValidationException::withMessages([
                    'reason_code' => 'Limited edition products are refundable only for defect or damage cases.',
                ]);
            }
        }

        if ($productType === 'custom') {
            $beforePrintingStatuses = ['design_pending', 'design_approved', 'payment_pending', 'paid'];
            $isBeforePrinting = in_array($order->order_status, $beforePrintingStatuses, true);

            if (!$isBeforePrinting && !in_array($reasonCode, $defectReasons, true)) {
                throw ValidationException::withMessages([
                    'reason_code' => 'Custom design products are refundable after printing only for defect or damage cases.',
                ]);
            }
        }
    }

    private function generateRefundTicketId(): string
    {
        do {
            $ticket = 'RFD-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (RefundRequest::where('ticket_id', $ticket)->exists());

        return $ticket;
    }
}
