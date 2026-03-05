@extends('frontend.layout.app')

@section('title', 'Shop')
@section('content')
<style>
 /* FIX PRODUCT IMAGE SIZE */

.single-product .product-image{
    width:100%;
    height:320px;
    overflow:hidden;
    position:relative;
}

/* IMAGE */
.single-product .product-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

/* PRODUCT CARD */
.single-product{
    width:100%;
}

/* PRODUCT DESCRIPTION */
.product-desc{
    padding:15px;
    text-align:center;
}
</style>
<!-- page title area start  -->
      <section class="page-title-area" data-background="assets/img/bg/page-title-bg.html">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="page-title-wrapper text-center">
                     <h1 class="page-title mb-10">
                        @if($category == 't-shirt')
                           T-Shirts
                        @elseif($category == 'accessories')
                           Accessories
                        @else
                           Shop
                        @endif
                     </h1>
                     <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                           <ul class="trail-items">
                              <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                              @if($category)
                                 <li class="trail-item"><a href="{{ route('shop') }}"><span>Shop</span></a></li>
                                 <li class="trail-item trail-end">
                                    <span>{{ $category == 't-shirt' ? 'T-Shirts' : 'Accessories' }}</span>
                                 </li>
                              @else
                                 <li class="trail-item trail-end"><span>Shop</span></li>
                              @endif
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- page title area end  -->

      <!-- shop main area start  -->
      <div class="shop-main-area pt-120 pb-10">
         <div class="container">
            <div class="row">
               <div class="col-xl-9 col-lg-8 col-md-12">
                  <div class="shop-main-wrapper mb-60">
                     <div class="shop-main-wrapper-head mb-30">
                        <div class="swowing-list">Showing <span>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</span> Products</div>
                        <div class="sort-type-filter">
                           <div class="sorting-type">
                              <span>Sort by : </span>
                              <select class="sorting-list" name="sorting-list" id="sorting-list" onchange="updateSort(this.value)">
                                 <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Default</option>
                                 <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                 <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                 <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                 <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                 <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                              </select>
                           </div>
                           <div class="action-item action-item-filter d-lg-none">
                              <a href="javascript:void(0)" class="view-filter-button">
                                 <i class="flaticon-filter"></i>
                              </a>
                           </div>
                        </div>
                     </div>

                     <!-- Active Filters Display -->
                     @if(request()->hasAny(['search', 'category', 'size', 'color', 'sleeve_type', 'limited_edition', 'min_price', 'max_price']))
                     <div class="active-filters mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                        <h6 class="mb-2" style="color: var(--clr-common-heading); font-weight: 600;">Active Filters:</h6>
                        <div class="filter-tags d-flex flex-wrap align-items-center">
                           @if(request('search'))
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">Search: "{{ request('search') }}" <a href="{{ request()->fullUrlWithoutQuery('search') }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                           @endif
                           @if(request('category'))
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">{{ request('category') == 't-shirt' ? 'T-Shirts' : 'Accessories' }} <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                           @endif
                           @if(request('limited_edition'))
                              <span class="badge mr-2 mb-2" style="background-color: #ffc107; color: #000; padding: 8px 12px; border-radius: 20px; font-weight: 600;">Limited Edition <a href="{{ request()->fullUrlWithoutQuery('limited_edition') }}" class="ml-1" style="text-decoration: none; color: #000; font-weight: bold;">×</a></span>
                           @endif
                           @if(request('size'))
                              @foreach((array)request('size') as $size)
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">Size: {{ $size }} <a href="{{ request()->fullUrlWithoutQuery(['size']) }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                              @endforeach
                           @endif
                           @if(request('color'))
                              @foreach((array)request('color') as $color)
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">Color: {{ $color }} <a href="{{ request()->fullUrlWithoutQuery(['color']) }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                              @endforeach
                           @endif
                           @if(request('sleeve_type'))
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">{{ ucfirst(request('sleeve_type')) }} Sleeve <a href="{{ request()->fullUrlWithoutQuery('sleeve_type') }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                           @endif
                           @if(request('min_price') || request('max_price'))
                              <span class="badge mr-2 mb-2" style="background-color: var(--clr-common-heading); color: white; padding: 8px 12px; border-radius: 20px;">Price: £{{ request('min_price', 0) }} - £{{ request('max_price', '∞') }} <a href="{{ request()->fullUrlWithoutQuery(['min_price', 'max_price']) }}" class="ml-1 text-white" style="text-decoration: none; font-weight: bold;">×</a></span>
                           @endif
                           <a href="{{ route('shop') }}" class="btn btn-sm ml-2" style="background-color: transparent; border: 2px solid var(--clr-common-heading); color: var(--clr-common-heading); padding: 6px 16px; border-radius: 20px; font-weight: 600; transition: all 0.3s;">Clear All</a>
                        </div>
                     </div>
                     @endif
                     
                     <div class="products-wrapper">
                        @forelse($products as $product)
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
                              @if($product->is_limited_edition)
                              <div class="product-sticker-wrapper">
                                 <span class="product-sticker new">Limited</span>
                              </div>
                              @elseif($product->created_at >= now()->subDays(30))
                              <div class="product-sticker-wrapper">
                                 <span class="product-sticker new">New</span>
                              </div>
                              @endif
                           </div>
                           <div class="product-desc">
                              <div class="product-name"><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></div>
                              <div class="product-price">
                                 <span class="price-now">INR {{ number_format($product->price, 2) }}</span>
                              </div>
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
                           <div class="text-center py-5">
                              <i class="fas fa-box-open" style="font-size: 64px; color: var(--clr-common-border); margin-bottom: 20px;"></i>
                              <h3 style="color: var(--clr-common-heading);">No products found</h3>
                              <p style="color: var(--clr-common-text);">Try adjusting your filters or check back later for new products.</p>
                              <a href="{{ route('shop') }}" class="btn mt-3" 
                                 style="background-color: var(--clr-common-heading); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none;">
                                 Clear Filters
                              </a>
                           </div>
                        </div>
                        @endforelse
                     </div>

                  </div>
               </div>
               <div class="col-xl-3 col-lg-4 col-md-6">
                  <div class="sidebar-widget-wrapper mb-110 d-none d-lg-block">
                     <form method="GET" action="{{ route('shop', $category ?? '') }}" id="filter-form">
                        <div class="product-filters mb-50">
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Search</h4>
                              <div class="filter-widget-content">
                                 <div class="filter-widget-search">
                                    <input type="text" name="search" placeholder="Search here.." value="{{ request('search') }}">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Category</h4>
                              <div class="filter-widget-content">
                                 <div class="category-items">
                                    <a href="{{ route('shop') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                                       <div class="category-name">All Products</div> 
                                       <span class="category-items-number">{{ $totalProducts ?? 0 }}</span>
                                    </a>
                                    <a href="{{ route('shop', ['category' => 't-shirt'] + request()->except('category')) }}" class="category-item {{ request('category') == 't-shirt' ? 'active' : '' }}">
                                       <div class="category-name"><i class="fas fa-tshirt mr-2"></i>T-Shirts</div> 
                                       <span class="category-items-number">{{ $categoryStats['t-shirt'] ?? 0 }}</span>
                                    </a>
                                    <a href="{{ route('shop', ['category' => 'accessories'] + request()->except('category')) }}" class="category-item {{ request('category') == 'accessories' ? 'active' : '' }}">
                                       <div class="category-name"><i class="fas fa-gem mr-2"></i>Accessories</div> 
                                       <span class="category-items-number">{{ $categoryStats['accessories'] ?? 0 }}</span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn"><i class="fas fa-fire mr-2" style="color: #ffc107;"></i>Limited Edition</h4>
                              <div class="filter-widget-content">
                                 <div class="category-items">
                                    <a href="{{ route('shop', ['limited_edition' => 'yes'] + request()->except('limited_edition')) }}" class="category-item {{ request('limited_edition') == 'yes' ? 'active' : '' }}" style="{{ request('limited_edition') == 'yes' ? 'background-color: #fff3cd; border-left-color: #ffc107;' : '' }}">
                                       <div class="category-name">Limited Edition Only</div> 
                                       <span class="category-items-number" style="{{ request('limited_edition') == 'yes' ? 'color: #ffc107; font-weight: 600;' : '' }}">{{ $categoryStats['limited_edition'] ?? 0 }}</span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Size</h4>
                              <div class="filter-widget-content">
                                 <div class="category-sizes">
                                    @foreach(['XS' => 'Extra Small', 'S' => 'Small', 'M' => 'Medium', 'L' => 'Large', 'XL' => 'Extra Large', 'XXL' => 'Double XL'] as $sizeKey => $sizeName)
                                    <div class="category-size">
                                       <input class="check-box" type="checkbox" name="size[]" value="{{ $sizeKey }}" id="size-{{ $sizeKey }}" {{ in_array($sizeKey, (array)request('size', [])) ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()">
                                       <label class="check-label" for="size-{{ $sizeKey }}">{{ $sizeName }}</label>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                           
                           @if(isset($availableSleeveTypes) && count($availableSleeveTypes) > 0)
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Sleeve Type</h4>
                              <div class="filter-widget-content">
                                 <div class="category-sizes">
                                    @foreach($availableSleeveTypes as $sleeveType)
                                    <div class="category-size">
                                       <input class="radio-box" type="radio" name="sleeve_type" value="{{ $sleeveType }}" id="sleeve-{{ strtolower(str_replace(' ', '-', $sleeveType)) }}" {{ request('sleeve_type') == $sleeveType ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()">
                                       <label class="check-label" for="sleeve-{{ strtolower(str_replace(' ', '-', $sleeveType)) }}">{{ ucfirst($sleeveType) }}</label>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                           @endif
                           
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Colour</h4>
                              <div class="filter-widget-content">
                                 <div class="category-colours">
                                    <?php
                                       $colorsForFilter = isset($availableColors) ? $availableColors : [];
                                    ?>
                                    <div class="color-grid d-flex flex-wrap" style="gap: 10px;">
                                       @foreach($colorsForFilter as $color)
                                       <?php
                                           $colorName = is_array($color) ? ($color['name'] ?? $color) : $color;
                                           $colorHex = is_array($color) ? ($color['hex'] ?? '#cccccc') : '#cccccc';
                                           $isChecked = in_array($colorName, (array)request('color', []));
                                           $lightColors = ['#ffffff', '#ffff00', '#f0e68c', '#add8e6', '#90ee90', '#ffd700', '#fffacd'];
                                           $textColor = in_array(strtolower($colorHex), $lightColors) ? '#000' : '#fff';
                                           $borderColor = $isChecked ? 'var(--clr-common-heading)' : '#ddd';
                                           $labelClass = 'color-option' . ($isChecked ? ' active-color' : '');
                                       ?>
                                       <label class="{{ $labelClass }}" 
                                              style="background-color: {{ $colorHex }}; display: inline-block; width: 40px; height: 40px; margin: 0; cursor: pointer; border-radius: 50%; border: 3px solid {{ $borderColor }}; position: relative; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                              title="{{ ucfirst($colorName) }}">
                                          <input type="checkbox" name="color[]" value="{{ $colorName }}" {{ $isChecked ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" style="display: none;">
                                          @if($isChecked)
                                          <i class="fas fa-check" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: {{ $textColor }}; font-weight: bold;"></i>
                                          @endif
                                       </label>
                                       @endforeach
                                    </div>
                                    @if(count($colorsForFilter) === 0)
                                    <p class="text-muted small">No colors available</p>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           
                           <div class="filter-widget">
                              <h4 class="filter-widget-title drop-btn">Price Range</h4>
                              <div class="filter-widget-content">
                                 <div class="filter-price">
                                    <div class="price-inputs">
                                       <div class="mb-2">
                                          <label for="min_price" class="small" style="color: var(--clr-common-text);">Min Price (£)</label>
                                          <input type="number" name="min_price" id="min_price" placeholder="0" 
                                                 value="{{ request('min_price') }}" class="form-control" 
                                                 style="border: 1px solid var(--clr-common-border); border-radius: 8px; padding: 10px;">
                                       </div>
                                       <div class="mb-2">
                                          <label for="max_price" class="small" style="color: var(--clr-common-text);">Max Price (£)</label>
                                          <input type="number" name="max_price" id="max_price" placeholder="1000" 
                                                 value="{{ request('max_price') }}" class="form-control"
                                                 style="border: 1px solid var(--clr-common-border); border-radius: 8px; padding: 10px;">
                                       </div>
                                       <button type="submit" class="btn btn-sm mt-2 w-100" 
                                               style="background-color: var(--clr-common-heading); color: white; padding: 10px; border-radius: 8px; font-weight: 600; border: none; transition: all 0.3s;">
                                          Apply Price Filter
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <!-- Clear Filters Button -->
                           <div class="filter-widget">
                              <a href="{{ route('shop') }}" class="btn w-100" 
                                 style="background-color: transparent; border: 2px solid var(--clr-common-heading); color: var(--clr-common-heading); padding: 12px; border-radius: 8px; font-weight: 600; text-align: center; transition: all 0.3s; display: block;">
                                 <i class="fas fa-times-circle mr-2"></i>Clear All Filters
                              </a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="row">
               <div class="col-12">
                  <div class="pagination-wrapper mt-40 mb-60">
                     {{ $products->links() }}
                  </div>
               </div>
            </div>
            @endif
            
         </div>
      </div>

<style>
.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    margin-bottom: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: var(--clr-common-text);
    border-left: 3px solid transparent;
}

.category-item:hover {
    background-color: #f8f9fa;
    color: var(--clr-common-heading);
    text-decoration: none;
}

.category-item.active {
    background-color: #f8f9fa;
    border-left-color: var(--clr-common-heading);
    color: var(--clr-common-heading);
    font-weight: 600;
}

.category-item .category-name {
    font-weight: 500;
}

.category-item .category-items-number {
    background-color: var(--clr-common-heading);
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.filter-widget-title {
    color: var(--clr-common-heading);
    font-weight: 600;
    margin-bottom: 16px;
}

.color-option {
    transition: all 0.3s ease;
}

.color-option:hover {
    transform: scale(1.1);
}

.check-box:checked + .check-label {
    color: var(--clr-common-heading);
    font-weight: 600;
}

.radio-box:checked + .check-label {
    color: var(--clr-common-heading);
    font-weight: 600;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.product-sticker.limited {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}
</style>

<script>
// Update sort parameter and submit form
function updateSort(sortValue) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
}

// Auto-submit form on filter changes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    
    // Preserve scroll position on form submit
    if (form) {
        form.addEventListener('submit', function() {
            const scrollPosition = window.pageYOffset;
            sessionStorage.setItem('scrollPosition', scrollPosition);
        });
    }
    
    // Restore scroll position after page load
    const savedScrollPosition = sessionStorage.getItem('scrollPosition');
    if (savedScrollPosition) {
        window.scrollTo(0, parseInt(savedScrollPosition));
        sessionStorage.removeItem('scrollPosition');
    }
    
    // Add hover effects to filter buttons
    const clearButton = document.querySelector('a[href*="shop"].btn');
    if (clearButton) {
        clearButton.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'var(--clr-common-heading)';
            this.style.color = 'white';
        });
        clearButton.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
            this.style.color = 'var(--clr-common-heading)';
        });
    }
    
    // Add hover effects to price filter button
    const priceButton = document.querySelector('.filter-price button[type="submit"]');
    if (priceButton) {
        priceButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        });
        priceButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    }
});
</script>

@endsection

