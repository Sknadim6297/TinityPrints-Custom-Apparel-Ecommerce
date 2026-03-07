   <!-- header area start  -->
   <header class="header3">
      <div class="header-note">
         <p>Further reductions: enjoy an extra <span>20%</span> off our Sale and free home delivery</p>
         <span class="note-close-btn"><i class="flaticon-cancel"></i></span>
      </div>
      <div class="header3-top d-none d-lg-block">
         <div class="container header-container">
            <div class="row align-items-center">
               <div class="col-lg-4">
                  <form action="#" class="filter-search-input header-search-3 d-none d-lg-inline-block">
                     <input type="text" placeholder="Search Products.....">
                     <button><i class="fal fa-search"></i></button>
                  </form>
               </div>
               <div class="col-lg-4">
                  <div class="header-logo header3-logo">
                     <a href="<?php echo e(route('home')); ?>" class="logo-bl"><img src="<?php echo e(asset('frontend/assets/img/logo/logo.png')); ?>" alt="logo-img" style="width: 100px"></a>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="action-list d-none d-md-flex action-list-header3">
                     <div class="user-btn action-item">
                        <?php if(auth()->guard()->check()): ?>
                           <div class="dropdown">
                              <a href="#" class="user-profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                                 <div class="user-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.077" height="19"
                                       viewBox="0 0 16.077 19">
                                       <g id="avatar" transform="translate(-39.385)">
                                          <g id="Group_6" data-name="Group 6" transform="translate(39.385)">
                                             <path id="Path_32" data-name="Path 32"
                                                d="M50.288,8.81a4.872,4.872,0,1,0-5.729,0,8.052,8.052,0,0,0-5.174,7.511A2.683,2.683,0,0,0,42.064,19H52.782a2.683,2.683,0,0,0,2.679-2.679A8.052,8.052,0,0,0,50.288,8.81ZM44.013,4.872a3.41,3.41,0,1,1,3.41,3.41A3.414,3.414,0,0,1,44.013,4.872Zm8.769,12.667H42.064a1.219,1.219,0,0,1-1.218-1.218A6.577,6.577,0,1,1,54,16.32,1.219,1.219,0,0,1,52.782,17.538Z"
                                                transform="translate(-39.385)" fill="#171717"></path>
                                          </g>
                                       </g>
                                    </svg>
                                 </div>
                                 <span class="user-name-text"><?php echo e(Auth::user()->name); ?></span>
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="<?php echo e(route('orders')); ?>">My Orders</a></li>
                                 <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                                 <li><a class="dropdown-item" href="<?php echo e(route('contact')); ?>">Support</a></li>
                                 <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                       <?php echo csrf_field(); ?>
                                       <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                 </li>
                              </ul>
                           </div>
                        <?php else: ?>
                           <a href="<?php echo e(route('login')); ?>">
                              <div class="user-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16.077" height="19"
                                    viewBox="0 0 16.077 19">
                                    <g id="avatar" transform="translate(-39.385)">
                                       <g id="Group_6" data-name="Group 6" transform="translate(39.385)">
                                          <path id="Path_32" data-name="Path 32"
                                             d="M50.288,8.81a4.872,4.872,0,1,0-5.729,0,8.052,8.052,0,0,0-5.174,7.511A2.683,2.683,0,0,0,42.064,19H52.782a2.683,2.683,0,0,0,2.679-2.679A8.052,8.052,0,0,0,50.288,8.81ZM44.013,4.872a3.41,3.41,0,1,1,3.41,3.41A3.414,3.414,0,0,1,44.013,4.872Zm8.769,12.667H42.064a1.219,1.219,0,0,1-1.218-1.218A6.577,6.577,0,1,1,54,16.32,1.219,1.219,0,0,1,52.782,17.538Z"
                                             transform="translate(-39.385)" fill="#171717"></path>
                                       </g>
                                    </g>
                                 </svg>
                              </div>
                           </a>
                           <a href="<?php echo e(route('login')); ?>" class="action-btn-text">Sign in</a>
                        <?php endif; ?>
                     </div>
                     <div class="action-item action-item-cart">
                        <a href="<?php echo e(route('cart.index')); ?>" class="view-cart-button">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16.665" height="20" viewBox="0 0 16.665 20">
                              <g id="Layer_2" data-name="Layer 2" transform="translate(-4.096 -1)">
                                 <path id="Path_35" data-name="Path 35"
                                    d="M14.23,16.029a4.2,4.2,0,0,1-4.123-3.374.709.709,0,0,1,1.4-.224,2.8,2.8,0,0,0,5.481,0,.709.709,0,0,1,1.4.224A4.2,4.2,0,0,1,14.23,16.029Z"
                                    transform="translate(-1.801 -3.706)"></path>
                                 <path id="Path_36" data-name="Path 36"
                                    d="M18.659,23.022H6.2a2.168,2.168,0,0,1-1.523-.612A1.9,1.9,0,0,1,4.1,20.952L4.666,9.626a2.046,2.046,0,0,1,2.1-1.886H18.092a2.046,2.046,0,0,1,2.1,1.886l.567,11.327a1.9,1.9,0,0,1-.577,1.458,2.168,2.168,0,0,1-1.523.612ZM6.766,9.061a.68.68,0,0,0-.7.657L5.5,21.018a.634.634,0,0,0,.192.486.723.723,0,0,0,.508.2h12.46a.723.723,0,0,0,.508-.2.634.634,0,0,0,.192-.486L18.792,9.691a.68.68,0,0,0-.7-.657Z"
                                    transform="translate(0 -2.022)"></path>
                                 <path id="Path_37" data-name="Path 37"
                                    d="M18.4,6.425H17V5.2a2.8,2.8,0,0,0-5.6,0V6.425H10V5.2a4.2,4.2,0,0,1,8.4,0Z"
                                    transform="translate(-1.771 0)"></path>
                              </g>
                           </svg>
                           <?php if(auth()->guard()->check()): ?>
                              <?php
                                 $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                              ?>
                              <span class="action-item-number cart-count"><?php echo e($cartCount); ?></span>
                           <?php else: ?>
                              <span class="action-item-number cart-count">0</span>
                           <?php endif; ?>
                        </a>
                        <a href="#" class="action-btn-text">Cartlist</a>
                     </div>
                     <div class="action-item action-item-wishlist">
                        <a href="<?php echo e(route('wishlist.index')); ?>" class="view-wishlist-button">
                           <svg id="heart_2_" data-name="heart (2)" xmlns="http://www.w3.org/2000/svg" width="19.452"
                              height="18" viewBox="0 0 19.452 18">
                              <g id="Group_2" data-name="Group 2" transform="translate(0 0)">
                                 <path id="Path_4" data-name="Path 4"
                                    d="M14.209,39.221a4.958,4.958,0,0,0-4.1,2.28c-.142.2-.269.4-.381.591-.112-.193-.239-.392-.381-.591a4.958,4.958,0,0,0-4.1-2.28C2.186,39.221,0,42.018,0,45.374,0,49.212,2.878,52.828,9.332,57.1a.705.705,0,0,0,.787,0c6.454-4.273,9.332-7.889,9.332-11.727C19.452,42.02,17.268,39.221,14.209,39.221Zm1.716,10.931a28.823,28.823,0,0,1-6.2,5.265,28.824,28.824,0,0,1-6.2-5.265A7.547,7.547,0,0,1,1.52,45.374c0-2.416,1.494-4.492,3.723-4.492a3.472,3.472,0,0,1,2.877,1.6A6.381,6.381,0,0,1,9,44.22a.743.743,0,0,0,1.451,0,6.376,6.376,0,0,1,.854-1.7,3.486,3.486,0,0,1,2.9-1.641c2.231,0,3.723,2.078,3.723,4.492A7.547,7.547,0,0,1,15.925,50.152Z"
                                    transform="translate(0 -39.221)" fill="#171717"></path>
                              </g>
                           </svg>
                           <?php if(auth()->guard()->check()): ?>
                              <?php
                                 $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                              ?>
                              <span class="action-item-number wishlist-count"><?php echo e($wishlistCount); ?></span>
                           <?php else: ?>
                              <span class="action-item-number wishlist-count">0</span>
                           <?php endif; ?>
                        </a>
                        <a href="#" class="action-btn-text">Wishlisht</a>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="header-sticky" class="header-main header-main3">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-12 col-lg-12">
                  <div class="header-main-content-wrapper">
                     <div class="header-logo header3-logo d-lg-none">
                        <a href="<?php echo e(route('home')); ?>" class="logo-bl"><img src="<?php echo e(asset('frontend/assets/img/logo/logo.png')); ?>" alt="logo-img"  width="100px"></a>
                     </div>
                     <div class="main-menu main-menu3 d-none d-lg-block">
                        <nav id="mobile-menu">
                           <ul>
                              <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                              <li><a href="<?php echo e(route('custom-design')); ?>">Custom Design</a></li>
                              <li><a href="<?php echo e(route('limited-edition')); ?>">Limited Edition</a></li>
                              <li><a href="<?php echo e(route('shop.category', 't-shirt')); ?>">T-Shirts</a></li>
                              <li><a href="<?php echo e(route('shop.category', 'accessories')); ?>">Accessories</a></li>
                              
                              
                              
                           </ul>
                        </nav>
                     </div>
                     <div class="menu-bar d-lg-none ml-20">
                        <a class="side-toggle" href="javascript:void(0)">
                           <div class="bar-icon">
                              <span></span>
                              <span></span>
                              <span></span>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!-- header area end -->

   <!-- Add your site or application content here -->
   <main>


      <!-- side toggle start -->
      <div class="fix">
         <div class="side-info">
            <div class="side-info-content">
               <div class="offset-widget offset-logo mb-40">
                  <div class="row align-items-center">
                     <div class="col-9">
                        <a href="<?php echo e(route('home')); ?>">
                           <img src="<?php echo e(asset('frontend/assets/img/logo/logo.png')); ?>" width="100px"  alt="Logo">
                        </a>
                     </div>
                     <div class="col-3 text-end"><button class="side-info-close"><i class="fal fa-times"></i></button>
                     </div>
                  </div>
               </div>
               <div class="mobile-menu d-lg-none fix"></div>
               <div class="offset-profile-action d-lg-none">
                  <div class="offset-widget mb-40">
                     <?php if(auth()->guard()->check()): ?>
                        <div class="mobile-user-info mb-20 text-center">
                           <div class="user-icon" style="display: inline-block; margin-bottom: 10px;">
                              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="38"
                                 viewBox="0 0 16.077 19">
                                 <g id="avatar" transform="translate(-39.385)">
                                    <g id="Group_6" data-name="Group 6" transform="translate(39.385)">
                                       <path id="Path_32" data-name="Path 32"
                                          d="M50.288,8.81a4.872,4.872,0,1,0-5.729,0,8.052,8.052,0,0,0-5.174,7.511A2.683,2.683,0,0,0,42.064,19H52.782a2.683,2.683,0,0,0,2.679-2.679A8.052,8.052,0,0,0,50.288,8.81ZM44.013,4.872a3.41,3.41,0,1,1,3.41,3.41A3.414,3.414,0,0,1,44.013,4.872Zm8.769,12.667H42.064a1.219,1.219,0,0,1-1.218-1.218A6.577,6.577,0,1,1,54,16.32,1.219,1.219,0,0,1,52.782,17.538Z"
                                          transform="translate(-39.385)" fill="#171717"></path>
                                    </g>
                                 </g>
                              </svg>
                           </div>
                           <div class="user-name" style="font-weight: 600; font-size: 16px;"><?php echo e(Auth::user()->name); ?></div>
                        </div>
                     <?php endif; ?>
                     <div class="action-list action-list-header1 mb-20">
                        <?php if(auth()->guard()->check()): ?>
                           <div class="action-item">
                              <a href="<?php echo e(route('orders')); ?>" class="action-btn-text">My Orders</a>
                           </div>
                           <div class="action-item">
                              <a href="<?php echo e(route('profile.edit')); ?>" class="action-btn-text">Profile</a>
                           </div>
                           <div class="action-item">
                              <a href="<?php echo e(route('contact')); ?>" class="action-btn-text">Support</a>
                           </div>
                           <div class="action-item">
                              <form method="POST" action="<?php echo e(route('logout')); ?>">
                                 <?php echo csrf_field(); ?>
                                 <button type="submit" class="action-btn-text">Logout</button>
                              </form>
                           </div>
                        <?php else: ?>
                           <div class="action-item">
                              <a href="<?php echo e(route('login')); ?>" class="action-btn-text">Sign in</a>
                           </div>
                        <?php endif; ?>
                     </div>
                     <div class="action-list action-list-header1">
                        <div class="action-item action-item-cart">
                           <a href="<?php echo e(route('cart.index')); ?>">
                              <i class="fal fa-shopping-bag"></i>
                              <?php if(auth()->guard()->check()): ?>
                                 <?php
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                 ?>
                                 <span class="action-item-number cart-count"><?php echo e($cartCount); ?></span>
                              <?php else: ?>
                                 <span class="action-item-number cart-count">0</span>
                              <?php endif; ?>
                           </a>
                        </div>
                        <div class="action-item action-item-wishlist">
                           <a href="<?php echo e(route('wishlist.index')); ?>">
                              <i class="fal fa-heart"></i>
                              <?php if(auth()->guard()->check()): ?>
                                 <?php
                                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                 ?>
                                 <span class="action-item-number wishlist-count"><?php echo e($wishlistCount); ?></span>
                              <?php else: ?>
                                 <span class="action-item-number wishlist-count">0</span>
                              <?php endif; ?>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="offset-widget offset_searchbar mb-30">
                  <form action="#" class="filter-search-input">
                     <input type="text" placeholder="Search keyword">
                     <button><i class="fal fa-search"></i></button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="offcanvas-overlay"></div>
      <div class="offcanvas-overlay-white"></div>

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
      </div><?php /**PATH C:\Users\SK NADIM\Downloads\_tinnity_server\resources\views/frontend/partials/header.blade.php ENDPATH**/ ?>