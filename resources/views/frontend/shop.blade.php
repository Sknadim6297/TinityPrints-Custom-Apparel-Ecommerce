@extends('frontend.layout.app')

@section('title', ($pageTitle ?? 'Shop') === 'Shop' ? 'Shop' : ($pageTitle ?? 'Shop') . ' - Shop')

@section('content')

    <style>
        .shop-main-area { padding: 60px 0 80px; }
        .shop-layout { display: flex; gap: 40px; align-items: flex-start; }

        .filter-sidebar {
            width: 280px; flex-shrink: 0; background: #fff;
            padding: 20px; border: 1px solid #eee;
            position: sticky; top: 100px;
        }
        .filter-header { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .filter-header h4 { font-size: 13px; font-weight: 700; letter-spacing: 1px; margin-bottom: 4px; }
        .product-count { font-size: 12px; color: #888; }
        .filter-group { margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid #f0f0f0; }
        .filter-group:last-of-type { border-bottom: none; }
        .filter-group h5 { font-size: 11px; margin-bottom: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #333; }
        .filter-options label { display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 6px; cursor: pointer; color: #444; }
        .filter-options label:hover { color: #000; }
        .filter-options input[type="checkbox"] { width: 14px; height: 14px; cursor: pointer; accent-color: #000; }

        .color-options { display: flex; gap: 8px; flex-wrap: wrap; }
        .color-swatch { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #ddd; cursor: pointer; transition: transform .2s, border-color .2s; display: inline-block; }
        .color-swatch:hover { transform: scale(1.15); }
        .color-swatch.selected { border-color: #000; transform: scale(1.15); box-shadow: 0 0 0 2px #fff, 0 0 0 4px #000; }

        .price-range-wrap { padding: 4px 0; }
        .price-display { display: flex; justify-content: space-between; font-size: 12px; color: #555; margin-bottom: 10px; font-weight: 600; }
        .price-slider-track { position: relative; height: 4px; background: #ddd; border-radius: 2px; margin: 8px 0 6px; }
        .price-slider-track input[type="range"] { position: absolute; width: 100%; height: 4px; background: none; pointer-events: none; -webkit-appearance: none; margin: 0; top: 0; }
        .price-slider-track input[type="range"]::-webkit-slider-thumb { -webkit-appearance: none; width: 16px; height: 16px; border-radius: 50%; background: #000; cursor: pointer; pointer-events: all; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,.3); }
        .price-slider-track input[type="range"]::-moz-range-thumb { width: 16px; height: 16px; border-radius: 50%; background: #000; cursor: pointer; pointer-events: all; border: 2px solid #fff; }

        .switch { position: relative; display: inline-block; width: 38px; height: 20px; margin-right: 8px; }
        .switch input { display: none; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #ccc; border-radius: 20px; transition: .3s; }
        .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .3s; }
        input:checked + .slider { background: #000; }
        input:checked + .slider:before { transform: translateX(18px); }
        .stock-toggle-row { display: flex; align-items: center; }
        .stock-label { font-size: 13px; color: #444; }

        .filter-group select { width: 100%; padding: 8px 10px; font-size: 13px; border: 1px solid #ddd; background: #fff; cursor: pointer; outline: none; }
        .filter-text-input { width: 100%; padding: 9px 10px; font-size: 13px; border: 1px solid #ddd; background: #fff; outline: none; }
        .filter-text-input:focus { border-color: #999; }
        .filter-buttons { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
        .clear-btn { background: none; border: none; font-size: 12px; color: #999; cursor: pointer; text-decoration: none; letter-spacing: .5px; text-transform: uppercase; }
        .clear-btn:hover { color: #333; }
        .apply-btn { background: #000; color: #fff; border: none; padding: 10px 22px; font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; cursor: pointer; transition: background .2s; text-decoration: none; display: inline-block; }
        .apply-btn:hover { background: #333; color: #fff; }

        .mobile-filter-bar { display: none; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 12px 0; border-bottom: 1px solid #eee; }
        .mobile-filter-toggle { display: flex; align-items: center; gap: 8px; background: none; border: 1px solid #000; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; }

        .products-area { flex: 1; min-width: 0; }
        .results-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #eee; }
        .results-count { font-size: 13px; color: #888; }

        .product-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .product-card { background: #fff; }
        .product-image { position: relative; height: 400px; overflow: hidden; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
        .product-card:hover .product-image img { transform: scale(1.05); }
        .product-badge { position: absolute; top: 12px; left: 12px; background: #ff3b30; color: #fff; font-size: 11px; font-weight: 600; padding: 4px 10px; letter-spacing: .5px; z-index: 2; }
        .product-badge.badge-limited { background: #1a1a1a; }

        .wishlist-btn { position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; border: none; background: #fff; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,.2); z-index: 2; transition: background .2s; display: flex; align-items: center; justify-content: center; font-size: 15px; }
        .wishlist-btn:hover { background: #ffe4e4; }
        .wishlist-btn.wl-active i { color: #e60023 !important; }

        .add-cart-btn { position: absolute; bottom: -50px; left: 0; width: 100%; background: #000; color: #fff; border: none; padding: 13px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; transition: bottom .3s ease; cursor: pointer; z-index: 2; }
        .product-card:hover .add-cart-btn { bottom: 0; }

        .product-info { padding: 14px 0 10px; }
        .product-title { font-size: 13px; font-weight: 600; margin-bottom: 6px; line-height: 1.4; }
        .product-title a { text-decoration: none; color: #111; }
        .product-title a:hover { color: #555; }
        .product-price { font-size: 13px; }
        .base-price { color: #333; font-weight: 600; }
        .product-category-tag { font-size: 11px; color: #aaa; margin-top: 4px; text-transform: uppercase; letter-spacing: .4px; }

        .no-products { text-align: center; padding: 80px 20px; color: #888; }
        .no-products p { font-size: 16px; margin-bottom: 20px; }

        .shop-pagination { margin-top: 50px; display: flex; justify-content: center; }
        .shop-pagination nav { display: flex; justify-content: center; }
        .shop-pagination .pagination { display: flex; gap: 4px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center; }
        .shop-pagination .pagination li a,
        .shop-pagination .pagination li span { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 10px; border: 1px solid #ddd; color: #333; text-decoration: none; font-size: 13px; transition: all .2s; background: #fff; }
        .shop-pagination .pagination li.active span { background: #000; color: #fff; border-color: #000; }
        .shop-pagination .pagination li a:hover { background: #000; color: #fff; border-color: #000; }

        .filter-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9998; }
        .filter-overlay.active { display: block; }

        @media(max-width: 1200px) {
            .product-grid { grid-template-columns: repeat(2, 1fr); }
            .filter-sidebar { display: none; position: fixed; top: 0; left: 0; height: 100vh; z-index: 9999; overflow-y: auto; width: 300px; box-shadow: 4px 0 20px rgba(0,0,0,.2); }
            .filter-sidebar.mobile-open { display: block; }
            .mobile-filter-bar { display: flex; }
        }
        @media(max-width: 768px) { .product-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } .product-image { height: 250px; } }
        @media(max-width: 480px) { .product-grid { grid-template-columns: 1fr; } }
    </style>

    <section class="page-title-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">
                            {{ $pageTitle ?? 'Shop' }}
                        </h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                    <li class="trail-item {{ ($pageTitle ?? 'Shop') === 'Shop' ? 'trail-end' : '' }}"><a href="{{ route('shop') }}"><span>Shop</span></a></li>
                                    @if(($pageTitle ?? 'Shop') !== 'Shop')
                                        <li class="trail-item trail-end"><span>{{ $pageTitle }}</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-main-area">
        <div class="container">

            <div class="filter-overlay" id="filter-overlay"></div>

            <div class="mobile-filter-bar">
                <button class="mobile-filter-toggle" id="mobile-filter-btn" type="button">
                    <i class="fas fa-sliders-h"></i> Filters
                    @php
                        $activeCount = 0;
                        $activeCount += request()->filled('search') ? 1 : 0;
                        $activeCount += request()->filled('min_price') ? 1 : 0;
                        $activeCount += request()->filled('max_price') ? 1 : 0;
                        $activeCount += (request('stock') && request('stock') !== 'all') || request('in_stock') ? 1 : 0;
                        $activeCount += request('edition') && request('edition') !== 'all' ? 1 : 0;
                        $activeCount += request('story') && request('story') !== 'all' ? 1 : 0;
                        $activeCount += count((array) request('size', []));
                        $activeCount += count((array) request('category_id', []));
                        $activeCount += count((array) request('sleeve_type', []));
                        $activeCount += count((array) request('collection_type_id', []));
                        $activeCount += count((array) request('color', []));
                    @endphp
                    @if($activeCount > 0)
                        <span style="background:#000;color:#fff;border-radius:50%;width:18px;height:18px;font-size:10px;display:inline-flex;align-items:center;justify-content:center;margin-left:4px;">{{ $activeCount }}</span>
                    @endif
                </button>
                <span class="results-count">{{ $products->total() }} products</span>
            </div>

            <div class="shop-layout">

                <div class="filter-sidebar" id="filter-sidebar">
                    <button id="close-filter-btn" type="button"
                        style="display:none;position:absolute;top:14px;right:14px;background:none;border:none;font-size:22px;cursor:pointer;line-height:1;">&times;</button>

                    <form action="{{ $category ? route('shop.category', $category) : route('shop') }}" method="GET" id="filter-form">

                        <div class="filter-header">
                            <h4>FILTER AND SORT</h4>
                            <span class="product-count">{{ $products->total() }} PRODUCTS</span>
                        </div>

                        @if(!$category && request()->filled('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <div class="filter-group">
                            <h5>SEARCH</h5>
                            <input type="text" name="search" value="{{ request('search') }}" class="filter-text-input" placeholder="Search products...">
                        </div>

                        <div class="filter-group">
                            <h5>STOCK</h5>
                            <div class="filter-options">
                                <label>
                                    <input type="radio" name="stock" value="all" {{ ($stockFilter ?? request('stock', 'all')) === 'all' ? 'checked' : '' }}>
                                    All
                                </label>
                                <label>
                                    <input type="radio" name="stock" value="in" {{ ($stockFilter ?? request('stock')) === 'in' || request('in_stock') ? 'checked' : '' }}>
                                    In Stock
                                </label>
                                <label>
                                    <input type="radio" name="stock" value="out" {{ ($stockFilter ?? request('stock')) === 'out' ? 'checked' : '' }}>
                                    Out of Stock
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h5>PRICE</h5>
                            <div class="price-range-wrap">
                                <div class="price-display">
                                    <span>Rs.<span id="min-price-display">{{ number_format((int)request('min_price', 0)) }}</span></span>
                                    <span>Rs.<span id="max-price-display">{{ number_format((int)request('max_price', $maxPrice)) }}</span></span>
                                </div>
                                <div class="price-slider-track">
                                    <input type="range" id="min-price-slider"
                                        min="0" max="{{ $maxPrice }}" step="50"
                                        value="{{ (int)request('min_price', 0) }}">
                                    <input type="range" id="max-price-slider"
                                        min="0" max="{{ $maxPrice }}" step="50"
                                        value="{{ (int)request('max_price', $maxPrice) }}">
                                </div>
                                <input type="hidden" name="min_price" id="min-price-input" value="{{ request('min_price', '') }}">
                                <input type="hidden" name="max_price" id="max-price-input" value="{{ request('max_price', '') }}">
                            </div>
                        </div>

                        <div class="filter-group">
                            <h5>SIZE</h5>
                            <div class="filter-options">
                                @foreach($availableSizes as $size)
                                    <label>
                                        <input type="checkbox" name="size[]"
                                            value="{{ strtolower($size) }}"
                                            {{ in_array(strtolower($size), array_map('strtolower', (array) request('size', []))) ? 'checked' : '' }}>
                                        {{ strtoupper($size) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        @if(count($availableSleeveTypes) > 0)
                        <div class="filter-group">
                            <h5>SLEEVE TYPE</h5>
                            <div class="filter-options">
                                @foreach($availableSleeveTypes as $sleeveType)
                                    <label>
                                        <input type="checkbox" name="sleeve_type[]"
                                            value="{{ $sleeveType }}"
                                            {{ in_array($sleeveType, (array) request('sleeve_type', [])) ? 'checked' : '' }}>
                                        {{ ucfirst(str_replace(['-', '_'], ' ', $sleeveType)) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($collectionOptions->count() > 0)
                        <div class="filter-group">
                            <h5>COLLECTION TYPE</h5>
                            <div class="filter-options">
                                @foreach($collectionOptions as $collection)
                                    <label>
                                        <input type="checkbox" name="collection_type_id[]"
                                            value="{{ $collection->id }}"
                                            {{ in_array($collection->id, array_map('intval', (array) request('collection_type_id', []))) ? 'checked' : '' }}>
                                        {{ $collection->name }}
                                        <span style="color:#bbb;font-size:11px;">({{ $collection->active_products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($categoryOptions->count() > 0)
                        <div class="filter-group">
                            <h5>CATEGORY</h5>
                            <div class="filter-options">
                                @foreach($categoryOptions as $cat)
                                    <label>
                                        <input type="checkbox" name="category_id[]"
                                            value="{{ $cat->id }}"
                                            {{ in_array($cat->id, (array) request('category_id', [])) ? 'checked' : '' }}>
                                        {{ $cat->name }}
                                        <span style="color:#bbb;font-size:11px;">({{ $cat->active_products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(count($availableColors) > 0)
                        <div class="filter-group">
                            <h5>COLOR</h5>
                            <div class="color-options" id="color-swatches">
                                @foreach($availableColors as $clr)
                                    @php
                                        $cSlug    = Str::slug($clr['name']);
                                        $bgStyle  = !empty($clr['hex']) ? $clr['hex'] : $clr['name'];
                                        $cChecked = in_array($clr['name'], (array) request('color', []));
                                    @endphp
                                    <span class="color-swatch {{ $cChecked ? 'selected' : '' }}"
                                          style="background:{{ $bgStyle }}"
                                          title="{{ $clr['name'] }}"
                                          data-slug="{{ $cSlug }}"></span>
                                    <input type="checkbox"
                                           name="color[]"
                                           value="{{ $clr['name'] }}"
                                           id="color-cb-{{ $cSlug }}"
                                           class="color-checkbox"
                                           style="display:none"
                                           {{ $cChecked ? 'checked' : '' }}>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="filter-group">
                            <h5>EDITION</h5>
                            <div class="filter-options">
                                <label>
                                    <input type="radio" name="edition" value="all" {{ ($editionFilter ?? request('edition', 'all')) === 'all' ? 'checked' : '' }}>
                                    All
                                </label>
                                <label>
                                    <input type="radio" name="edition" value="limited" {{ ($editionFilter ?? request('edition')) === 'limited' || request('limited_edition') ? 'checked' : '' }}>
                                    Limited Edition
                                </label>
                                <label>
                                    <input type="radio" name="edition" value="regular" {{ ($editionFilter ?? request('edition')) === 'regular' ? 'checked' : '' }}>
                                    Regular
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h5>STORY</h5>
                            <div class="filter-options">
                                <label>
                                    <input type="radio" name="story" value="all" {{ ($storyFilter ?? request('story', 'all')) === 'all' ? 'checked' : '' }}>
                                    All
                                </label>
                                <label>
                                    <input type="radio" name="story" value="has" {{ ($storyFilter ?? request('story')) === 'has' ? 'checked' : '' }}>
                                    Has Story
                                </label>
                                <label>
                                    <input type="radio" name="story" value="none" {{ ($storyFilter ?? request('story')) === 'none' ? 'checked' : '' }}>
                                    No Story
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h5>SORT BY</h5>
                            <select name="sort" onchange="this.form.submit()">
                                <option value="default"    {{ request('sort','default') == 'default'    ? 'selected' : '' }}>Featured</option>
                                <option value="newest"     {{ request('sort') == 'newest'               ? 'selected' : '' }}>Newest</option>
                                <option value="price_low"  {{ request('sort') == 'price_low'            ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high'           ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc"   {{ request('sort') == 'name_asc'             ? 'selected' : '' }}>Name: A to Z</option>
                                <option value="name_desc"  {{ request('sort') == 'name_desc'            ? 'selected' : '' }}>Name: Z to A</option>
                            </select>
                        </div>

                        <div class="filter-buttons">
                            <a href="{{ route('shop') }}" class="clear-btn">CLEAR ALL</a>
                            <button type="submit" class="apply-btn">APPLY</button>
                        </div>

                    </form>
                </div>

                <div class="products-area">

                    <div class="results-bar">
                        <span class="results-count">
                            @if($products->total() > 0)
                                Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products
                            @else
                                No products found
                            @endif
                        </span>
                        @php
                            $activeCount = $activeCount ?? 0;
                        @endphp
                        @if($activeCount > 0)
                            <a href="{{ route('shop') }}" style="font-size:12px;color:#999;text-decoration:none;">x Clear filters ({{ $activeCount }})</a>
                        @endif
                    </div>

                    @if($products->count() > 0)

                        <div class="product-grid">
                            @foreach($products as $product)
                                @php
                                    $firstImg = $product->images->first();
                                    $imgUrl   = $firstImg
                                        ? asset('storage/' . $firstImg->image_path)
                                        : asset('frontend/assets/img/product_category/product-cat-6.jpeg');
                                @endphp

                                <div class="product-card">
                                    <div class="product-image">

                                        @if($product->is_limited_edition)
                                            <span class="product-badge badge-limited">LIMITED</span>
                                        @endif

                                        <button class="wishlist-btn" type="button"
                                                onclick="event.stopPropagation(); addToWishlist({{ $product->id }}, this)"
                                                title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>

                                        <a href="{{ route('product.details', $product->id) }}" style="display:block;width:100%;height:100%;">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}" loading="lazy">
                                        </a>

                                        <button class="add-cart-btn" type="button"
                                            onclick="window.location='{{ route('product.details', $product->id) }}'">
                                            SELECT OPTIONS
                                        </button>

                                    </div>

                                    <div class="product-info">
                                        <h4 class="product-title">
                                            <a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="product-price">
                                            <span class="base-price">Rs.{{ number_format($product->base_price, 2) }}</span>
                                        </div>
                                        @if($product->relationLoaded('category') && $product->getRelation('category'))
                                            <div class="product-category-tag">{{ $product->getRelation('category')->name }}</div>
                                        @endif
                                    </div>
                                </div>

                            @endforeach
                        </div>

                        @if($products->hasPages())
                            <div class="shop-pagination">
                                {{ $products->links() }}
                            </div>
                        @endif

                    @else
                        <div class="no-products">
                            <i class="fas fa-search" style="font-size:48px;color:#ddd;display:block;margin-bottom:20px;"></i>
                            <p>No products found matching your filters.</p>
                            <a href="{{ route('shop') }}" class="apply-btn">CLEAR FILTERS</a>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    <script>
        const SHOP_MAX_PRICE = {{ $maxPrice }};

        const minSlider  = document.getElementById('min-price-slider');
        const maxSlider  = document.getElementById('max-price-slider');
        const minDisplay = document.getElementById('min-price-display');
        const maxDisplay = document.getElementById('max-price-display');
        const minInput   = document.getElementById('min-price-input');
        const maxInput   = document.getElementById('max-price-input');

        function fmtNum(n) { return parseInt(n).toLocaleString('en-IN'); }

        function syncSliders() {
            let lo = parseInt(minSlider.value);
            let hi = parseInt(maxSlider.value);
            if (lo > hi) { minSlider.value = hi; lo = hi; }
            if (hi < lo) { maxSlider.value = lo; hi = lo; }
            minDisplay.textContent = fmtNum(lo);
            maxDisplay.textContent = fmtNum(hi);
            minInput.value = lo > 0             ? lo : '';
            maxInput.value = hi < SHOP_MAX_PRICE ? hi : '';
        }

        if (minSlider && maxSlider) {
            minSlider.addEventListener('input', syncSliders);
            maxSlider.addEventListener('input', syncSliders);
        }

        document.querySelectorAll('#color-swatches .color-swatch').forEach(function(sw) {
            sw.addEventListener('click', function() {
                var slug = this.dataset.slug;
                var cb   = document.getElementById('color-cb-' + slug);
                if (cb) {
                    cb.checked = !cb.checked;
                    this.classList.toggle('selected', cb.checked);
                }
            });
        });

        var sidebar  = document.getElementById('filter-sidebar');
        var overlay  = document.getElementById('filter-overlay');
        var openBtn  = document.getElementById('mobile-filter-btn');
        var closeBtn = document.getElementById('close-filter-btn');

        function openFilterSidebar() {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
            if (closeBtn) closeBtn.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeFilterSidebar() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            if (closeBtn) closeBtn.style.display = 'none';
            document.body.style.overflow = '';
        }

        if (openBtn)  openBtn.addEventListener('click', openFilterSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeFilterSidebar);
        if (overlay)  overlay.addEventListener('click', closeFilterSidebar);

        function addToWishlist(productId, btn) {
            @auth
            if (btn.disabled) return;
            btn.disabled = true;
            fetch('{{ route("wishlist.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {getAttribute: function(){return '{{ csrf_token() }}';}}).getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                btn.classList.add('wl-active');
                var icon = btn.querySelector('i');
                if (icon) { icon.className = 'fas fa-heart'; icon.style.color = '#e60023'; }
            })
            .catch(function() {})
            .finally(function() { btn.disabled = false; });
            @else
            window.location = '{{ route("login") }}';
            @endauth
        }
    </script>

@endsection
