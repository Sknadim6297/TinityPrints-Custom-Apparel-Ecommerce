<?php $__empty_1 = true; $__currentLoopData = $sidebarWishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlistItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="sidebar-list-item">
        <div class="product-image pos-rel">
            <a href="<?php echo e(route('product.details', $wishlistItem->product->id)); ?>" class="">
                <?php if($wishlistItem->product->images->first()): ?>
                    <img src="<?php echo e(Storage::url($wishlistItem->product->images->first()->image_path)); ?>" alt="<?php echo e($wishlistItem->product->name); ?>">
                <?php else: ?>
                    <img src="<?php echo e(asset('frontend/assets/img/product/product-img1.jpg')); ?>" alt="<?php echo e($wishlistItem->product->name); ?>">
                <?php endif; ?>
            </a>
        </div>
        <div class="product-desc">
            <div class="product-name"><a href="<?php echo e(route('product.details', $wishlistItem->product->id)); ?>"><?php echo e($wishlistItem->product->name); ?></a></div>
            <div class="product-pricing">
                <span class="price-now">INR <?php echo e(number_format($wishlistItem->product->price, 2)); ?></span>
            </div>
            <form action="<?php echo e(route('wishlist.destroy', $wishlistItem->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="remove-item" onclick="return confirm('Remove from wishlist?')"><i class="fal fa-times"></i></button>
            </form>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center py-4">
        <i class="fal fa-heart" style="font-size: 48px; color: #ddd;"></i>
        <p class="text-muted mt-2">Your wishlist is empty</p>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\partials\sidebar-wishlist-items.blade.php ENDPATH**/ ?>