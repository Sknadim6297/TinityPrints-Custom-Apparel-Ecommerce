<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'designRequest', 'items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $previousStatus = $order->order_status;
        $previousPaymentStatus = $order->payment_status;

        $validated = $request->validate([
            'order_status' => 'required|in:design_pending,design_approved,payment_pending,paid,printing,packed,shipped,delivered,refund_requested,under_review,refund_approved,refund_rejected,return_in_process,product_received,refund_completed,refunded',
            'payment_status' => 'required|in:pending,paid,refunded',
            'delivery_status' => 'required|in:pending,in_transit,delivered,failed',
            'tracking_number' => 'nullable|string|max:255',
            'shipping_method' => 'nullable|string|max:255',
            'shipping_partner' => 'nullable|string|max:255',
            'shipping_weight_grams' => 'nullable|integer|min:0',
        ]);

        $shippingCost = $this->calculateShippingCost($validated['shipping_weight_grams'] ?? null);

        $order->update([
            'order_status' => $validated['order_status'],
            'payment_status' => $validated['payment_status'],
            'delivery_status' => $validated['delivery_status'],
            'tracking_number' => $validated['tracking_number'] ?? null,
            'shipping_method' => $validated['shipping_method'] ?? null,
            'shipping_partner' => $validated['shipping_partner'] ?? null,
            'shipping_weight_grams' => $validated['shipping_weight_grams'] ?? null,
            'shipping_cost' => $shippingCost,
        ]);

        if ($order->order_status === 'shipped' && $order->delivery_status === 'pending') {
            $order->update(['delivery_status' => 'in_transit']);
        }

        if ($order->order_status === 'delivered') {
            $order->update(['delivery_status' => 'delivered']);
        }

        if ($previousPaymentStatus !== 'paid' && $order->payment_status === 'paid') {
            AdminNotifier::notifyAll(
                'Payment success',
                'Payment received for order ' . $order->order_number . '.',
                'success',
                route('admin.orders.index'),
                'View orders',
                ['order_id' => $order->id, 'order_number' => $order->order_number]
            );
        }

        if ($previousStatus !== 'shipped' && $order->order_status === 'shipped') {
            $message = 'Order ' . $order->order_number . ' marked as shipped.';
            if ($order->tracking_number) {
                $message .= ' Tracking: ' . $order->tracking_number . '.';
            }

            AdminNotifier::notifyAll(
                'Order shipped',
                $message,
                'info',
                route('admin.orders.index'),
                'View orders',
                ['order_id' => $order->id, 'order_number' => $order->order_number]
            );
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    private function calculateShippingCost(?int $weightGrams): ?float
    {
        if ($weightGrams === null) {
            return null;
        }

        $extraGrams = max(0, $weightGrams - 100);

        return (float) ($extraGrams * 20);
    }
}
