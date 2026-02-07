@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Order Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Track orders, design status, payments, shipping, and update order flow manually.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No orders found.
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                            <div class="lg:w-60">
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Order ID</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Order Status</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ ucwords(str_replace('_', ' ', $order->order_status)) }}</p>
                                </div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customer</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Phone</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Product</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->product_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Selected Size</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ strtoupper($order->product_size) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Quantity</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->quantity }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Custom Design Status</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ ucwords(str_replace('_', ' ', $order->custom_design_status)) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Payment Status</p>
                                    <p class="font-semibold {{ $order->payment_status === 'paid' ? 'text-green-600 dark:text-green-400' : ($order->payment_status === 'refunded' ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300') }}">
                                        {{ ucwords($order->payment_status) }}
                                    </p>
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Shipping Info</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $order->shipping_address }}, {{ $order->shipping_city }}{{ $order->shipping_state ? ', ' . $order->shipping_state : '' }}
                                        {{ $order->shipping_postal_code ? ' ' . $order->shipping_postal_code : '' }}, {{ $order->shipping_country }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $order->shipping_partner ?? 'Partner TBD' }}{{ $order->tracking_number ? ' • ' . $order->tracking_number : '' }}
                                        {{ $order->shipping_cost !== null ? ' • ₹' . number_format($order->shipping_cost, 2) : '' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Delivery Status</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ ucwords(str_replace('_', ' ', $order->delivery_status ?? 'pending')) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Shipping Weight</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $order->shipping_weight_grams ? $order->shipping_weight_grams . ' g' : 'Not set' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3" data-shipping-form>
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Order Status</label>
                                <select name="order_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','refunded'] as $status)
                                        <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Payment Status</label>
                                <select name="payment_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['pending','paid','refunded'] as $status)
                                        <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                            {{ ucwords($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Shipping Partner</label>
                                <select name="shipping_partner" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Select Partner</option>
                                    @foreach(['Leopard', 'TCS', 'DHL', 'FedEx', 'BlueEx', 'Pakistan Post'] as $partner)
                                        <option value="{{ $partner }}" {{ $order->shipping_partner === $partner ? 'selected' : '' }}>{{ $partner }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Shipping Weight (g)</label>
                                <input type="number" name="shipping_weight_grams" value="{{ $order->shipping_weight_grams }}" min="0" step="1" data-weight-input
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">After 100g → ₹20 per gram</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Shipping Cost (₹)</label>
                                <input type="text" value="{{ $order->shipping_cost !== null ? number_format($order->shipping_cost, 2) : '' }}" data-cost-output readonly
                                       class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Delivery Status</label>
                                <select name="delivery_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['pending','in_transit','delivered','failed'] as $status)
                                        <option value="{{ $status }}" {{ $order->delivery_status === $status ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Shipping Method</label>
                                <input type="text" name="shipping_method" value="{{ $order->shipping_method }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Tracking #</label>
                                <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div class="lg:col-span-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
<script>
document.querySelectorAll('[data-shipping-form]').forEach(form => {
    const weightInput = form.querySelector('[data-weight-input]');
    const costOutput = form.querySelector('[data-cost-output]');

    if (!weightInput || !costOutput) {
        return;
    }

    const updateCost = () => {
        const weight = parseInt(weightInput.value || '0', 10);
        const extra = Math.max(0, weight - 100);
        const cost = extra * 20;
        costOutput.value = cost > 0 ? cost.toFixed(2) : '0.00';
    };

    weightInput.addEventListener('input', updateCost);
    updateCost();
});
</script>
@endsection
