<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefundRequest;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = RefundRequest::with('order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.refunds.index', compact('refunds'));
    }

    public function approve(Request $request, RefundRequest $refund)
    {
        $refund->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund approved successfully.');
    }

    public function reject(Request $request, RefundRequest $refund)
    {
        $refund->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
            'rejected_at' => now(),
            'approved_at' => null,
        ]);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund rejected successfully.');
    }

    public function updateStatus(Request $request, RefundRequest $refund)
    {
        $previousStatus = $refund->status;

        $validated = $request->validate([
            'status' => 'required|in:requested,approved,rejected,paid',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $updates = [
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? $refund->admin_note,
        ];

        if ($validated['status'] === 'approved') {
            $updates['approved_at'] = now();
            $updates['rejected_at'] = null;
        }

        if ($validated['status'] === 'rejected') {
            $updates['rejected_at'] = now();
            $updates['approved_at'] = null;
        }

        if ($validated['status'] === 'paid') {
            $updates['paid_at'] = now();
            $this->markOrderRefunded($refund);
        }

        $refund->update($updates);

        if ($previousStatus !== 'paid' && $refund->status === 'paid') {
            $orderNumber = $refund->order?->order_number ?? 'N/A';
            AdminNotifier::notifyAll(
                'Refund processed',
                'Refund marked as paid for order ' . $orderNumber . '.',
                'success',
                route('admin.refunds.index'),
                'View refunds',
                ['refund_id' => $refund->id, 'order_number' => $orderNumber]
            );
        }

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund status updated successfully.');
    }

    public function markPaid(Request $request, RefundRequest $refund)
    {
        $previousStatus = $refund->status;

        $refund->update([
            'status' => 'paid',
            'paid_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        $this->markOrderRefunded($refund);

        if ($previousStatus !== 'paid') {
            $orderNumber = $refund->order?->order_number ?? 'N/A';
            AdminNotifier::notifyAll(
                'Refund processed',
                'Refund marked as paid for order ' . $orderNumber . '.',
                'success',
                route('admin.refunds.index'),
                'View refunds',
                ['refund_id' => $refund->id, 'order_number' => $orderNumber]
            );
        }

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund payment processed successfully.');
    }

    private function markOrderRefunded(RefundRequest $refund): void
    {
        if (!$refund->order) {
            return;
        }

        $refund->order->update([
            'order_status' => 'refunded',
            'payment_status' => 'refunded',
        ]);
    }
}
