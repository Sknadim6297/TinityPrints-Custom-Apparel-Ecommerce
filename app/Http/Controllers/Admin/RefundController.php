<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefundRequest;
use App\Notifications\CustomerRefundStatusNotification;
use App\Support\AdminNotifier;
use App\Support\InventoryManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $statusOptions = RefundRequest::statusOptions();

        $refunds = RefundRequest::query()
            ->with(['order.items.product', 'order.user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('ticket_id', 'like', "%{$search}%")
                        ->orWhere('reason', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('order', function ($orderQuery) use ($search) {
                            $orderQuery->where('order_number', 'like', "%{$search}%")
                                ->orWhere('customer_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->when(in_array($status, $statusOptions, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when(!empty($dateFrom), function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo), function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('admin.refunds.index', compact(
            'refunds',
            'search',
            'status',
            'dateFrom',
            'dateTo',
            'statusOptions'
        ));
    }

    public function show(RefundRequest $refund)
    {
        $refund->load(['order.items.product', 'order.user']);
        return view('admin.refunds.show', compact('refund'));
    }

    public function approve(Request $request, RefundRequest $refund)
    {
        $refund->update([
            'status' => RefundRequest::STATUS_REFUND_APPROVED,
            'admin_note' => $request->input('admin_note'),
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        $this->syncOrderStatus($refund);
        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund approved successfully.');
    }

    public function reject(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $refund->update([
            'status' => RefundRequest::STATUS_REFUND_REJECTED,
            'admin_note' => $validated['admin_note'],
            'rejected_at' => now(),
            'approved_at' => null,
        ]);

        $this->syncOrderStatus($refund);
        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund rejected successfully.');
    }

    public function updateStatus(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', RefundRequest::statusOptions()),
            'admin_note' => 'nullable|string|max:1000',
        ]);

        // Check if status actually changed
        $oldStatus = $refund->status;
        $newStatus = $validated['status'];
        
        if ($oldStatus === $newStatus && empty($validated['admin_note'])) {
            return redirect()->route('admin.refunds.show', $refund)
                ->with('success', 'No changes were made.');
        }

        $updates = $this->buildStatusUpdatePayload($refund, $newStatus, $validated['admin_note'] ?? null);

        $refund->update($updates);
        
        // Only sync order status if status actually changed
        if ($oldStatus !== $newStatus) {
            $this->syncOrderStatus($refund);
            $this->restoreInventoryIfNeeded($refund);
            $this->notifyCustomer($refund);
        }

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund status updated successfully.');
    }

    public function markPaid(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'refund_method' => 'nullable|in:original_payment_gateway,wallet_refund,manual_transfer',
            'refund_amount' => 'nullable|numeric|min:0',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($refund, $validated) {
            $refund->update([
                'status' => RefundRequest::STATUS_REFUND_COMPLETED,
                'paid_at' => now(),
                'refund_completed_at' => now(),
                'refund_method' => $validated['refund_method'] ?? 'manual_transfer',
                'refund_amount' => $validated['refund_amount'] ?? $refund->order?->total_amount,
                'admin_note' => $validated['admin_note'] ?? $refund->admin_note,
            ]);

            $this->syncOrderStatus($refund);
            $this->restoreInventoryIfNeeded($refund);
        });

        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund payment processed successfully.');
    }

    public function setReturnMode(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'return_mode' => 'required|in:pickup_required,self_return',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $refund->update([
            'status' => RefundRequest::STATUS_RETURN_IN_PROCESS,
            'return_mode' => $validated['return_mode'],
            'return_initiated_at' => now(),
            'admin_note' => $validated['admin_note'] ?? $refund->admin_note,
        ]);

        $this->syncOrderStatus($refund);
        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Return handling has been started.');
    }

    public function markProductReceived(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $refund->update([
            'status' => RefundRequest::STATUS_PRODUCT_RECEIVED,
            'product_received_at' => now(),
            'admin_note' => $validated['admin_note'] ?? $refund->admin_note,
        ]);

        $this->syncOrderStatus($refund);
        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Product marked as received.');
    }

    public function complete(Request $request, RefundRequest $refund)
    {
        $validated = $request->validate([
            'refund_method' => 'required|in:original_payment_gateway,wallet_refund,manual_transfer',
            'refund_amount' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($refund, $validated) {
            $refund->update([
                'status' => RefundRequest::STATUS_REFUND_COMPLETED,
                'refund_method' => $validated['refund_method'],
                'refund_amount' => $validated['refund_amount'],
                'refund_completed_at' => now(),
                'paid_at' => now(),
                'admin_note' => $validated['admin_note'] ?? $refund->admin_note,
            ]);

            $this->syncOrderStatus($refund);
            $this->restoreInventoryIfNeeded($refund);
        });

        $this->notifyCustomer($refund);

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund completed successfully.');
    }

    public function notify(RefundRequest $refund)
    {
        $refund->update([
            'notified_at' => now(),
        ]);

        $this->notifyCustomer($refund);

        $orderNumber = $refund->order?->order_number ?? 'N/A';
        AdminNotifier::notifyAll(
            'Refund notification sent',
            'Refund notification sent for order ' . $orderNumber . '.',
            'info',
            route('admin.refunds.index'),
            'View refunds',
            ['refund_id' => $refund->id, 'order_number' => $orderNumber]
        );

        return redirect()->route('admin.refunds.show', $refund)
            ->with('success', 'Refund notification sent.');
    }

    private function buildStatusUpdatePayload(RefundRequest $refund, string $status, ?string $adminNote): array
    {
        $updates = [
            'status' => $status,
            'admin_note' => $adminNote ?? $refund->admin_note,
        ];

        if ($status === RefundRequest::STATUS_UNDER_REVIEW) {
            $updates['approved_at'] = null;
            $updates['rejected_at'] = null;
        }

        if ($status === RefundRequest::STATUS_REFUND_APPROVED) {
            $updates['approved_at'] = now();
            $updates['rejected_at'] = null;
        }

        if ($status === RefundRequest::STATUS_REFUND_REJECTED) {
            $updates['rejected_at'] = now();
            $updates['approved_at'] = null;
        }

        if (in_array($status, [RefundRequest::STATUS_PENDING_CUSTOMER_RESPONSE, RefundRequest::STATUS_REFUND_REJECTED], true) && empty($updates['admin_note'])) {
            throw ValidationException::withMessages([
                'admin_note' => 'Admin note is required for this status transition.',
            ]);
        }

        if ($status === RefundRequest::STATUS_RETURN_IN_PROCESS) {
            $updates['return_initiated_at'] = now();
        }

        if ($status === RefundRequest::STATUS_PRODUCT_RECEIVED) {
            $updates['product_received_at'] = now();
        }

        if ($status === RefundRequest::STATUS_REFUND_COMPLETED) {
            $updates['refund_completed_at'] = now();
            $updates['paid_at'] = now();
            $updates['refund_amount'] = $refund->refund_amount ?? $refund->order?->total_amount;
            $updates['refund_method'] = $refund->refund_method ?? 'manual_transfer';
        }

        return $updates;
    }

    private function syncOrderStatus(RefundRequest $refund): void
    {
        if (!$refund->order) {
            return;
        }

        $orderStatusMap = [
            RefundRequest::STATUS_REFUND_REQUESTED => 'refund_requested',
            RefundRequest::STATUS_UNDER_REVIEW => 'under_review',
            RefundRequest::STATUS_REFUND_APPROVED => 'refund_approved',
            RefundRequest::STATUS_REFUND_REJECTED => 'refund_rejected',
            RefundRequest::STATUS_PENDING_CUSTOMER_RESPONSE => 'under_review',
            RefundRequest::STATUS_RETURN_IN_PROCESS => 'return_in_process',
            RefundRequest::STATUS_PRODUCT_RECEIVED => 'product_received',
            RefundRequest::STATUS_REFUND_COMPLETED => 'refund_completed',
        ];

        $nextOrderStatus = $orderStatusMap[$refund->status] ?? $refund->order->order_status;

        $payload = ['order_status' => $nextOrderStatus];

        if ($refund->status === RefundRequest::STATUS_REFUND_COMPLETED) {
            $payload['payment_status'] = 'refunded';
        }

        $refund->order->update([
            ...$payload,
        ]);
    }

    private function restoreInventoryIfNeeded(RefundRequest $refund): void
    {
        if ($refund->status !== RefundRequest::STATUS_REFUND_COMPLETED || !$refund->order) {
            return;
        }

        InventoryManager::restoreForOrder($refund->order);
    }

    private function notifyCustomer(RefundRequest $refund): void
    {
        $refund->loadMissing('order.user');

        if ($refund->order?->user) {
            $refund->order->user->notify(new CustomerRefundStatusNotification($refund));
        }

        $refund->update(['notified_at' => now()]);
    }
}
