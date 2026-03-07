<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Order Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">#<?php echo e($order->order_number); ?></p>
            </div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors">
                <i class="fal fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Status</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php
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
                        ?>
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold <?php echo e($statusColor); ?>">
                            <?php echo e(ucwords(str_replace('_', ' ', $order->order_status))); ?>

                        </span>
                        <span class="px-4 py-2 rounded-lg text-sm font-semibold <?php echo e($order->payment_status === 'paid' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-orange-50 text-orange-700 dark:bg-orange-900/20 dark:text-orange-400'); ?>">
                            Payment: <?php echo e(ucwords($order->payment_status)); ?>

                        </span>
                        <span class="px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400">
                            <i class="fal fa-calendar mr-1"></i><?php echo e($order->created_at->format('M d, Y \a\t h:i A')); ?>

                        </span>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center justify-between">
                        <span><i class="fal fa-shopping-bag mr-2 text-green-500"></i>Order Items</span>
                        <span class="text-xl text-green-600 dark:text-green-400">₹<?php echo e(number_format($order->total_amount ?? 0, 2)); ?></span>
                    </h3>
                    
                    <?php if($order->items && $order->items->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $productImage = optional(optional($item->product)->images)->first();
                                    $itemImageUrl = $productImage
                                        ? \Illuminate\Support\Facades\Storage::url($productImage->image_path)
                                        : asset('frontend/assets/img/product/default.jpg');
                                ?>
                                <div class="flex justify-between items-start p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-start space-x-3 flex-1">
                                        <img src="<?php echo e($itemImageUrl); ?>" alt="<?php echo e($item->product_name); ?>" class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($item->product_name); ?></p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                <?php if($item->size): ?> Size: <?php echo e($item->size); ?> <?php endif; ?>
                                                <?php if($item->color_name): ?> • Color: <?php echo e($item->color_name); ?> <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">₹<?php echo e(number_format($item->price, 2)); ?> × <?php echo e($item->quantity); ?></p>
                                        <p class="text-sm text-green-600 dark:text-green-400">= ₹<?php echo e(number_format($item->total, 2)); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-300 dark:border-gray-600">
                            <?php if($order->discount_amount > 0): ?>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Discount <?php if($order->coupon_code): ?>(<?php echo e($order->coupon_code); ?>)<?php endif; ?>:</span>
                                    <span class="text-red-600 dark:text-red-400 font-semibold">-₹<?php echo e(number_format($order->discount_amount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(strtoupper(str_replace('_', ' ', $order->payment_method ?? 'COD'))); ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->product_name); ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Size: <?php echo e(strtoupper($order->product_size ?? 'N/A')); ?> • Qty: <?php echo e($order->quantity); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Shipping Info Card -->
                <?php if($order->tracking_number || $order->shipping_partner || $order->shipping_cost): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-truck mr-2 text-blue-500"></i>Shipping Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <?php if($order->shipping_partner): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Courier Partner:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->shipping_partner); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($order->tracking_number): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tracking Number:</span>
                                    <p class="font-mono font-semibold text-blue-600 dark:text-blue-400"><?php echo e($order->tracking_number); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($order->shipping_cost): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Shipping Cost:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">₹<?php echo e(number_format($order->shipping_cost, 2)); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($order->shipping_weight_grams): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Weight:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->shipping_weight_grams); ?>g</p>
                                </div>
                            <?php endif; ?>
                            <?php if($order->delivery_status && $order->delivery_status !== 'pending'): ?>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Delivery Status:</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(ucwords(str_replace('_', ' ', $order->delivery_status))); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Custom Design Info (if available) -->
                <?php if($order->designRequest): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fal fa-palette mr-2 text-purple-500"></i>Custom Design
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if($order->designRequest->front_design_file): ?>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Front Design:</p>
                                    <img src="<?php echo e(Storage::url($order->designRequest->front_design_file)); ?>" alt="Front Design" class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg">
                                </div>
                            <?php endif; ?>
                            <?php if($order->designRequest->back_design_file): ?>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Back Design:</p>
                                    <img src="<?php echo e(Storage::url($order->designRequest->back_design_file)); ?>" alt="Back Design" class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-700 rounded-lg">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Size:</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2"><?php echo e($order->designRequest->selected_size); ?></span>
                            </div>
                            <?php if($order->designRequest->color): ?>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Color:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2"><?php echo e($order->designRequest->color); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($order->designRequest->sleeve_type): ?>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Sleeve:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 ml-2"><?php echo e(ucwords($order->designRequest->sleeve_type)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($order->designRequest->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'); ?>">
                                    <?php echo e(ucwords(str_replace('_', ' ', $order->designRequest->status))); ?>

                                </span>
                            </div>
                        </div>
                        <?php if($order->designRequest->notes): ?>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Customer Notes:</p>
                                <p class="text-gray-900 dark:text-gray-100 mt-1"><?php echo e($order->designRequest->notes); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($order->designRequest->admin_remark): ?>
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Admin Remarks:</p>
                                <p class="text-gray-900 dark:text-gray-100 mt-1"><?php echo e($order->designRequest->admin_remark); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Update Order Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-edit mr-2 text-yellow-500"></i>Update Order
                    </h3>
                    <form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>" data-shipping-form>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Order Status</label>
                                <select name="order_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <?php $__currentLoopData = ['design_pending','design_approved','payment_pending','paid','printing','packed','shipped','delivered','refund_requested','under_review','refund_approved','refund_rejected','return_in_process','product_received','refund_completed','refunded']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php echo e($order->order_status === $status ? 'selected' : ''); ?>>
                                            <?php echo e(ucwords(str_replace('_', ' ', $status))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Payment Status</label>
                                <select name="payment_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <?php $__currentLoopData = ['pending','paid','refunded']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php echo e($order->payment_status === $status ? 'selected' : ''); ?>>
                                            <?php echo e(ucwords($status)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Partner</label>
                                <select name="shipping_partner" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Select Partner</option>
                                    <?php $__currentLoopData = ['Leopard', 'TCS', 'DHL', 'FedEx', 'BlueEx', 'Pakistan Post']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($partner); ?>" <?php echo e($order->shipping_partner === $partner ? 'selected' : ''); ?>><?php echo e($partner); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tracking Number</label>
                                <input type="text" name="tracking_number" value="<?php echo e($order->tracking_number); ?>"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Weight (g)</label>
                                <input type="number" name="shipping_weight_grams" value="<?php echo e($order->shipping_weight_grams); ?>" min="0" step="1" data-weight-input
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">After 100g → ₹20 per gram</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Cost (₹)</label>
                                <input type="text" value="<?php echo e($order->shipping_cost !== null ? number_format($order->shipping_cost, 2) : ''); ?>" data-cost-output readonly
                                       class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Delivery Status</label>
                                <select name="delivery_status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <?php $__currentLoopData = ['pending','in_transit','delivered','failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php echo e($order->delivery_status === $status ? 'selected' : ''); ?>>
                                            <?php echo e(ucwords(str_replace('_', ' ', $status))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Shipping Method</label>
                                <input type="text" name="shipping_method" value="<?php echo e($order->shipping_method); ?>"
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
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->customer_name); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Phone:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->phone); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->email); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fal fa-map-marker-alt mr-2 text-red-500"></i>Shipping Address
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        <?php echo e($order->shipping_address); ?><br>
                        <?php echo e($order->shipping_city); ?><?php if($order->shipping_postal_code): ?>, <?php echo e($order->shipping_postal_code); ?><?php endif; ?><br>
                        <?php if($order->shipping_state): ?><?php echo e($order->shipping_state); ?>, <?php endif; ?><?php echo e($order->shipping_country); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>