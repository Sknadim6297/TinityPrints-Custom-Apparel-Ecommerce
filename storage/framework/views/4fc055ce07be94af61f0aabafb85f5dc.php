<?php $__env->startSection('title', 'Custom Design'); ?>
<?php $__env->startSection('content'); ?>
<main>


      <!-- side toggle start -->
      <div class="fix">
         <div class="side-info">
            <div class="side-info-content">
               <div class="offset-widget offset-logo mb-40">
                  <div class="row align-items-center">
                     <div class="col-9">
                        <a href="<?php echo e(route('home')); ?>">
                           <img src="<?php echo e(asset('frontend/assets/img/logo/logo.png')); ?>" width="100px" alt="Logo">
                        </a>
                     </div>
                     <div class="col-3 text-end"><button class="side-info-close"><i class="fal fa-times"></i></button>
                     </div>
                  </div>
               </div>
               <div class="mobile-menu d-lg-none fix"></div>
               <div class="offset-profile-action d-md-none">
                  <div class="offset-widget mb-40">
                     <div class="action-list action-list-header1">
                        <div class="action-item action-item-cart">
                           <a href="javascript:void(0)" class="view-cart-button">
                              <i class="fal fa-shopping-bag"></i>
                              <span class="action-item-number">3</span></a>
                        </div>
                        <div class="action-item action-item-wishlist">
                           <a href="javascript:void(0)" class="view-wishlist-button">
                              <i class="fal fa-heart"></i>
                              <span class="action-item-number">2</span></a>
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


      <!-- side toggle end -->

      <!-- page title area start  -->
      <section class="page-title-area" data-background="assets/img/bg/page-title-bg.html">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="page-title-wrapper text-center">
                     <h1 class="page-title mb-10">Register</h1>
                     <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                           <ul class="trail-items">
                              <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
                              <li class="trail-item trail-end"><span>Register</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- page title area end  -->

      <!-- register area start  -->
      <div class="register-area pt-120 pb-120">
         <div class="container container-small">
            <div class="row justify-content-center">
               <div class="col-lg-8">
                  <div class="signup-form-wrapper">
                     <?php if($errors->any()): ?>
                        <div class="alert alert-danger mb-20">
                           <ul>
                              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <li><?php echo e($error); ?></li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </ul>
                        </div>
                     <?php endif; ?>
                     <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="signup-wrapper">
                                 <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Full Name" required>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="signup-wrapper">
                                 <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="signup-wrapper">
                                 <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="Phone (optional)">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="signup-wrapper">
                                 <input type="password" name="password" placeholder="Password" required>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="signup-wrapper">
                                 <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                              </div>
                           </div>
                        </div>
                        <div class="signup-action">
                           <div class="course-sidebar-list">
                              <input class="signup-checkbo" type="checkbox" id="sing-up" required>
                              <label class="sign-check" for="sing-up"><span>Accept the terms and <a href="#">Privacy
                                       Policy</a></span></label>
                           </div>
                        </div>
                        <div class="sing-buttom mb-20">
                           <button type="submit" class="sing-btn">Register now</button>
                        </div>
                        <div class="acount-login text-center">
                           <span>Already have an account? <a href="<?php echo e(route('login')); ?>">Log in</a></span>
                        </div>
                     </form>
                     <div class="sign-social text-center">
                        <span>Or Sign- in with</span>
                     </div>
                     <div class="sign-social-icon">
                        <a href="#" class="sign-facebook">
                           <svg xmlns="http://www.w3.org/2000/svg" width="9.034" height="18.531"
                              viewBox="0 0 9.034 18.531">
                              <path id="Path_2121121" data-name="Path 212"
                                 d="M183.106,757.2v-1.622c0-.811.116-1.274,1.39-1.274h1.621v-3.127h-2.664c-3.243,0-4.285,1.506-4.285,4.169v1.969h-2.085v3.127h1.969v9.265h4.054v-9.265h2.664l.347-3.243Z"
                                 transform="translate(-177.083 -751.176)" fill="#2467ec"></path>
                           </svg>
                           <span>Facebook</span>
                        </a>
                        <a href="#" class="sign-gmail">
                           <svg xmlns="http://www.w3.org/2000/svg" width="21.692" height="16.273"
                              viewBox="0 0 21.692 16.273">
                              <g id="gmail-01" transform="translate(0 -63.953)">
                                 <path id="Path_868365" data-name="Path 863185"
                                    d="M1.479,169.418H4.93v-8.381l-2.26-3.946L0,157.339v10.6a1.479,1.479,0,0,0,1.479,1.479Z"
                                    transform="translate(0 -89.192)" fill="#0085f7"></path>
                                 <path id="Path_863286" data-name="Path 8683106"
                                    d="M395.636,169.418h3.451a1.479,1.479,0,0,0,1.479-1.479v-10.6l-2.666-.248-2.264,3.946v8.381Z"
                                    transform="translate(-378.874 -89.192)" fill="#00a94b"></path>
                                 <path id="Path_8322687" data-name="Path 831687"
                                    d="M349.816,65.436,347.789,69.3l2.027,2.541,4.93-3.7V66.176A2.219,2.219,0,0,0,351.2,64.4Z"
                                    transform="translate(-333.054)" fill="#ffbc00"></path>
                                 <path id="Path_863088" data-name="Path 868038"
                                    d="M72.7,105.365l-1.932-4.08L72.7,98.956l5.916,4.437,5.916-4.437v6.409L78.619,109.8Z"
                                    transform="translate(-67.773 -33.52)" fill="#ff4131" fill-rule="evenodd"></path>
                                 <path id="Path_8682519" data-name="Path 868921"
                                    d="M0,66.176v1.972l4.93,3.7V65.436L3.55,64.4A2.219,2.219,0,0,0,0,66.176Z"
                                    transform="translate(0)" fill="#e51c19"></path>
                              </g>
                           </svg>
                           <span>Google</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- register area end  -->







   </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/auth/register.blade.php ENDPATH**/ ?>