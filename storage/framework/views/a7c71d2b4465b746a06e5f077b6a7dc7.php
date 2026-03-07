<!-- Cart Sidebar -->
<div class="fix">
   <div class="sidebar-action sidebar-cart">
      <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
      <h4 class="sidebar-action-title">Shopping Cart</h4>
      <div class="sidebar-action-list">
         <?php if(auth()->guard()->check()): ?>
            <?php
               $sidebarCartItems = \App\Models\Cart::where('user_id', auth()->id())
                  ->with(['product.images', 'color'])
                  ->latest()
                  ->take(3)
                  ->get();
               $sidebarCartTotal = $sidebarCartItems->sum(function($item) {
                  return $item->product->price * $item->quantity;
               });
            ?>
            
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
         <?php else: ?>
            <div class="text-center py-4">
               <i class="fal fa-shopping-cart" style="font-size: 48px; color: #ddd;"></i>
               <p class="text-muted mt-2">Please login to view cart</p>
            </div>
         <?php endif; ?>
      </div>
      <?php if(auth()->guard()->check()): ?>
         <?php if($sidebarCartItems->count() > 0): ?>
            <div class="product-price-total">
               <span>Subtotal :</span>
               <span class="subtotal-price">INR <?php echo e(number_format($sidebarCartTotal, 2)); ?></span>
            </div>
            <div class="sidebar-action-btn">
               <a href="<?php echo e(route('cart.index')); ?>" class="fill-btn">View cart</a>
               <a href="<?php echo e(route('checkout')); ?>" class="border-btn">Checkout</a>
            </div>
         <?php endif; ?>
      <?php endif; ?>
   </div>
</div>

<!-- Wishlist Sidebar -->
<div class="fix">
   <div class="sidebar-action sidebar-wishlist">
      <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
      <h4 class="sidebar-action-title">Wishlist</h4>
      <div class="sidebar-action-list">
         <?php if(auth()->guard()->check()): ?>
            <?php
               $sidebarWishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                  ->with(['product.images'])
                  ->latest()
                  ->take(3)
                  ->get();
            ?>
            
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
         <?php else: ?>
            <div class="text-center py-4">
               <i class="fal fa-heart" style="font-size: 48px; color: #ddd;"></i>
               <p class="text-muted mt-2">Please login to view wishlist</p>
            </div>
         <?php endif; ?>
      </div>
      <div class="sidebar-action-btn">
         <a href="<?php echo e(route('wishlist.index')); ?>" class="fill-btn">View Wishlist</a>
         <a href="<?php echo e(route('shop')); ?>" class="border-btn">Continue Shopping</a>
      </div>
   </div>
</div>
<?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\partials\cart-wishlist-sidebar.blade.php ENDPATH**/ ?>