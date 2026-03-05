@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Order Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">#{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors">
                <i class="fal fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Status</h3>
                    <div class="flex flex-wrap gap-2">
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
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold {{ $statusColor }}">
                            {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                        </span>
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-orange-50 text-orange-700 dark:bg-orange-900/20 dark:text-orange-400' }}">
                            Payment: {{ ucwords($order->payment_status) }}
                        </span>
                        <span class="px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400">
                            <i class="fal fa-calendar mr-1"></i>{{ $order->created_at->format('M d, Y \a\t h:i A') }}
                        </span>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center justify-between">
                        <span><i class="fal fa-shopping-bag mr-2 text-green-500"></i>Order Items</span>
                        <span class="text-xl text-green-600 dark:text-green-400">₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                    </h3>
                    
                    @if($order->items && $order->items->count() > 0)
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-start p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            @if($item->size) Size: {{ $item->size }} @endif
                                            @if($item->color_name) • Color: {{ $item->color_name }} @endif
                                        </p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                        <p class="text-sm text-green-600 dark:text-green-400">= ₹{{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-300 dark:border-gray-600">
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif:</span>
                                    <span class="text-red-600 dark:text-red-400 font-semibold">-₹{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'COD')) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->product_name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Size: {{ strtoupper($order->product_size ?? 'N/A') }} • Qty: {{ $order->quantity }}</p>
                        </div>
                    @endif
                </div>

                <!-- Shipping Info Card -->
                @if($order->tracking_number || $order->shipping_partner || $order->shipping_cost)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-truck mr-2 text-blue-500"></i>Shipping Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            @if($order->shipping_partner)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Courier Partner:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->shipping_partner }}</p>
                                </div>
                            @endif
                            @if($order->tracking_number)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tracking Number:</span>
                                    <p class="font-mono font-semibold text-blue-600 dark:text-blue-400">{{ $order->tracking_number }}</p>
                                </div>
                            @endif
                            @if($order->shipping_cost)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Shipping Cost:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">₹{{ number_format($order->shipping_cost, 2) }}</p>
                                </div>
                            @endif
                            @if($order->shipping_weight_grams)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Weight:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->shipping_weight_grams }}g</p>
                                </div>
                            @endif
                            @if($order->delivery_status && $order->delivery_status !== 'pending')
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Delivery Status:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ ucwords(str_replace('_', ' ', $order->delivery_status)) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Custom Design Info (if available) -->
                @if($order->designRequest)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-palette mr-2 text-purple-500"></i>Custom Design
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($order->designRequest->front_design_file)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Front Design:</p>
                                    <img src="{{ Storage::url($order->designRequest->front_design_file) }}" alt="Front Design" class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg">
                                </div>
                            @endif
                            @if($order->designRequest->back_design_file)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Back Design:</p>
                                    <img src="{{ Storage::url($order->designRequest->back_design_file) }}" alt="Back Design" class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg">
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Size:</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $order->designRequest->selected_size }}</span>
                            </div>
                            @if($order->designRequest->color)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Color:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $order->designRequest->color }}</span>
                                </div>
                            @endif
                            @if($order->designRequest->sleeve_type)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Sleeve:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ ucwords($order->designRequest->sleeve_type) }}</span>
                                </div>
                            @endif
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs rounded-full {{ $order->designRequest->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                    {{ ucwords(str_replace('_', ' ', $order->designRequest->status)) }}
                                </span>
                            </div>
                        </div>
                        @if($order->designRequest->notes)
                            <div class="mt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Customer Notes:</p>
                                <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $order->designRequest->notes }}</p>
                            </div>
                        @endif
                        @if($order->designRequest->admin_remark)
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Admin Remarks:</p>
                                <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $order->designRequest->admin_remark }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Update Order Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-edit mr-2 text-yellow-500"></i>Update Order
                    </h3>
                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" data-shipping-form>
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Order Status</label>
                                <select name="order_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded'] as $status)
                                        <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Payment Status</label>
                                <select name="payment_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['pending','paid','refunded'] as $status)
                                        <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                            {{ ucwords($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Partner</label>
                                <select name="shipping_partner" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Select Partner</option>
                                    @foreach(['Leopard', 'TCS', 'DHL', 'FedEx', 'BlueEx', 'Pakistan Post'] as $partner)
                                        <option value="{{ $partner }}" {{ $order->shipping_partner === $partner ? 'selected' : '' }}>{{ $partner }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tracking Number</label>
                                <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Weight (g)</label>
                                <input type="number" name="shipping_weight_grams" value="{{ $order->shipping_weight_grams }}" min="0" step="1" data-weight-input
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">After 100g → ₹20 per gram</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Cost (₹)</label>
                                <input type="text" value="{{ $order->shipping_cost !== null ? number_format($order->shipping_cost, 2) : '' }}" data-cost-output readonly
                                       class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Delivery Status</label>
                                <select name="delivery_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['pending','in_transit','delivered','failed'] as $status)
                                        <option value="{{ $status }}" {{ $order->delivery_status === $status ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Method</label>
                                <input type="text" name="shipping_method" value="{{ $order->shipping_method }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="submit" class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-colors duration-200 flex items-center gap-2">
                                <i class="fal fa-save"></i>
                                Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Customer & Address -->
            <div class="space-y-6">
                <!-- Customer Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-user mr-2 text-blue-500"></i>Customer Details
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Phone:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-map-marker-alt mr-2 text-red-500"></i>Shipping Address
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                        @if($order->shipping_state){{ $order->shipping_state }}, @endif{{ $order->shipping_country }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const form = document.querySelector('[data-shipping-form]');
if (form) {
    const weightInput = form.querySelector('[data-weight-input]');
    const costOutput = form.querySelector('[data-cost-output]');

    if (weightInput && costOutput) {
        const updateCost = () => {
            const weight = parseInt(weightInput.value || '0', 10);
            const extra = Math.max(0, weight - 100);
            const cost = extra * 20;
            costOutput.value = cost > 0 ? cost.toFixed(2) : '0.00';
        };

        weightInput.addEventListener('input', updateCost);
        updateCost();
    }
}
</script>
@endsection
