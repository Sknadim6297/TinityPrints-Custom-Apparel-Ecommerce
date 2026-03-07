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
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
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
      <section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="page-title-wrapper text-center">
                     <h1 class="page-title mb-10">
                        @if($product->category == 't-shirt')
                           T-Shirts
                        @elseif($product->category == 'accessories')
                           Accessories
                        @else
                           {{ ucfirst($product->category) }}
                        @endif
                     </h1>
                     <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                           <ul class="trail-items">
                              <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                              <li class="trail-item"><a href="{{ route('shop', ['category' => $product->category]) }}"><span>{{ $product->category == 't-shirt' ? 'T-Shirts' : ucfirst($product->category) }}</span></a></li>
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
                     
                     @if($product->sizes->count() > 0)
                        <div class="available-sizes mb-20">
                           <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                              <span style="font-weight: 600;">Select Size: <span class="text-danger">*</span></span>
                              <button type="button" class="btn-link" data-bs-toggle="modal" data-bs-target="#sizeChartModal" style="font-size: 14px; color: #171717; text-decoration: underline; padding: 0; border: none; cursor: pointer; background: none;">
                                 View Size Chart
                              </button>
                           </div>
                           <div class="product-available-sizes" style="display: flex; gap: 10px; flex-wrap: wrap;">
                              @foreach($product->sizes as $size)
                                 @php
                                    $isInStock = (int) $size->stock_quantity > 0;
                                 @endphp
                                 <div class="size-pill-wrapper" style="display: inline-flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                                    <label class="size-option {{ $isInStock ? '' : 'size-option-disabled' }}" style="cursor: {{ $isInStock ? 'pointer' : 'not-allowed' }};">
                                       <input
                                          type="radio"
                                          name="product_size"
                                          value="{{ $size->size }}"
                                          data-stock="{{ (int) $size->stock_quantity }}"
                                          style="display: none;"
                                          {{ $isInStock ? '' : 'disabled' }}
                                          required
                                       >
                                       <span class="size-badge" style="display: inline-block; border: 2px solid #ddd; border-radius: 4px; font-weight: 600; transition: all 0.3s;">
                                          {{ strtoupper($size->size) }}
                                       </span>
                                    </label>

                                    @if(!$isInStock)
                                       <span class="text-danger" style="font-size: 12px; line-height: 1;">Out of stock</span>
                                       @auth
                                          <button type="button" class="btn-link notify-stock-btn" data-size="{{ $size->size }}" data-product-id="{{ $product->id }}" style="font-size: 12px; color: #171717; text-decoration: underline; padding: 0; border: none; cursor: pointer; background: none;">
                                             Notify Admin
                                          </button>
                                       @else
                                          <a href="{{ route('login') }}" style="font-size: 12px; color: #171717; text-decoration: underline;">Login to notify</a>
                                       @endauth
                                    @endif
                                 </div>
                              @endforeach
                           </div>
                           <div class="stock-alert-message" style="display:none; margin-top: 8px; font-size: 14px;"></div>
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
                              <button class="cart-minus" type="button"><i class="fal fa-minus"></i></button>
                              <input class="cart-input" id="product-quantity" type="text" value="1" readonly>
                              <button class="cart-plus" type="button"><i class="fal fa-plus"></i></button>
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
                                             <i class="fal fa-star {{ $i <= round($averageRating) ? '' : 'text-muted' }}"></i>
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
                                                   <i class="fal fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}" style="font-size: 12px;"></i>
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
                                                      <label for="star{{ $i }}"><i class="fal fa-star"></i></label>
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
            <div class="products-wrapper">
               @forelse($relatedProducts as $relatedProduct)
                  @php($productImage = optional($relatedProduct->images->first())->image_path)
                  @php($productColors = ($relatedProduct->colors ?? collect())->where('is_active', true))
                  <div class="single-product">
                     <div class="product-image pos-rel">
                        <a href="{{ route('product.details', $relatedProduct->id) }}">
                           <img src="{{ $productImage ? Storage::url($productImage) : asset('frontend/assets/img/product/product-img1.jpg') }}" alt="{{ $relatedProduct->name }}">
                        </a>
                        <div class="product-action">
                           <a href="{{ route('product.details', $relatedProduct->id) }}" class="quick-view-btn"><i class="fal fa-eye"></i></a>
                           <button type="button" class="wishlist-btn add-to-wishlist-btn" data-product-id="{{ $relatedProduct->id }}"><i class="fal fa-heart"></i></button>
                        </div>
                        @if($relatedProduct->is_limited_edition)
                           <div class="product-sticker-wrapper">
                              <span class="product-sticker new">Limited</span>
                           </div>
                        @elseif($relatedProduct->created_at >= now()->subDays(30))
                           <div class="product-sticker-wrapper">
                              <span class="product-sticker new">New</span>
                           </div>
                        @endif
                     </div>
                     <div class="product-desc">
                        <div class="product-name"><a href="{{ route('product.details', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></div>
                        <div class="product-price">
                           <span class="price-now">INR {{ number_format($relatedProduct->price, 2) }}</span>
                        </div>
                        @if($productColors->count() > 0)
                           <div class="product-color-nav" style="display: flex; gap: 8px; margin-top: 10px;">
                              @foreach($productColors->take(4) as $color)
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
         </div>
      </div>
   </main>

   <!-- Size Chart Modal -->
   <div class="modal fade" id="sizeChartModal" tabindex="-1" aria-labelledby="sizeChartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="sizeChartModalLabel">T-Shirt Size Chart</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p style="margin-bottom: 20px; color: #666;">Select your size based on your chest measurement for the perfect fit.</p>
               
               <div class="size-chart-table" style="width: 100%;">
                  <table style="width: 100%; border-collapse: collapse; text-align: center;">
                     <thead>
                        <tr style="background-color: #f5f5f5; border-bottom: 2px solid #ddd;">
                           <th style="padding: 12px; border: 1px solid #ddd; font-weight: 700; font-size: 14px;">Size</th>
                           <th style="padding: 12px; border: 1px solid #ddd; font-weight: 700; font-size: 14px;">Chest (inches)</th>
                           <th style="padding: 12px; border: 1px solid #ddd; font-weight: 700; font-size: 14px;">Chest (cm)</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr style="border-bottom: 1px solid #ddd;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">XS</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">32-34</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">81-86</td>
                        </tr>
                        <tr style="background-color: #fafafa; border-bottom: 1px solid #ddd;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">S</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">34-36</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">86-91</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">M</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">38-40</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">96-101</td>
                        </tr>
                        <tr style="background-color: #fafafa; border-bottom: 1px solid #ddd;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">L</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">40-42</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">101-106</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">XL</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">42-44</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">106-111</td>
                        </tr>
                        <tr style="background-color: #fafafa;">
                           <td style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">XXL</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">46-50</td>
                           <td style="padding: 12px; border: 1px solid #ddd;">116-127</td>
                        </tr>
                     </tbody>
                  </table>
               </div>

               <div style="margin-top: 20px; padding: 15px; background-color: #f0f8ff; border-left: 4px solid #171717; border-radius: 4px;">
                  <p style="margin: 0; font-size: 14px; color: #333;">
                     <strong>💡 Sizing Tip:</strong> Measure your chest at the fullest point for the most accurate size. All measurements are taken when the T-shirt is laid flat.
                  </p>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="border-btn" data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Reviews rating CSS -->
   <style>
      /* Related Products Grid Layout */
      .related_product .products-wrapper {
         display: grid;
         grid-template-columns: repeat(4, 1fr);
         gap: 30px;
         margin-bottom: 30px;
      }

      @media (max-width: 1199px) {
         .related_product .products-wrapper {
            grid-template-columns: repeat(3, 1fr);
         }
      }

      @media (max-width: 767px) {
         .related_product .products-wrapper {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
         }
      }

      @media (max-width: 480px) {
         .related_product .products-wrapper {
            grid-template-columns: 1fr;
         }
      }

      /* FIX PRODUCT IMAGE SIZE */
      .related_product .single-product .product-image {
         width: 100%;
         height: 320px;
         overflow: hidden;
         position: relative;
      }

      /* IMAGE */
      .related_product .single-product .product-image img {
         width: 100%;
         height: 100%;
         object-fit: cover;
         display: block;
      }

      /* PRODUCT CARD */
      .related_product .single-product {
         width: 100%;
      }

      /* PRODUCT DESCRIPTION */
      .related_product .product-desc {
         padding: 15px;
         text-align: center;
      }

      /* Size Chart Modal Styles */
      .modal-content {
         border-radius: 8px;
         border: 1px solid #e5e5e5;
      }
      
      .modal-header {
         border-bottom: 2px solid #f0f0f0;
         padding: 20px;
      }
      
      .modal-title {
         font-weight: 700;
         font-size: 18px;
         color: #171717;
      }
      
      .size-chart-table {
         overflow-x: auto;
      }
      
      .size-chart-table table {
         font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      
      .size-chart-table th {
         background-color: #171717;
         color: white;
      }
      
      .size-chart-table th:first-child {
         border-top-left-radius: 4px;
      }
      
      .size-chart-table th:last-child {
         border-top-right-radius: 4px;
      }
      
      .size-chart-table td {
         font-size: 14px;
      }
      
      .modal-body {
         padding: 25px;
      }
      
      .modal-footer {
         border-top: 1px solid #f0f0f0;
         padding: 15px 25px;
      }
      
      /* Responsive size chart */
      @media (max-width: 768px) {
         .size-chart-table {
            font-size: 12px;
         }
         
         .size-chart-table td,
         .size-chart-table th {
            padding: 8px !important;
         }
         
         .modal-body {
            padding: 15px;
         }
      }

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
      .size-option-disabled .size-badge {
         color: #999;
         border-style: dashed;
         background: #f8f8f8;
      }
      .size-option:hover .size-badge {
         border-color: #171717;
      }
      .size-option-disabled:hover .size-badge {
         border-color: #ddd;
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
         // Quantity button functionality
         const quantityInput = document.getElementById('product-quantity');
         const plusButton = document.querySelector('.cart-plus');
         const minusButton = document.querySelector('.cart-minus');

         function getSelectedSizeStock() {
            const selected = document.querySelector('input[name="product_size"]:checked');
            if (!selected) {
               return null;
            }

            const stock = parseInt(selected.dataset.stock || '0', 10);
            return Number.isNaN(stock) ? null : stock;
         }

         function normalizeQuantityToStock() {
            const stock = getSelectedSizeStock();
            if (stock === null || !quantityInput) {
               return;
            }

            const currentQty = parseInt(quantityInput.value || '1', 10);
            if (stock <= 0) {
               quantityInput.value = 1;
               return;
            }

            if (currentQty > stock) {
               quantityInput.value = stock;
            }
         }
         
         // Handle quantity increase
         if (plusButton) {
            plusButton.addEventListener('click', function(e) {
               e.preventDefault();
               let currentQty = parseInt(quantityInput.value) || 1;
               const stock = getSelectedSizeStock();
               if (stock !== null && currentQty >= stock) {
                  return;
               }
               quantityInput.value = currentQty + 1;
            });
         }
         
         // Handle quantity decrease
         if (minusButton) {
            minusButton.addEventListener('click', function(e) {
               e.preventDefault();
               let currentQty = parseInt(quantityInput.value) || 1;
               if (currentQty > 1) {
                  quantityInput.value = currentQty - 1;
               }
            });
         }
         
         // Size and Color Selection
         const sizeOptions = document.querySelectorAll('.size-option');
         const colorOptions = document.querySelectorAll('.color-option');
         
         // Handle size selection
         sizeOptions.forEach(option => {
            option.addEventListener('click', function() {
               const radio = this.querySelector('input[type="radio"]');
               if (!radio || radio.disabled) {
                  return;
               }
               radio.checked = true;
               removeError('size');
               normalizeQuantityToStock();
            });
         });

         // Notify admin for out-of-stock sizes
         document.querySelectorAll('.notify-stock-btn').forEach((button) => {
            button.addEventListener('click', async function () {
               const size = this.dataset.size;
               const productId = this.dataset.productId;
               const messageEl = document.querySelector('.stock-alert-message');

               try {
                  const response = await fetch(`/products/${productId}/stock-alert`, {
                     method: 'POST',
                     headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                     },
                     body: JSON.stringify({ size }),
                  });

                  const data = await response.json();
                  if (!messageEl) {
                     return;
                  }

                  messageEl.style.display = 'block';
                  if (response.ok && data.success) {
                     messageEl.style.color = '#15803d';
                     messageEl.textContent = data.message || 'Request sent successfully.';
                  } else {
                     messageEl.style.color = '#b91c1c';
                     messageEl.textContent = data.message || 'Unable to send request right now.';
                  }
               } catch (error) {
                  if (!messageEl) {
                     return;
                  }

                  messageEl.style.display = 'block';
                  messageEl.style.color = '#b91c1c';
                  messageEl.textContent = 'Unable to send request right now.';
               }
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
         
         // Add validation function to window so cart-wishlist.js can use it
         window.validateProductSelection = function() {
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
            
            return isValid;
         };
         
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