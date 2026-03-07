<?php $__empty_1 = true; $__currentLoopData = $sidebarCartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="sidebar-list-item">
        <div class="product-image pos-rel">
            <a href="<?php echo e(route('product.details', $cartItem->product->id)); ?>" class="">
                <?php if($cartItem->product->images->first()): ?>
                    <img src="<?php echo e(Storage::url($cartItem->product->images->first()->image_path)); ?>" alt="<?php echo e($cartItem->product->name); ?>">
                <?php else: ?>
                    <img src="<?php echo e(asset('frontend/assets/img/product/product-img1.jpg')); ?>" alt="<?php echo e($cartItem->product->name); ?>">
                <?php endif; ?>
            </a>
        </div>
        <div class="product-desc">
            <div class="product-name"><a href="<?php echo e(route('product.details', $cartItem->product->id)); ?>"><?php echo e($cartItem->product->name); ?></a></div>
            <div class="product-pricing">
                <span class="item-number"><?php echo e($cartItem->quantity); ?> &times;</span>
                <span class="price-now">INR <?php echo e(number_format($cartItem->product->price, 2)); ?></span>
            </div>
            <form action="<?php echo e(route('cart.destroy', $cartItem->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="remove-item" onclick="return confirm('Remove this item?')"><i class="fal fa-times"></i></button>
            </form>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center py-4">
        <i class="fal fa-shopping-cart" style="font-size: 48px; color: #ddd;"></i>
        <p class="text-muted mt-2">Your cart is empty</p>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\SK NADIM\Downloads\_tinnity_server\resources\views/frontend/partials/sidebar-cart-items.blade.php ENDPATH**/ ?>