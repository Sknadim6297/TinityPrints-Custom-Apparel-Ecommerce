<?php $__env->startSection('title', $product->name); ?>

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
      <section class="page-title-area" data-background="<?php echo e(asset('frontend/assets/img/bg/page-title-bg.html')); ?>">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="page-title-wrapper text-center">
                     <h1 class="page-title mb-10"><?php echo e($product->name); ?></h1>
                     <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                           <ul class="trail-items">
                              <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
                              <li class="trail-item trail-end"><span><?php echo e($product->name); ?></span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- page title area end  -->

      <!-- shop details area start  -->
      <section class="shop-details-area pt-120 pb-90">
         <div class="container container-small">
            <div class="row">
               <div class="col-lg-6">
                  <div class="product-details-tab-wrapper mb-30">
                     <?php
                        $productImages = $product->images->take(5);
                        $imageCount = $productImages->count();
                     ?>
                     <div class="product-details-tab">
                        <div class="tab-content" id="productDetailsTab">
                           <?php if($imageCount > 0): ?>
                              <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <div class="tab-pane fade <?php echo e($index === 0 ? 'active show' : ''); ?>" id="pro-<?php echo e($index + 1); ?>" role="tabpanel" aria-labelledby="pro-<?php echo e($index + 1); ?>-tab">
                                    <img class="active" src="<?php echo e(Storage::url($image->image_path)); ?>" alt="<?php echo e($product->name); ?>">
                                 </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php else: ?>
                              <div class="tab-pane fade active show" id="pro-1" role="tabpanel" aria-labelledby="pro-1-tab">
                                 <img class="active" src="<?php echo e(asset('frontend/assets/img/product_category/product-cat-1.jpg')); ?>" alt="<?php echo e($product->name); ?>">
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                     <div class="product-details-nav">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                           <?php if($imageCount > 0): ?>
                              <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo e($index === 0 ? 'active' : ''); ?>" id="pro-<?php echo e($index + 1); ?>-tab" data-bs-toggle="tab"
                                       data-bs-target="#pro-<?php echo e($index + 1); ?>" type="button" role="tab" aria-controls="pro-<?php echo e($index + 1); ?>"
                                       aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>">
                                       <img src="<?php echo e(Storage::url($image->image_path)); ?>" alt="<?php echo e($product->name); ?>">
                                    </button>
                                 </li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php else: ?>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="pro-1-tab" data-bs-toggle="tab"
                                    data-bs-target="#pro-1" type="button" role="tab" aria-controls="pro-1" aria-selected="true">
                                    <img src="<?php echo e(asset('frontend/assets/img/product_category/product-cat-1.jpg')); ?>" alt="<?php echo e($product->name); ?>">
                                 </button>
                              </li>
                           <?php endif; ?>
                        </ul>
                     </div>
                  </div>

               </div>
               <div class="col-lg-6">
                  <div class="product-side-info mb-30">
                     <h4 class="product-name mb-10"><?php echo e($product->name); ?></h4>
                     <span class="product-price">INR <?php echo e(number_format($product->price, 2)); ?></span>

                     <p class="mb-30"><?php echo e($product->description ?: 'No description available for this product.'); ?></p>
                     
                     <?php if($product->sizes->where('is_available', true)->count() > 0): ?>
                        <div class="available-sizes">
                           <span>Available Sizes : </span>
                           <div class="product-available-sizes">
                              <?php $__currentLoopData = $product->sizes->where('is_available', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <span><?php echo e(strtoupper($size->size)); ?></span>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                        </div>
                     <?php endif; ?>

                     <?php if($product->colors->where('is_active', true)->count() > 0): ?>
                        <div class="available-sizes mt-20">
                           <span>Available Colors : </span>
                           <div class="product-color-options">
                              <?php $__currentLoopData = $product->colors->where('is_active', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <span class="color-badge" style="background-color: <?php echo e($color->hex_code); ?>; width: 30px; height: 30px; display: inline-block; border-radius: 50%; border: 2px solid #ddd; margin-right: 5px;" title="<?php echo e($color->color_name); ?>"></span>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                        </div>
                     <?php endif; ?>

                     <div class="product-quantity-cart mb-25 mt-30">
                        <div class="product-quantity-form">
                           <form id="add-to-cart-form">
                              <button class="cart-minus" type="button"><i class="far fa-minus"></i></button>
                              <input class="cart-input" id="product-quantity" type="text" value="1" readonly>
                              <button class="cart-plus" type="button"><i class="far fa-plus"></i></button>
                           </form>
                        </div>
                        <button type="button" class="fill-btn add-to-cart-btn" data-product-id="<?php echo e($product->id); ?>">Add to Cart</button>
                     </div>
                     <button type="button" class="border-btn add-to-wishlist-btn" data-product-id="<?php echo e($product->id); ?>">Add to Wishlist</button>
                     <div class="product__details__tag tagcloud mt-25 mb-10">
                        <span>Category : </span>
                        <a href="<?php echo e(route('shop.category', $product->category)); ?>" rel="tag"><?php echo e(ucwords(str_replace('-', ' ', $product->category))); ?></a>
                        <?php if($product->brand): ?>
                           <span class="ml-10">Brand : </span>
                           <a href="#" rel="tag"><?php echo e($product->brand); ?></a>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            </div>

            <div class="product_info-faq-area pb-0">
               <div class="">
                  <nav class="product-details-nav">
                     <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link show" id="nav-general-tab" data-bs-toggle="tab" href="#nav-general"
                           role="tab" aria-selected="false">Description</a>
                        <a class="nav-item nav-link active" id="nav-seller-tab" data-bs-toggle="tab" href="#nav-seller"
                           role="tab" aria-selected="true">Reviews</a>
                     </div>
                  </nav>
                  <div class="tab-content product-details-content" id="nav-tabContent">
                     <div class="tab-pane fade" id="nav-general" role="tabpanel">
                        <div class="tabs-wrapper mt-35">
                           <div class="product__details-des">
                              <p><?php echo e($product->description ?: 'No detailed description available for this product.'); ?></p>
                              <?php if($product->is_limited_edition && $product->drop_story): ?>
                                 <div class="mt-20">
                                    <h5>Drop Story</h5>
                                    <p><?php echo e($product->drop_story); ?></p>
                                 </div>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade active show" id="nav-seller" role="tabpanel">
                        <div class="tabs-wrapper mt-35">
                           <!-- Display Existing Reviews -->
                           <?php
                              $approvedReviews = $product->approvedReviews;
                              $averageRating = $product->averageRating();
                           ?>

                           <?php if($approvedReviews->count() > 0): ?>
                              <div class="review-summary mb-30">
                                 <div class="d-flex align-items-center mb-20">
                                    <div class="average-rating me-3">
                                       <span class="rating-number"><?php echo e(number_format($averageRating, 1)); ?></span>
                                       <div class="stars">
                                          <?php for($i = 1; $i <= 5; $i++): ?>
                                             <i class="fas fa-star <?php echo e($i <= round($averageRating) ? '' : 'text-muted'); ?>"></i>
                                          <?php endfor; ?>
                                       </div>
                                    </div>
                                    <span class="text-muted">(<?php echo e($approvedReviews->count()); ?> <?php echo e(Str::plural('review', $approvedReviews->count())); ?>)</span>
                                 </div>
                              </div>

                              <!-- Reviews List -->
                              <div class="reviews-list mb-40">
                                 <?php $__currentLoopData = $approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="review-item mb-30 pb-30" style="border-bottom: 1px solid #e5e5e5;">
                                       <div class="d-flex justify-content-between mb-10">
                                          <div>
                                             <h6 class="mb-0"><?php echo e($review->user->name); ?></h6>
                                             <div class="review-rating">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                   <i class="fas fa-star <?php echo e($i <= $review->rating ? '' : 'text-muted'); ?>" style="font-size: 12px;"></i>
                                                <?php endfor; ?>
                                             </div>
                                          </div>
                                          <span class="text-muted small"><?php echo e($review->created_at->format('M d, Y')); ?></span>
                                       </div>
                                       <p class="mb-0"><?php echo e($review->comment); ?></p>
                                    </div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </div>
                           <?php else: ?>
                              <div class="text-center py-30">
                                 <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                              </div>
                           <?php endif; ?>

                           <!-- Add Review Form -->
                           <div class="product__details-comment">
                              <div class="comment-title mb-20">
                                 <h3>Add a review</h3>
                                 <?php if(auth()->guard()->check()): ?>
                                    <p>Share your experience with this product</p>
                                 <?php else: ?>
                                    <p><a href="<?php echo e(route('login')); ?>">Login</a> to write a review</p>
                                 <?php endif; ?>
                              </div>

                              <?php if(auth()->guard()->check()): ?>
                                 <?php if(session('review_success')): ?>
                                    <div class="alert alert-success mb-20">
                                       <?php echo e(session('review_success')); ?>

                                    </div>
                                 <?php endif; ?>

                                 <?php if(session('review_error')): ?>
                                    <div class="alert alert-danger mb-20">
                                       <?php echo e(session('review_error')); ?>

                                    </div>
                                 <?php endif; ?>

                                 <div class="comment-input-box mb-20">
                                    <form action="<?php echo e(route('reviews.store')); ?>" method="POST">
                                       <?php echo csrf_field(); ?>
                                       <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                       
                                       <div class="row">
                                          <div class="col-xxl-12">
                                             <div class="comment-rating mb-20">
                                                <span>Your Rating *</span>
                                                <div class="rating-input">
                                                   <?php for($i = 5; $i >= 1; $i--): ?>
                                                      <input type="radio" name="rating" id="star<?php echo e($i); ?>" value="<?php echo e($i); ?>" required>
                                                      <label for="star<?php echo e($i); ?>"><i class="fas fa-star"></i></label>
                                                   <?php endfor; ?>
                                                </div>
                                                <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                   <span class="text-danger small"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                             </div>
                                          </div>
                                          <div class="col-xxl-12">
                                             <textarea name="comment" placeholder="Your review *"
                                                class="comment-input comment-textarea mb-20" required><?php echo e(old('comment')); ?></textarea>
                                             <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger small"><?php echo e($message); ?></span>
                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                          </div>
                                          <div class="col-xxl-12">
                                             <div class="comment-submit">
                                                <button type="submit" class="fill-btn">Submit Review</button>
                                             </div>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              <?php else: ?>
                                 <div class="alert alert-info">
                                    Please <a href="<?php echo e(route('login')); ?>" class="alert-link">login</a> to submit a review.
                                 </div>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- shop details area end  -->

      <div class="related_product pb-70">
         <div class="container container-small">
            <div class="section-title mb-55">
               <h2>Related Products</h2>
            </div>
            <!-- Slider main container -->
            <div class="swiper-container r-product-active">
               <!-- Additional required wrapper -->
               <div class="swiper-wrapper">
                  <?php $__empty_1 = true; $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                     <div class="swiper-slide">
                        <div class="single-product">
                           <div class="product-image pos-rel">
                              <a href="<?php echo e(route('product.details', $relatedProduct->id)); ?>" class="">
                                 <?php if($relatedProduct->images->first()): ?>
                                    <img src="<?php echo e(Storage::url($relatedProduct->images->first()->image_path)); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                                 <?php else: ?>
                                    <img src="<?php echo e(asset('frontend/assets/img/product_category/product-cat-1.jpg')); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                                 <?php endif; ?>
                              </a>
                           <div class="product-action">
                              <a href="<?php echo e(route('product.details', $relatedProduct->id)); ?>" class="quick-view-btn"><i class="fal fa-eye"></i></a>
                              <button type="button" class="wishlist-btn add-to-wishlist-btn" data-product-id="<?php echo e($relatedProduct->id); ?>"><i class="fal fa-heart"></i></button>
                           </div>
                           <div class="product-action-bottom">
                              <button type="button" class="add-cart-btn add-to-cart-btn" data-product-id="<?php echo e($relatedProduct->id); ?>"><i class="fal fa-shopping-bag"></i>Add to Cart</button>
                           </div>
                           <?php if($relatedProduct->is_limited_edition): ?>
                              <div class="product-sticker-wrapper">
                                 <span class="product-sticker new">Limited</span>
                              </div>
                           <?php endif; ?>
                        </div>
                        <div class="product-desc">
                           <div class="product-name"><a href="<?php echo e(route('product.details', $relatedProduct->id)); ?>"><?php echo e($relatedProduct->name); ?></a></div>
                           <div class="product-price">
                              <span class="price-now">INR <?php echo e(number_format($relatedProduct->price, 2)); ?></span>
                           </div>
                           <?php if($relatedProduct->colors->where('is_active', true)->count() > 0): ?>
                              <div class="product-color-nav" style="display: flex; gap: 8px; margin-top: 10px;">
                                 <?php $__currentLoopData = $relatedProduct->colors->where('is_active', true)->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="color-circle" style="width: 24px; height: 24px; border-radius: 50%; background-color: <?php echo e($color->hex_code); ?>; border: 2px solid #ddd; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="<?php echo e($color->color_name); ?>"></div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                     <div class="col-12 text-center py-50">
                        <p>No related products found.</p>
                     </div>
                  <?php endif; ?>
               </div>
               <!-- If we need pagination -->
               <div class="testimonial-pagination text-center"></div>
               <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
         </div>
      </div>
   </main>

   <!-- Reviews rating CSS -->
   <style>
      .rating-input {
         display: flex;
         flex-direction: row-reverse;
         justify-content: flex-end;
         gap: 5px;
      }
      .rating-input input[type="radio"] {
         display: none;
      }
      .rating-input label {
         cursor: pointer;
         color: #ddd;
         font-size: 20px;
      }
      .rating-input input[type="radio"]:checked ~ label,
      .rating-input label:hover,
      .rating-input label:hover ~ label {
         color: #ffb321;
      }
      .average-rating .rating-number {
         font-size: 32px;
         font-weight: 700;
         margin-right: 10px;
      }
      .average-rating .stars i {
         color: #ffb321;
         font-size: 16px;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/frontend/product-details.blade.php ENDPATH**/ ?>