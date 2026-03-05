@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Order Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Track and manage order status, payments, and shipping. Update order flow and tracking information.
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
                        <!-- Order Header -->
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fa fa-calendar"></i> {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="mt-3 lg:mt-0 flex flex-wrap gap-2">
                                @php
                                    $statusColors = [
                                        'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'shipped' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'packed' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                        'printing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        'paid' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300',
                                        'payment_pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'refund_requested' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'under_review' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300',
                                        'refund_approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'refund_rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300',
                                        'return_in_process' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
                                        'product_received' => 'bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-300',
                                        'refund_completed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'refunded' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $statusColor = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                                    {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-orange-50 text-orange-700 dark:bg-orange-900/20 dark:text-orange-400' }}">
                                    Payment: {{ ucwords($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                            <!-- Customer & Contact Info -->
                            <div class="lg:w-1/3">
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-3">
                                        <i class="fa fa-user mr-2 text-blue-500"></i> Customer Details
                                    </h4>
                                    <div class="space-y-2 text-sm">
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Name:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $order->customer_name }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Phone:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $order->phone }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Email:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1 text-xs break-all">{{ $order->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-2">
                                        <i class="fa fa-map-marker-alt mr-2 text-red-500"></i> Shipping Address
                                    </h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $order->shipping_address }}<br>
                                        {{ $order->shipping_city }}{{ $order->shipping_state ? ', ' . $order->shipping_state : '' }}
                                        {{ $order->shipping_postal_code ? ' ' . $order->shipping_postal_code : '' }}<br>
                                        {{ $order->shipping_country }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Items & Summary -->
                            <div class="lg:flex-1">
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-3 flex items-center justify-between">
                                        <span><i class="fa fa-shopping-bag mr-2 text-green-500"></i> Order Items</span>
                                        <span class="text-lg text-green-600 dark:text-green-400">₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                                    </h4>
                                    
                                    @if($order->items && $order->items->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($order->items as $item)
                                                <div class="flex justify-between items-start p-2 bg-white dark:bg-gray-800 rounded">
                                                    <div class="flex-1">
                                                        <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $item->product_name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            @if($item->size) Size: {{ $item->size }} @endif
                                                            @if($item->color_name) • Color: {{ $item->color_name }} @endif
                                                        </p>
                                                    </div>
                                                    <div class="text-right ml-3">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                                        <p class="text-xs text-green-600 dark:text-green-400">= ₹{{ number_format($item->total, 2) }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-300 dark:border-gray-600 text-sm">
                                            @if($order->discount_amount > 0)
                                                <div class="flex justify-between mb-1">
                                                    <span class="text-gray-600 dark:text-gray-400">Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif:</span>
                                                    <span class="text-red-600 dark:text-red-400 font-semibold">-₹{{ number_format($order->discount_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Payment:</span>
                                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'COD')) }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm">
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->product_name }}</p>
                                            <p class="text-gray-500 dark:text-gray-400">Size: {{ strtoupper($order->product_size ?? 'N/A') }} • Qty: {{ $order->quantity }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Info (if available) -->
                        @if($order->tracking_number || $order->shipping_partner || $order->shipping_cost)
                            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex flex-wrap items-center gap-4 text-sm">
                                    @if($order->shipping_partner)
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Courier:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $order->shipping_partner }}</span>
                                        </div>
                                    @endif
                                    @if($order->tracking_number)
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tracking:</span>
                                            <code class="font-semibold text-blue-600 dark:text-blue-400 ml-1">{{ $order->tracking_number }}</code>
                                        </div>
                                    @endif
                                    @if($order->shipping_cost)
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Cost:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">₹{{ number_format($order->shipping_cost, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($order->shipping_weight_grams)
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Weight:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $order->shipping_weight_grams }}g</span>
                                        </div>
                                    @endif
                                    @if($order->delivery_status && $order->delivery_status !== 'pending')
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Delivery:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ ucwords(str_replace('_', ' ', $order->delivery_status)) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Update Order Form -->
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-5 pt-5 border-t-2 border-gray-200 dark:border-gray-700" data-shipping-form>
                            @csrf
                            @method('PATCH')
                            
                            <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4">
                                <i class="fa fa-edit mr-2 text-yellow-500"></i> Update Order Status & Shipping
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Order Status</label>
                                <select name="order_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded'] as $status)
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
                            </div>
                            <div class="mt-4 flex justify-end gap-3">
                                <button type="submit" class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm transition-colors duration-200 flex items-center gap-2">
                                    <i class="fa fa-save"></i>
                                    Update Order
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
