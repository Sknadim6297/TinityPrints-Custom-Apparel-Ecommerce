@extends('frontend.layout.app')

@section('title', 'Limited Edition')
@section('content')
<!-- page title area start  -->
<section class="page-title-area" data-background="assets/img/bg/page-title-bg.html">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Limited Edition</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end"><span>Limited Edition</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- page title area end  -->

<!-- limited edition hero section -->
<section class="limited-edition-hero pt-100 pb-80">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-6 mb-lg-0 mb-50">
            <div class="limited-edition-content">
               <span class="limited-hero-badge">
                  <i class="fas fa-fire"></i> EXCLUSIVE COLLECTION
               </span>
               <h2 class="hero-title mb-30">Limited Edition Drops</h2>
               <p class="hero-description mb-40">
                  Discover our exclusive limited edition collections featuring unique designs, premium materials, and special collaborations. Each piece is carefully crafted in limited quantities, making them true collector's items.
               </p>
               <div class="hero-features">
                  <div class="feature-badge">
                     <div class="feature-icon">
                        <i class="fas fa-gem"></i>
                     </div>
                     <span class="feature-text">Premium Quality</span>
                  </div>
                  <div class="feature-badge">
                     <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                     </div>
                     <span class="feature-text">Limited Time Only</span>
                  </div>
                  <div class="feature-badge">
                     <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                     </div>
                     <span class="feature-text">Exclusive Designs</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="limited-edition-image-wrapper">
               <div class="limited-edition-image">
                  <img src="{{ asset('frontend/assets/img/limited-edition-hero.jpg') }}" alt="Limited Edition" class="img-fluid">
                  <div class="image-overlay"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- limited edition products section -->
<section class="product-area pt-90 pb-120">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-8">
            <div class="section-title text-center">
               <h2 class="section-main-title mb-35">Current Limited Edition Drops</h2>
               <p>Get them before they're gone forever</p>
            </div>
         </div>
      </div>
      <div class="products-wrapper">
         @forelse($limitedProducts as $product)
         @php($productImage = optional($product->images->first())->image_path)
         @php($productColors = $product->colors ?? collect())
         <div class="single-product">
            <div class="product-image pos-rel">
               <a href="{{ route('product.details', $product->id) }}" class="">
                  <img src="{{ $productImage ? Storage::url($productImage) : asset('frontend/assets/img/product/product-img1.jpg') }}" alt="{{ $product->name }}">
               </a>
               <div class="product-action">
                  <a href="{{ route('product.details', $product->id) }}" class="quick-view-btn"><i class="fal fa-eye"></i></a>
                  <button type="button" class="wishlist-btn add-to-wishlist-btn" data-product-id="{{ $product->id }}"><i class="fal fa-heart"></i></button>
               </div>
               <div class="product-action-bottom">
                  <button type="button" class="add-cart-btn add-to-cart-btn" data-product-id="{{ $product->id }}"><i class="fal fa-shopping-bag"></i>Add to Cart</button>
               </div>
               <div class="product-sticker-wrapper">
                  <span class="product-sticker new">Limited</span>
               </div>
            </div>
            <div class="product-desc">
               <div class="product-name"><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></div>
               <div class="product-price">
                  <span class="price-now">INR {{ number_format($product->price, 2) }}</span>
               </div>
               @if($product->stock_limit)
               <p class="text-danger mb-10">Only {{ $product->totalStock() }} left!</p>
               @endif
               @if($product->drop_name || $product->drop_month)
               <p class="text-muted mb-10">
                  @if($product->drop_name)
                     {{ $product->drop_name }}
                  @endif
                  @if($product->drop_month)
                     {{ $product->drop_name ? ' • ' : '' }}{{ $product->drop_month }} Drop
                  @endif
               </p>
               @endif
               @if($productColors->count() > 0)
               <div class="product-color-nav" style="display: flex; gap: 8px; margin-top: 10px;">
                  @foreach($productColors as $color)
                  <div class="color-circle" style="width: 24px; height: 24px; border-radius: 50%; background-color: {{ $color->hex_code }}; border: 2px solid #ddd; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="{{ $color->color_name }}"></div>
                  @endforeach
               </div>
               @endif
            </div>
         </div>
         @empty
         <div class="col-12">
            <div class="empty-state text-center">
               <div class="empty-state-icon">
                  <i class="fas fa-box-open"></i>
               </div>
               <h3 class="empty-state-title">No Limited Edition Items Available</h3>
               <p class="empty-state-text">Please check back soon for new exclusive drops.</p>
            </div>
         </div>
         @endforelse
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="product-area-btn mt-10 text-center">
               <a href="{{ route('shop') }}" class="border-btn">Browse Regular Collection</a>
            </div>
         </div>
      </div>
      @if($limitedProducts->hasPages())
      <div class="row">
         <div class="col-lg-12">
            <div class="pagination-wrapper text-center mt-50">
               {{ $limitedProducts->links() }}
            </div>
         </div>
      </div>
      @endif
   </div>
</section>

<!-- newsletter subscription for early access -->
<section class="newsletter-area pt-120 pb-120">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-8">
            <div class="newsletter-content text-center">
               <div class="newsletter-icon">
                  <i class="fas fa-bullhorn"></i>
               </div>
               <h2 class="section-main-title newsletter-title mb-35">Get Early Access to Limited Drops</h2>
               <p class="newsletter-desc mb-40">Subscribe to our newsletter and be the first to know about new limited edition releases</p>
               <form action="#" method="POST" class="newsletter-form-custom">
                  @csrf
                  <div class="newsletter-input-wrapper">
                     <input type="email" name="email" placeholder="Enter your email address" class="newsletter-email-input" required>
                     <button type="submit" class="border-btn newsletter-submit-btn">Get Early Access</button>
                  </div>
               </form>
               <div class="newsletter-note">
                  <i class="fas fa-check-circle"></i> Join 10,000+ subscribers • No spam • Unsubscribe anytime
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection