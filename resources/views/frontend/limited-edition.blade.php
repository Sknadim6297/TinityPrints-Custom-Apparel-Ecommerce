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
<section class="limited-edition-hero pt-80 pb-60">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-6">
            <div class="limited-edition-content">
               <span class="badge badge-limited mb-20">🔥 EXCLUSIVE COLLECTION</span>
               <h2 class="hero-title mb-30">Limited Edition Drops</h2>
               <p class="hero-description mb-40">
                  Discover our exclusive limited edition collections featuring unique designs, premium materials, and special collaborations. Each piece is carefully crafted in limited quantities, making them true collector's items.
               </p>
               <div class="hero-features">
                  <div class="feature-badge">
                     <i class="fas fa-gem"></i>
                     <span>Premium Quality</span>
                  </div>
                  <div class="feature-badge">
                     <i class="fas fa-clock"></i>
                     <span>Limited Time Only</span>
                  </div>
                  <div class="feature-badge">
                     <i class="fas fa-certificate"></i>
                     <span>Exclusive Designs</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="limited-edition-image text-center">
               <img src="{{ asset('frontend/assets/img/limited-edition-hero.jpg') }}" alt="Limited Edition" class="img-fluid rounded">
            </div>
         </div>
      </div>
   </div>
</section>

<!-- limited edition products section -->
<section class="limited-edition-products pt-60 pb-120">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="section-title text-center mb-60">
               <h2 class="section-main-title">Current Limited Edition Drops</h2>
               <p>Get them before they're gone forever</p>
            </div>
         </div>
      </div>
      
      <div class="row">
         @forelse($limitedProducts as $product)
         <div class="col-xl-4 col-lg-4 col-md-6 mb-40">
            <div class="limited-product-card">
               <div class="product-image-wrapper position-relative">
                  @php($productImage = optional($product->images->first())->image_path)
                  <img src="{{ $productImage ? Storage::url($productImage) : asset('frontend/assets/img/product/product-img1.jpg') }}" 
                       alt="{{ $product->name }}" class="product-image">
                  
                  <!-- Limited Edition Badge -->
                  <div class="limited-badge">
                     <span class="badge-text">LIMITED</span>
                     <span class="badge-number">#{{ $loop->iteration }}</span>
                  </div>
                  
                  <!-- Stock Countdown -->
                  @if($product->stock_limit)
                  <div class="stock-countdown">
                     <span class="stock-text">Only {{ $product->totalStock() }} left!</span>
                  </div>
                  @endif
                  
                  <div class="product-overlay">
                     <div class="overlay-actions">
                        <a href="{{ route('product.details', $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        <a href="#" class="btn btn-outline-light btn-sm ml-2">Add to Cart</a>
                     </div>
                  </div>
               </div>
               
               <div class="product-info p-20">
                  <div class="product-meta mb-10">
                     @if($product->drop_name)
                     <span class="drop-name">{{ $product->drop_name }}</span>
                     @endif
                     @if($product->drop_month)
                     <span class="drop-month">{{ $product->drop_month }} Drop</span>
                     @endif
                  </div>
                  
                  <h4 class="product-title">
                     <a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                  </h4>
                  
                  @if($product->drop_story)
                  <p class="product-story">{{ Str::limit($product->drop_story, 100) }}</p>
                  @endif
                  
                  <div class="product-price-section">
                     <div class="price">
                        <span class="current-price">${{ number_format($product->price, 2) }}</span>
                        @if($product->old_price)
                        <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                        @endif
                     </div>
                     
                     @if($product->drop_end_at)
                     <div class="countdown-timer" data-end-time="{{ $product->drop_end_at->toISOString() }}">
                        <small class="text-danger">
                           <i class="fas fa-clock"></i>
                           Ends in: <span class="timer-display">Loading...</span>
                        </small>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         @empty
         <div class="col-lg-12">
            <div class="text-center py-80">
               <div class="empty-state">
                  <i class="fas fa-gem mb-30" style="font-size: 4rem; color: #ccc;"></i>
                  <h3>No Limited Edition Items Available</h3>
                  <p class="text-muted mb-30">Check back soon for new exclusive drops!</p>
                  <a href="{{ route('shop') }}" class="btn btn-primary">Browse Regular Collection</a>
               </div>
            </div>
         </div>
         @endforelse
      </div>
      
      <!-- Pagination -->
      @if($limitedProducts->hasPages())
      <div class="row">
         <div class="col-lg-12">
            <div class="pagination-wrapper text-center">
               {{ $limitedProducts->links() }}
            </div>
         </div>
      </div>
      @endif
   </div>
</section>

<!-- newsletter subscription for early access -->
<section class="limited-edition-newsletter bg-dark text-white py-80">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8 text-center">
            <h3 class="mb-20">Get Early Access to Limited Drops</h3>
            <p class="mb-40">Subscribe to our newsletter and be the first to know about new limited edition releases</p>
            <form action="#" method="POST" class="newsletter-form">
               @csrf
               <div class="input-group">
                  <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                  <div class="input-group-append">
                     <button type="submit" class="btn btn-primary">Get Early Access</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>

<style>
.badge-limited {
   background: linear-gradient(45deg, #ff6b6b, #ee5a52);
   color: white;
   padding: 8px 16px;
   border-radius: 20px;
   font-weight: 600;
   display: inline-block;
}

.hero-title {
   font-size: 3rem;
   font-weight: 700;
   color: #222;
}

.hero-description {
   font-size: 1.1rem;
   color: #666;
   line-height: 1.6;
}

.hero-features {
   display: flex;
   flex-wrap: wrap;
   gap: 20px;
}

.feature-badge {
   display: flex;
   align-items: center;
   gap: 8px;
   background: #f8f9fa;
   padding: 10px 15px;
   border-radius: 25px;
   border: 1px solid #e9ecef;
}

.feature-badge i {
   color: #007bff;
}

.limited-product-card {
   background: white;
   border-radius: 15px;
   overflow: hidden;
   box-shadow: 0 5px 20px rgba(0,0,0,0.1);
   transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.limited-product-card:hover {
   transform: translateY(-5px);
   box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.product-image-wrapper {
   position: relative;
   overflow: hidden;
}

.product-image {
   width: 100%;
   height: 300px;
   object-fit: cover;
   transition: transform 0.3s ease;
}

.limited-product-card:hover .product-image {
   transform: scale(1.05);
}

.limited-badge {
   position: absolute;
   top: 15px;
   right: 15px;
   background: linear-gradient(135deg, #ff6b6b, #ee5a52);
   color: white;
   padding: 8px 12px;
   border-radius: 8px;
   text-align: center;
   font-size: 0.8rem;
   font-weight: 700;
   z-index: 2;
}

.badge-text {
   display: block;
   font-size: 0.7rem;
}

.badge-number {
   display: block;
   font-size: 0.9rem;
}

.stock-countdown {
   position: absolute;
   bottom: 15px;
   left: 15px;
   background: rgba(255,0,0,0.9);
   color: white;
   padding: 5px 10px;
   border-radius: 15px;
   font-size: 0.8rem;
   font-weight: 600;
   z-index: 2;
}

.product-overlay {
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background: rgba(0,0,0,0.7);
   display: flex;
   align-items: center;
   justify-content: center;
   opacity: 0;
   transition: opacity 0.3s ease;
}

.limited-product-card:hover .product-overlay {
   opacity: 1;
}

.drop-name {
   background: #007bff;
   color: white;
   padding: 3px 8px;
   border-radius: 12px;
   font-size: 0.75rem;
   margin-right: 5px;
}

.drop-month {
   color: #666;
   font-size: 0.85rem;
}

.product-title a {
   color: #222;
   text-decoration: none;
   font-weight: 600;
}

.product-title a:hover {
   color: #007bff;
}

.product-story {
   color: #666;
   font-size: 0.9rem;
   line-height: 1.5;
}

.current-price {
   font-size: 1.2rem;
   font-weight: 700;
   color: #007bff;
}

.old-price {
   font-size: 1rem;
   color: #999;
   text-decoration: line-through;
   margin-left: 10px;
}

.countdown-timer {
   margin-top: 10px;
}

.timer-display {
   font-weight: 600;
}

.empty-state {
   padding: 60px 0;
}

.newsletter-form .input-group {
   max-width: 500px;
   margin: 0 auto;
}

.newsletter-form .form-control {
   border: none;
   padding: 15px 20px;
   border-radius: 50px 0 0 50px;
   font-size: 1rem;
}

.newsletter-form .btn {
   border-radius: 0 50px 50px 0;
   padding: 15px 30px;
   font-weight: 600;
}

.p-20 { padding: 20px; }
.py-80 { padding-top: 80px; padding-bottom: 80px; }
.mb-10 { margin-bottom: 10px; }
.mb-20 { margin-bottom: 20px; }
.mb-30 { margin-bottom: 30px; }
.mb-40 { margin-bottom: 40px; }
.mb-60 { margin-bottom: 60px; }
.ml-2 { margin-left: 0.5rem; }
.pt-60 { padding-top: 60px; }
.pt-80 { padding-top: 80px; }
.pb-60 { padding-bottom: 60px; }
.pb-120 { padding-bottom: 120px; }

@media (max-width: 768px) {
   .hero-title { font-size: 2rem; }
   .hero-features { justify-content: center; }
   .feature-badge { font-size: 0.9rem; }
}
</style>

<script>
// Countdown Timer Function
function initCountdownTimers() {
    const timers = document.querySelectorAll('.countdown-timer');
    
    timers.forEach(timer => {
        const endTime = new Date(timer.dataset.endTime).getTime();
        const display = timer.querySelector('.timer-display');
        
        function updateTimer() {
            const now = new Date().getTime();
            const timeLeft = endTime - now;
            
            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                
                display.textContent = `${days}d ${hours}h ${minutes}m`;
            } else {
                display.textContent = 'Expired';
                timer.style.display = 'none';
            }
        }
        
        updateTimer();
        setInterval(updateTimer, 60000); // Update every minute
    });
}

// Initialize timers when page loads
document.addEventListener('DOMContentLoaded', initCountdownTimers);
</script>
@endsection