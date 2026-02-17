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

      <div class="fix">
         <div class="sidebar-action sidebar-cart">
            <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
            <h4 class="sidebar-action-title">Shopping Cart</h4>
            <div class="sidebar-action-list">
               <div class="sidebar-list-item">
                  <div class="product-image pos-rel">
                     <a href="shop-details.html" class=""><img src="assets/img/shirt/3/1.jpg" alt="img"></a>
                  </div>
                  <div class="product-desc">
                     <div class="product-name"><a href="shop-details.html">Felted Shirt for Man</a></div>
                     <div class="product-pricing">
                        <span class="item-number">1 &times;</span>
                        <span class="price-now">$24.00</span>
                     </div>
                     <button class="remove-item"><i class="fal fa-times"></i></button>
                  </div>
               </div>
               <div class="sidebar-list-item">
                  <div class="product-image pos-rel">
                     <a href="shop-details.html" class=""><img src="assets/img/pant/1/4.jpg" alt="img"></a>
                  </div>
                  <div class="product-desc">
                     <div class="product-name"><a href="shop-details.html">Denim Jeans Pant</a></div>
                     <div class="product-pricing">
                        <span class="item-number">1 &times;</span>
                        <span class="price-now">$12.00</span>
                     </div>
                     <button class="remove-item"><i class="fal fa-times"></i></button>
                  </div>
               </div>
               <div class="sidebar-list-item">
                  <div class="product-image pos-rel">
                     <a href="shop-details.html" class=""><img src="assets/img/jacket/2/2.jpg" alt="img"></a>
                  </div>
                  <div class="product-desc">
                     <div class="product-name"><a href="shop-details.html">Denim Official Jacket</a></div>
                     <div class="product-pricing">
                        <span class="item-number">1 &times;</span>
                        <span class="price-now">$42.00</span>
                     </div>
                     <button class="remove-item"><i class="fal fa-times"></i></button>
                  </div>
               </div>

            </div>
            <div class="product-price-total">
               <span>Subtotal :</span>
               <span class="subtotal-price">$78.00</span>
            </div>
            <div class="sidebar-action-btn">
               <a href="cart.html" class="fill-btn">View cart</a>
               <a href="checkout.html" class="border-btn">Checkout</a>
            </div>
         </div>
      </div>
      <div class="fix">
         <div class="sidebar-action sidebar-wishlist">
            <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
            <h4 class="sidebar-action-title">Wishlist</h4>
            <div class="sidebar-action-list">
               <div class="sidebar-list-item">
                  <div class="product-image pos-rel">
                     <a href="shop-details.html" class=""><img src="assets/img/shirt/1/1.jpg" alt="img"></a>
                  </div>
                  <div class="product-desc">
                     <div class="product-name"><a href="shop-details.html">Women's Faux-Trim Shirt</a></div>
                     <div class="product-pricing">
                        <span class="price-now">$20.00</span>
                     </div>
                     <button class="remove-item"><i class="fal fa-times"></i></button>
                  </div>
               </div>
               <div class="sidebar-list-item">
                  <div class="product-image pos-rel">
                     <a href="shop-details.html" class=""><img src="assets/img/pant/1/1.jpg" alt="img"></a>
                  </div>
                  <div class="product-desc">
                     <div class="product-name"><a href="shop-details.html">Skinny Jeans Pant</a></div>
                     <div class="product-pricing">
                        <span class="price-now">$24.00</span>
                     </div>
                     <button class="remove-item"><i class="fal fa-times"></i></button>
                  </div>
               </div>

            </div>
            <div class="product-price-total">
               <span>Subtotal :</span>
               <span class="subtotal-price">$44.00</span>
            </div>
            <div class="sidebar-action-btn">
               <a href="cart.html" class="fill-btn">View cart</a>
               <a href="cart.html" class="border-btn">Checkout</a>
            </div>
         </div>
      </div>
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
                        $productImages = $product->images->take(5);
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
                        <div class="available-sizes">
                           <span>Available Sizes : </span>
                           <div class="product-available-sizes">
                              @foreach($product->sizes->where('is_available', true) as $size)
                                 <span>{{ strtoupper($size->size) }}</span>
                              @endforeach
                           </div>
                        </div>
                     @endif

                     @if($product->colors->where('is_active', true)->count() > 0)
                        <div class="available-sizes mt-20">
                           <span>Available Colors : </span>
                           <div class="product-color-options">
                              @foreach($product->colors->where('is_active', true) as $color)
                                 <span class="color-badge" style="background-color: {{ $color->hex_code }}; width: 30px; height: 30px; display: inline-block; border-radius: 50%; border: 2px solid #ddd; margin-right: 5px;" title="{{ $color->color_name }}"></span>
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
                              <ul class="product-color-nav">
                                 @foreach($relatedProduct->colors->where('is_active', true)->take(4) as $color)
                                    <li class="cl-{{ strtolower($color->color_name) }}" style="background-color: {{ $color->hex_code }};">
                                       @if($color->images->first())
                                          <img src="{{ Storage::url($color->images->first()->image_path) }}" alt="{{ $color->color_name }}">
                                       @endif
                                    </li>
                                 @endforeach
                              </ul>
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
   </style>
@endsection