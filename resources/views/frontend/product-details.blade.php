@extends('frontend.layout.app')

@section('title', $product->name)

@section('content')
<main>


      <!-- side toggle start -->
      <div class="fix">
         <div class="side-info">
            <div class="side-info-content">
               <div class="offset-widget offset-logo mb-40">
                  <div class="row align-items-center">
                     <div class="col-9">
                        <a href="{{ route('home') }}">
                           <img src="{{ asset('frontend/assets/img/logo/logo.png') }}" width="100px" alt="Logo">
                        </a>
                     </div>
                     <div class="col-3 text-end"><button class="side-info-close"><i class="fal fa-times"></i></button>
                     </div>
                  </div>
               </div>
               <div class="mobile-menu d-lg-none fix"></div>
               <div class="offset-profile-action d-lg-none">
                  <div class="offset-widget mb-40">
                     @auth
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
                           <div class="user-name" style="font-weight: 600; font-size: 16px;">{{ Auth::user()->name }}</div>
                        </div>
                     @endauth
                     <div class="action-list action-list-header1 mb-20">
                        @auth
                           <div class="action-item">
                              <a href="{{ route('orders') }}" class="action-btn-text">My Orders</a>
                           </div>
                           <div class="action-item">
                              <a href="{{ route('profile.edit') }}" class="action-btn-text">Profile</a>
                           </div>
                           <div class="action-item">
                              <a href="{{ route('contact') }}" class="action-btn-text">Support</a>
                           </div>
                           <div class="action-item">
                              <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit" class="action-btn-text">Logout</button>
                              </form>
                           </div>
                        @else
                           <div class="action-item">
                              <a href="{{ route('login') }}" class="action-btn-text">Sign in</a>
                           </div>
                        @endauth
                     </div>
                     <div class="action-list action-list-header1">
                        <div class="action-item action-item-cart">
                           <a href="{{ route('cart.index') }}">
                              <i class="fal fa-shopping-bag"></i>
                              @auth
                                 @php
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                                 @endphp
                                 <span class="action-item-number cart-count">{{ $cartCount }}</span>
                              @else
                                 <span class="action-item-number cart-count">0</span>
                              @endauth
                           </a>
                        </div>
                        <div class="action-item action-item-wishlist">
                           <a href="{{ route('wishlist.index') }}">
                              <i class="fal fa-heart"></i>
                              @auth
                                 @php
                                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                 @endphp
                                 <span class="action-item-number wishlist-count">{{ $wishlistCount }}</span>
                              @else
                                 <span class="action-item-number wishlist-count">0</span>
                              @endauth
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


      <!-- side toggle end -->

      <!-- page title area start  -->
      <section class="page-title-area" data-background="{{ asset('frontend/assets/img/bg/page-title-bg.html') }}">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="page-title-wrapper text-center">
                     <h1 class="page-title mb-10">{{ $product->name }}</h1>
                     <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                           <ul class="trail-items">
                              <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                              <li class="trail-item trail-end"><span>{{ $product->name }}</span></li>
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
                     @php
                        $activeColors = $product->colors->where('is_active', true);
                        $colorsForImages = $activeColors->count() > 0 ? $activeColors : $product->colors;
                        $productImages = $colorsForImages
                           ->flatMap(function ($color) {
                              return $color->images->whereIn('image_type', ['front', 'back']);
                           })
                           ->values()
                           ->take(10);
                        $imageCount = $productImages->count();
                     @endphp
                     <div class="product-details-tab">
                        <div class="tab-content" id="productDetailsTab">
                           @if($imageCount > 0)
                              @foreach($productImages as $index => $image)
                                 <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}" id="pro-{{ $index + 1 }}" role="tabpanel" aria-labelledby="pro-{{ $index + 1 }}-tab">
                                    <img class="active" src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}">
                                 </div>
                              @endforeach
                           @else
                              <div class="tab-pane fade active show" id="pro-1" role="tabpanel" aria-labelledby="pro-1-tab">
                                 <img class="active" src="{{ asset('frontend/assets/img/product_category/product-cat-1.jpg') }}" alt="{{ $product->name }}">
                              </div>
                           @endif
                        </div>
                     </div>
                     <div class="product-details-nav">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                           @if($imageCount > 0)
                              @foreach($productImages as $index => $image)
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="pro-{{ $index + 1 }}-tab" data-bs-toggle="tab"
                                       data-bs-target="#pro-{{ $index + 1 }}" type="button" role="tab" aria-controls="pro-{{ $index + 1 }}"
                                       aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                       <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}">
                                    </button>
                                 </li>
                              @endforeach
                           @else
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="pro-1-tab" data-bs-toggle="tab"
                                    data-bs-target="#pro-1" type="button" role="tab" aria-controls="pro-1" aria-selected="true">
                                    <img src="{{ asset('frontend/assets/img/product_category/product-cat-1.jpg') }}" alt="{{ $product->name }}">
                                 </button>
                              </li>
                           @endif
                        </ul>
                     </div>
                  </div>

               </div>
               <div class="col-lg-6">
                  <div class="product-side-info mb-30">
                     <h4 class="product-name mb-10">{{ $product->name }}</h4>
                     <span class="product-price">INR {{ number_format($product->price, 2) }}</span>

                     <p class="mb-30">{{ $product->description ?: 'No description available for this product.' }}</p>
                     
                     @if($product->sizes->where('is_available', true)->count() > 0)
                        <div class="available-sizes mb-20">
                           <span class="mb-10 d-block" style="font-weight: 600;">Select Size: <span class="text-danger">*</span></span>
                           <div class="product-available-sizes" style="display: flex; gap: 10px; flex-wrap: wrap;">
                              @foreach($product->sizes->where('is_available', true) as $size)
                                 <label class="size-option" style="cursor: pointer;">
                                    <input type="radio" name="product_size" value="{{ $size->size }}" style="display: none;" required>
                                    <span class="size-badge" style="display: inline-block; padding: 8px 16px; border: 2px solid #ddd; border-radius: 4px; font-weight: 600; transition: all 0.3s;">
                                       {{ strtoupper($size->size) }}
                                    </span>
                                 </label>
                              @endforeach
                           </div>
                        </div>
                     @endif

                     @if($product->colors->where('is_active', true)->count() > 0)
                        <div class="available-colors mb-20">
                           <span class="mb-10 d-block" style="font-weight: 600;">Select Color: <span class="text-danger">*</span></span>
                           <div class="product-color-options" style="display: flex; gap: 10px; flex-wrap: wrap;">
                              @foreach($product->colors->where('is_active', true) as $color)
                                 <label class="color-option" style="cursor: pointer;" title="{{ $color->color_name }}">
                                    <input type="radio" name="product_color" value="{{ $color->id }}" style="display: none;" required>
                                    <span class="color-badge" style="width: 40px; height: 40px; display: inline-block; border-radius: 50%; background-color: {{ $color->hex_code }}; border: 3px solid #ddd; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></span>
                                 </label>
                              @endforeach
                           </div>
                        </div>
                     @endif

                     <div class="product-quantity-cart mb-25 mt-30">
                        <div class="product-quantity-form">
                           <form id="add-to-cart-form">
                              <button class="cart-minus" type="button"><i class="far fa-minus"></i></button>
                              <input class="cart-input" id="product-quantity" type="text" value="1" readonly>
                              <button class="cart-plus" type="button"><i class="far fa-plus"></i></button>
                           </form>
                        </div>
                        <button type="button" class="fill-btn add-to-cart-btn" data-product-id="{{ $product->id }}">Add to Cart</button>
                     </div>
                     <button type="button" class="border-btn add-to-wishlist-btn" data-product-id="{{ $product->id }}">Add to Wishlist</button>
                     <div class="product__details__tag tagcloud mt-25 mb-10">
                        <span>Category : </span>
                        <a href="{{ route('shop.category', $product->category) }}" rel="tag">{{ ucwords(str_replace('-', ' ', $product->category)) }}</a>
                        @if($product->brand)
                           <span class="ml-10">Brand : </span>
                           <a href="#" rel="tag">{{ $product->brand }}</a>
                        @endif
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
                              <p>{{ $product->description ?: 'No detailed description available for this product.' }}</p>
                              @if($product->is_limited_edition && $product->drop_story)
                                 <div class="mt-20">
                                    <h5>Drop Story</h5>
                                    <p>{{ $product->drop_story }}</p>
                                 </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade active show" id="nav-seller" role="tabpanel">
                        <div class="tabs-wrapper mt-35">
                           <!-- Display Existing Reviews -->
                           @php
                              $approvedReviews = $product->approvedReviews;
                              $averageRating = $product->averageRating();
                           @endphp

                           @if($approvedReviews->count() > 0)
                              <div class="review-summary mb-30">
                                 <div class="d-flex align-items-center mb-20">
                                    <div class="average-rating me-3">
                                       <span class="rating-number">{{ number_format($averageRating, 1) }}</span>
                                       <div class="stars">
                                          @for($i = 1; $i <= 5; $i++)
                                             <i class="fas fa-star {{ $i <= round($averageRating) ? '' : 'text-muted' }}"></i>
                                          @endfor
                                       </div>
                                    </div>
                                    <span class="text-muted">({{ $approvedReviews->count() }} {{ Str::plural('review', $approvedReviews->count()) }})</span>
                                 </div>
                              </div>

                              <!-- Reviews List -->
                              <div class="reviews-list mb-40">
                                 @foreach($approvedReviews as $review)
                                    <div class="review-item mb-30 pb-30" style="border-bottom: 1px solid #e5e5e5;">
                                       <div class="d-flex justify-content-between mb-10">
                                          <div>
                                             <h6 class="mb-0">{{ $review->user->name }}</h6>
                                             <div class="review-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                   <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}" style="font-size: 12px;"></i>
                                                @endfor
                                             </div>
                                          </div>
                                          <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                                       </div>
                                       <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                 @endforeach
                              </div>
                           @else
                              <div class="text-center py-30">
                                 <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                              </div>
                           @endif

                           <!-- Add Review Form -->
                           <div class="product__details-comment">
                              <div class="comment-title mb-20">
                                 <h3>Add a review</h3>
                                 @auth
                                    <p>Share your experience with this product</p>
                                 @else
                                    <p><a href="{{ route('login') }}">Login</a> to write a review</p>
                                 @endauth
                              </div>

                              @auth
                                 @if(session('review_success'))
                                    <div class="alert alert-success mb-20">
                                       {{ session('review_success') }}
                                    </div>
                                 @endif

                                 @if(session('review_error'))
                                    <div class="alert alert-danger mb-20">
                                       {{ session('review_error') }}
                                    </div>
                                 @endif

                                 <div class="comment-input-box mb-20">
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                       @csrf
                                       <input type="hidden" name="product_id" value="{{ $product->id }}">
                                       
                                       <div class="row">
                                          <div class="col-xxl-12">
                                             <div class="comment-rating mb-20">
                                                <span>Your Rating *</span>
                                                <div class="rating-input">
                                                   @for($i = 5; $i >= 1; $i--)
                                                      <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                                      <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                                   @endfor
                                                </div>
                                                @error('rating')
                                                   <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-xxl-12">
                                             <textarea name="comment" placeholder="Your review *"
                                                class="comment-input comment-textarea mb-20" required>{{ old('comment') }}</textarea>
                                             @error('comment')
                                                <span class="text-danger small">{{ $message }}</span>
                                             @enderror
                                          </div>
                                          <div class="col-xxl-12">
                                             <div class="comment-submit">
                                                <button type="submit" class="fill-btn">Submit Review</button>
                                             </div>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              @else
                                 <div class="alert alert-info">
                                    Please <a href="{{ route('login') }}" class="alert-link">login</a> to submit a review.
                                 </div>
                              @endauth
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
                  @forelse($relatedProducts as $relatedProduct)
                     <div class="swiper-slide">
                        <div class="single-product">
                           <div class="product-image pos-rel">
                              <a href="{{ route('product.details', $relatedProduct->id) }}" class="">
                                 @if($relatedProduct->images->first())
                                    <img src="{{ Storage::url($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}">
                                 @else
                                    <img src="{{ asset('frontend/assets/img/product_category/product-cat-1.jpg') }}" alt="{{ $relatedProduct->name }}">
                                 @endif
                              </a>
                           <div class="product-action">
                              <a href="{{ route('product.details', $relatedProduct->id) }}" class="quick-view-btn"><i class="fal fa-eye"></i></a>
                              <button type="button" class="wishlist-btn add-to-wishlist-btn" data-product-id="{{ $relatedProduct->id }}"><i class="fal fa-heart"></i></button>
                           </div>
                           <div class="product-action-bottom">
                              <button type="button" class="add-cart-btn add-to-cart-btn" data-product-id="{{ $relatedProduct->id }}"><i class="fal fa-shopping-bag"></i>Add to Cart</button>
                           </div>
                           @if($relatedProduct->is_limited_edition)
                              <div class="product-sticker-wrapper">
                                 <span class="product-sticker new">Limited</span>
                              </div>
                           @endif
                        </div>
                        <div class="product-desc">
                           <div class="product-name"><a href="{{ route('product.details', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></div>
                           <div class="product-price">
                              <span class="price-now">INR {{ number_format($relatedProduct->price, 2) }}</span>
                           </div>
                           @if($relatedProduct->colors->where('is_active', true)->count() > 0)
                              <div class="product-color-nav" style="display: flex; gap: 8px; margin-top: 10px;">
                                 @foreach($relatedProduct->colors->where('is_active', true)->take(4) as $color)
                                    <div class="color-circle" style="width: 24px; height: 24px; border-radius: 50%; background-color: {{ $color->hex_code }}; border: 2px solid #ddd; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="{{ $color->color_name }}"></div>
                                 @endforeach
                              </div>
                           @endif
                        </div>
                     </div>
                  @empty
                     <div class="col-12 text-center py-50">
                        <p>No related products found.</p>
                     </div>
                  @endforelse
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

      /* Size and Color Selection Styles */
      .size-option input[type="radio"]:checked + .size-badge {
         border-color: #171717;
         background-color: #171717;
         color: #fff;
      }
      .size-option:hover .size-badge {
         border-color: #171717;
      }
      .color-option input[type="radio"]:checked + .color-badge {
         border-color: #171717 !important;
         border-width: 3px !important;
         box-shadow: 0 0 0 2px #fff, 0 0 0 4px #171717;
      }
      .color-option:hover .color-badge {
         transform: scale(1.1);
      }
      .selection-error {
         color: #dc3545;
         font-size: 14px;
         margin-top: 5px;
         display: none;
      }
   </style>

   <!-- Product Details JavaScript -->
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Size and Color Selection
         const sizeOptions = document.querySelectorAll('.size-option');
         const colorOptions = document.querySelectorAll('.color-option');
         const addToCartBtn = document.querySelector('.add-to-cart-btn');
         
         // Handle size selection
         sizeOptions.forEach(option => {
            option.addEventListener('click', function() {
               const radio = this.querySelector('input[type="radio"]');
               radio.checked = true;
               removeError('size');
            });
         });
         
         // Handle color selection
         colorOptions.forEach(option => {
            option.addEventListener('click', function() {
               const radio = this.querySelector('input[type="radio"]');
               radio.checked = true;
               removeError('color');
            });
         });
         
         // Validate before adding to cart
         if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function(e) {
               let isValid = true;
               
               // Check if size selection exists and is required
               const sizeRadios = document.querySelectorAll('input[name="product_size"]');
               if (sizeRadios.length > 0) {
                  const selectedSize = document.querySelector('input[name="product_size"]:checked');
                  if (!selectedSize) {
                     showError('size', 'Please select a size');
                     isValid = false;
                  }
               }
               
               // Check if color selection exists and is required
               const colorRadios = document.querySelectorAll('input[name="product_color"]');
               if (colorRadios.length > 0) {
                  const selectedColor = document.querySelector('input[name="product_color"]:checked');
                  if (!selectedColor) {
                     showError('color', 'Please select a color');
                     isValid = false;
                  }
               }
               
               if (!isValid) {
                  e.stopImmediatePropagation();
                  e.preventDefault();
               }
            });
         }
         
         function showError(type, message) {
            const container = type === 'size' ? 
               document.querySelector('.available-sizes') : 
               document.querySelector('.available-colors');
            
            if (container) {
               let errorEl = container.querySelector('.selection-error');
               if (!errorEl) {
                  errorEl = document.createElement('div');
                  errorEl.className = 'selection-error';
                  container.appendChild(errorEl);
               }
               errorEl.textContent = message;
               errorEl.style.display = 'block';
            }
         }
         
         function removeError(type) {
            const container = type === 'size' ? 
               document.querySelector('.available-sizes') : 
               document.querySelector('.available-colors');
            
            if (container) {
               const errorEl = container.querySelector('.selection-error');
               if (errorEl) {
                  errorEl.style.display = 'none';
               }
            }
         }
      });
   </script>
@endsection