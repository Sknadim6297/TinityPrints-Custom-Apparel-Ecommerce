@extends('frontend.layout.app')

@section('title', 'Limited Edition')
@section('content')
    @php
        $frontendAsset = asset('frontend/assets');
        $pageConfig = $limitedEditionPage ?? [];
      $configuredHeroImage = $pageConfig['hero_image_url'] ?? '';
      $heroProduct = $limitedProducts->first();
      $heroProductImage = optional(optional($heroProduct)->images->first())->image_path;
      if (!empty($configuredHeroImage)) {
         $heroImageUrl = \Illuminate\Support\Str::startsWith($configuredHeroImage, ['http://', 'https://'])
            ? $configuredHeroImage
            : asset(ltrim($configuredHeroImage, '/'));
      } else {
         $heroImageUrl = $heroProductImage
            ? (\Illuminate\Support\Str::startsWith($heroProductImage, ['http://', 'https://']) ? $heroProductImage : Storage::url($heroProductImage))
            : asset('frontend/assets/img/product_category/product-cat-6.jpeg');
      }
    @endphp

<style>
   .limited-main-area { padding: 60px 0 90px; background: linear-gradient(180deg, #f7f7f7 0%, #ffffff 35%); }
   .limited-hero {
      border: 1px solid #e6e6e6;
      background: #fff;
      margin-bottom: 42px;
      display: grid;
      grid-template-columns: minmax(0, 1.08fr) minmax(0, 0.92fr);
      min-height: 480px;
      overflow: hidden;
   }
   .limited-hero-content { padding: 44px; display: flex; flex-direction: column; justify-content: center; }
   .limited-hero-badge { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 14px; color: #111; }
   .limited-hero-title { font-size: 42px; line-height: 1.08; margin-bottom: 16px; max-width: 640px; }
   .limited-hero-desc { color: #666; max-width: 560px; margin-bottom: 24px; font-size: 15px; line-height: 1.7; }
   .limited-features { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
   .limited-feature-chip { border: 1px solid #ddd; padding: 8px 12px; font-size: 12px; font-weight: 600; color: #111; background: #fafafa; }
   .limited-hero-cta { display: inline-flex; align-items: center; justify-content: center; width: fit-content; background: #111; color: #fff; text-decoration: none; padding: 12px 20px; font-size: 12px; letter-spacing: .7px; text-transform: uppercase; font-weight: 700; }
   .limited-hero-cta:hover { background: #333; color: #fff; }
   .limited-hero-visual { position: relative; }
   .limited-hero-visual::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(120deg, rgba(0, 0, 0, .02) 0%, rgba(0, 0, 0, .24) 100%);
      z-index: 1;
      pointer-events: none;
   }
   .limited-hero-visual img { width: 100%; height: 100%; object-fit: cover; }
   .limited-hero-stat {
      position: absolute;
      left: 24px;
      bottom: 24px;
      z-index: 2;
      background: rgba(0, 0, 0, .75);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, .25);
      padding: 10px 14px;
      font-size: 11px;
      letter-spacing: .7px;
      text-transform: uppercase;
      font-weight: 700;
   }

    .limited-header { text-align: center; margin-bottom: 26px; }
    .limited-header h2 { font-size: 30px; margin-bottom: 8px; }
    .limited-header p { color: #777; margin: 0; }

    .limited-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 28px; }
    .limited-card { background: #fff; }
    .limited-image-wrap { position: relative; overflow: hidden; height: 400px; }
    .limited-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
    .limited-card:hover .limited-image-wrap img { transform: scale(1.05); }

    .limited-badge { position: absolute; top: 12px; left: 12px; z-index: 2; background: #111; color: #fff; font-size: 11px; font-weight: 700; padding: 4px 10px; letter-spacing: .5px; text-transform: uppercase; }
    .limited-wishlist { position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; border: none; background: #fff; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,.2); z-index: 2; }
    .limited-cta { position: absolute; bottom: -50px; left: 0; width: 100%; background: #000; color: #fff; text-align: center; border: none; padding: 13px; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; transition: bottom .3s ease; }
    .limited-card:hover .limited-cta { bottom: 0; }

    .limited-info { padding: 14px 0 10px; }
    .limited-name { font-size: 14px; font-weight: 700; margin-bottom: 6px; line-height: 1.35; }
    .limited-name a { color: #111; text-decoration: none; }
    .limited-name a:hover { color: #555; }
    .limited-price { font-size: 14px; color: #e53935; font-weight: 700; margin-bottom: 6px; }
    .limited-meta { font-size: 12px; color: #777; text-transform: none; letter-spacing: .2px; }

    .limited-empty { text-align: center; border: 1px dashed #ddd; padding: 40px 20px; color: #666; }
    .limited-empty h3 { font-size: 22px; margin-bottom: 8px; color: #111; }

    .limited-browse { margin-top: 26px; text-align: center; }
    .limited-browse .browse-btn { background: #000; color: #fff; text-decoration: none; padding: 12px 22px; font-size: 12px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; display: inline-block; }
    .limited-browse .browse-btn:hover { background: #333; color: #fff; }

    .limited-pagination { margin-top: 44px; display: flex; justify-content: center; }
    .limited-pagination .pagination { display: flex; gap: 4px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center; }
    .limited-pagination .pagination li a,
    .limited-pagination .pagination li span { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 10px; border: 1px solid #ddd; color: #333; text-decoration: none; font-size: 13px; transition: all .2s; background: #fff; }
    .limited-pagination .pagination li.active span { background: #000; color: #fff; border-color: #000; }
    .limited-pagination .pagination li a:hover { background: #000; color: #fff; border-color: #000; }

   @media(max-width: 1200px) {
      .limited-hero-title { font-size: 34px; }
      .limited-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
   }
    @media(max-width: 768px) {
      .limited-main-area { padding: 42px 0 72px; }
      .limited-hero { grid-template-columns: 1fr; min-height: auto; }
      .limited-hero-content { padding: 26px 22px 24px; }
      .limited-hero-title { font-size: 29px; }
      .limited-hero-visual { min-height: 290px; }
      .limited-hero-stat { left: 14px; bottom: 14px; font-size: 10px; }
        .limited-grid { gap: 14px; }
        .limited-image-wrap { height: 260px; }
    }
    @media(max-width: 480px) { .limited-grid { grid-template-columns: 1fr; } }
</style>

<section class="page-title-area" data-background="{{ $frontendAsset }}/img/banner/banner-1-1.jpeg">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">{{ $pageConfig['page_title'] ?? 'Limited Edition' }}</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end"><span>{{ $pageConfig['page_title'] ?? 'Limited Edition' }}</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="limited-main-area">
   <div class="container">
      <div class="limited-hero">
         <div class="limited-hero-content">
            <span class="limited-hero-badge">{{ $pageConfig['hero_badge'] ?? 'EXCLUSIVE COLLECTION' }}</span>
            <h2 class="limited-hero-title">{{ $pageConfig['hero_title'] ?? 'Limited Edition Drops' }}</h2>
            <p class="limited-hero-desc">{{ $pageConfig['hero_description'] ?? 'Discover our exclusive limited edition collections featuring unique designs, premium materials, and special collaborations. Each piece is carefully crafted in limited quantities, making them true collector\'s items.' }}</p>
            <div class="limited-features">
               <span class="limited-feature-chip">{{ $pageConfig['feature_1'] ?? 'Premium Quality' }}</span>
               <span class="limited-feature-chip">{{ $pageConfig['feature_2'] ?? 'Limited Time Only' }}</span>
               <span class="limited-feature-chip">{{ $pageConfig['feature_3'] ?? 'Exclusive Designs' }}</span>
            </div>
            <a href="#limited-products" class="limited-hero-cta">Explore Drops</a>
         </div>
         <div class="limited-hero-visual">
            <img src="{{ $heroImageUrl }}" alt="Limited edition hero">
            <span class="limited-hero-stat">Limited Pieces | New Drop</span>
         </div>
      </div>

      <div id="limited-products" class="limited-header">
         <h2>{{ $pageConfig['products_title'] ?? 'Current Limited Edition Drops' }}</h2>
         <p>{{ $pageConfig['products_subtitle'] ?? 'Get them before they\'re gone forever' }}</p>
      </div>

      <div class="limited-grid">
         @forelse($limitedProducts as $product)
         @php
            $productImage = optional($product->images->first())->image_path;
            $imageUrl = $productImage
               ? (\Illuminate\Support\Str::startsWith($productImage, ['http://', 'https://']) ? $productImage : Storage::url($productImage))
               : asset('frontend/assets/img/product_category/product-cat-6.jpeg');
         @endphp
         <div class="limited-card">
            <div class="limited-image-wrap">
               <span class="limited-badge">{{ $limitedEditionConfig['badge_text'] ?? 'LIMITED' }}</span>
               <button type="button" class="limited-wishlist add-to-wishlist-btn" data-product-id="{{ $product->id }}" aria-label="Add to wishlist" onclick="return window.tinnityToggleWishlist(event, this);">
                  <i class="far fa-heart"></i>
               </button>
               <a href="{{ route('product.details', $product->id) }}" style="display:block;width:100%;height:100%;">
                  <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
               </a>
               <a href="{{ route('product.details', $product->id) }}" class="limited-cta">View Product</a>
            </div>
            <div class="limited-info">
               <div class="limited-name"><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></div>
               <div class="limited-price">INR {{ number_format($product->price, 2) }}</div>
               @if($product->drop_name || $product->drop_month)
               <div class="limited-meta">
                  @if($product->drop_name)
                     {{ $product->drop_name }}
                  @endif
                  @if($product->drop_month)
                     {{ $product->drop_name ? ' • ' : '' }}{{ $product->drop_month }} Drop
                  @endif
               </div>
               @endif
               @if($product->stock_limit)
               <div class="limited-meta" style="color:#b91c1c;">Only {{ $product->totalStock() }} left!</div>
               @endif
            </div>
         </div>
         @empty
         <div class="limited-empty" style="grid-column: 1 / -1;">
            <h3>{{ $pageConfig['empty_title'] ?? 'No Limited Edition Items Available' }}</h3>
            <p>{{ $pageConfig['empty_text'] ?? 'Please check back soon for new exclusive drops.' }}</p>
         </div>
         @endforelse
      </div>

      <div class="limited-browse">
         <a href="{{ $pageConfig['browse_link'] ?? route('shop') }}" class="browse-btn">{{ $pageConfig['browse_text'] ?? 'Browse Regular Collection' }}</a>
      </div>

      @if($limitedProducts->hasPages())
      <div class="limited-pagination">
         <nav aria-label="Limited edition pagination">
            <ul class="pagination">
               <li class="{{ $limitedProducts->onFirstPage() ? 'disabled' : '' }}">
                  @if($limitedProducts->onFirstPage())
                     <span aria-disabled="true">Previous</span>
                  @else
                     <a href="{{ $limitedProducts->previousPageUrl() }}" rel="prev">Previous</a>
                  @endif
               </li>
               @for($page = 1; $page <= $limitedProducts->lastPage(); $page++)
                  <li class="{{ $limitedProducts->currentPage() === $page ? 'active' : '' }}">
                     @if($limitedProducts->currentPage() === $page)
                        <span aria-current="page">{{ $page }}</span>
                     @else
                        <a href="{{ $limitedProducts->url($page) }}">{{ $page }}</a>
                     @endif
                  </li>
               @endfor
               <li class="{{ $limitedProducts->hasMorePages() ? '' : 'disabled' }}">
                  @if($limitedProducts->hasMorePages())
                     <a href="{{ $limitedProducts->nextPageUrl() }}" rel="next">Next</a>
                  @else
                     <span aria-disabled="true">Next</span>
                  @endif
               </li>
            </ul>
         </nav>
      </div>
      @endif
   </div>
</section>
@endsection