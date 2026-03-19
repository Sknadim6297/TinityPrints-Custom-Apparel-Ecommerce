   <!-- header area start  -->
   <header class="header3">
      <div class="top-note-bar">
    <div class="scroll-text">
        <p>
            Further reductions: enjoy an extra <span>20%</span> off our Sale and free home delivery
        </p>
    </div>

    <span class="note-close-btn">
        <i class="flaticon-cancel"></i>
    </span>
</div>
      <div class="header3-top d-none d-lg-block">
         <div class="container header-container">
            <div class="row align-items-center">
               <div class="col-lg-4">
                  <form action="#" class="filter-search-input header-search-3 d-none d-lg-inline-block">
                     <input type="text" placeholder="Search Products.....">
                     <button><i class="fal fa-search"></i></button>
                  </form>
               </div>
               <div class="col-lg-4">
                  <div class="header-logo header3-logo">
                     <a href="{{ route('home') }}" class="logo-bl"><img src="{{ asset('frontend/assets/img/logo/logo.png') }}" alt="logo-img" style="width: 100px"></a>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="action-list d-none d-md-flex action-list-header3">
                     <div class="user-btn action-item">
                        @auth
                           <div class="dropdown">
                              <a href="#" class="user-profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                                 <div class="user-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.077" height="19"
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
                                 <span class="user-name-text">{{ Auth::user()->name }}</span>
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="{{ route('orders') }}">My Orders</a></li>
                                 <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                 <li><a class="dropdown-item" href="{{ route('contact') }}">Support</a></li>
                                 <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                       @csrf
                                       <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                 </li>
                              </ul>
                           </div>
                        @else
                           <a href="{{ route('login') }}">
                              <div class="user-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16.077" height="19"
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
                           </a>
                           <a href="{{ route('login') }}" class="action-btn-text">Sign in</a>
                        @endauth
                     </div>
                     <div class="action-item action-item-cart">
                        <a href="#" class="view-cart-button" aria-label="Open cart sidebar">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16.665" height="20" viewBox="0 0 16.665 20">
                              <g id="Layer_2" data-name="Layer 2" transform="translate(-4.096 -1)">
                                 <path id="Path_35" data-name="Path 35"
                                    d="M14.23,16.029a4.2,4.2,0,0,1-4.123-3.374.709.709,0,0,1,1.4-.224,2.8,2.8,0,0,0,5.481,0,.709.709,0,0,1,1.4.224A4.2,4.2,0,0,1,14.23,16.029Z"
                                    transform="translate(-1.801 -3.706)"></path>
                                 <path id="Path_36" data-name="Path 36"
                                    d="M18.659,23.022H6.2a2.168,2.168,0,0,1-1.523-.612A1.9,1.9,0,0,1,4.1,20.952L4.666,9.626a2.046,2.046,0,0,1,2.1-1.886H18.092a2.046,2.046,0,0,1,2.1,1.886l.567,11.327a1.9,1.9,0,0,1-.577,1.458,2.168,2.168,0,0,1-1.523.612ZM6.766,9.061a.68.68,0,0,0-.7.657L5.5,21.018a.634.634,0,0,0,.192.486.723.723,0,0,0,.508.2h12.46a.723.723,0,0,0,.508-.2.634.634,0,0,0,.192-.486L18.792,9.691a.68.68,0,0,0-.7-.657Z"
                                    transform="translate(0 -2.022)"></path>
                                 <path id="Path_37" data-name="Path 37"
                                    d="M18.4,6.425H17V5.2a2.8,2.8,0,0,0-5.6,0V6.425H10V5.2a4.2,4.2,0,0,1,8.4,0Z"
                                    transform="translate(-1.771 0)"></path>
                              </g>
                           </svg>
                           @auth
                              @php
                                 $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                              @endphp
                              <span class="action-item-number cart-count">{{ $cartCount }}</span>
                           @else
                              <span class="action-item-number cart-count">0</span>
                           @endauth
                        </a>
                        <a href="#" class="action-btn-text">Cartlist</a>
                     </div>
                     <div class="action-item action-item-wishlist">
                        <a href="#" class="view-wishlist-button" aria-label="Open wishlist sidebar">
                           <svg id="heart_2_" data-name="heart (2)" xmlns="http://www.w3.org/2000/svg" width="19.452"
                              height="18" viewBox="0 0 19.452 18">
                              <g id="Group_2" data-name="Group 2" transform="translate(0 0)">
                                 <path id="Path_4" data-name="Path 4"
                                    d="M14.209,39.221a4.958,4.958,0,0,0-4.1,2.28c-.142.2-.269.4-.381.591-.112-.193-.239-.392-.381-.591a4.958,4.958,0,0,0-4.1-2.28C2.186,39.221,0,42.018,0,45.374,0,49.212,2.878,52.828,9.332,57.1a.705.705,0,0,0,.787,0c6.454-4.273,9.332-7.889,9.332-11.727C19.452,42.02,17.268,39.221,14.209,39.221Zm1.716,10.931a28.823,28.823,0,0,1-6.2,5.265,28.824,28.824,0,0,1-6.2-5.265A7.547,7.547,0,0,1,1.52,45.374c0-2.416,1.494-4.492,3.723-4.492a3.472,3.472,0,0,1,2.877,1.6A6.381,6.381,0,0,1,9,44.22a.743.743,0,0,0,1.451,0,6.376,6.376,0,0,1,.854-1.7,3.486,3.486,0,0,1,2.9-1.641c2.231,0,3.723,2.078,3.723,4.492A7.547,7.547,0,0,1,15.925,50.152Z"
                                    transform="translate(0 -39.221)" fill="#171717"></path>
                              </g>
                           </svg>
                           @auth
                              @php
                                 $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                              @endphp
                              <span class="action-item-number wishlist-count">{{ $wishlistCount }}</span>
                           @else
                              <span class="action-item-number wishlist-count">0</span>
                           @endauth
                        </a>
                        <a href="#" class="action-btn-text">Wishlisht</a>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="header-sticky" class="header-main header-main3">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-12 col-lg-12">
                  <div class="header-main-content-wrapper">
                     <div class="header-logo header3-logo d-lg-none">
                        <a href="{{ route('home') }}" class="logo-bl"><img src="{{ asset('frontend/assets/img/logo/logo.png') }}" alt="logo-img"  width="100px"></a>
                     </div>
                     <div class="main-menu main-menu3 d-none d-lg-block">
                        <nav id="mobile-menu">
                           <ul>
                              <li><a href="{{ route('home') }}">Home</a></li>
                              <li><a href="{{ route('custom-design') }}">Custom Design</a></li>
                              <li><a href="{{ route('limited-edition') }}">Limited Edition</a></li>
                              @php
                                 $desktopShopMenu = collect($shopMenu ?? []);
                                 $defaultCategoryId = data_get($desktopShopMenu->first(), 'id');
                                 $defaultCollectionId = data_get(collect(data_get($desktopShopMenu->first(), 'collections', []))->first(), 'id');
                              @endphp
                              <li class="shop-menu-item has-shop-mega" data-shop-menu>
                                 <a href="{{ route('shop') }}" class="shop-menu-link" data-shop-menu-toggle aria-expanded="false">
                                    <span>Shop</span>
                                    <i class="fal fa-angle-down"></i>
                                 </a>
                                 <div class="shop-mega-menu" data-shop-menu-panel>
                                    <div class="shop-mega-shell">
                                       <div class="shop-mega-column shop-mega-column-categories">
                                          <div class="shop-mega-column-head">
                                             <div>
                                                <span class="shop-mega-eyebrow">Browse</span>
                                                <strong>Categories</strong>
                                             </div>
                                             <a href="{{ route('shop') }}">All products</a>
                                          </div>
                                          <div class="shop-mega-list">
                                             @forelse($desktopShopMenu as $menuCategory)
                                                <button
                                                   type="button"
                                                   class="shop-mega-trigger {{ $defaultCategoryId === $menuCategory['id'] ? 'is-active' : '' }}"
                                                   data-panel-level="category"
                                                   data-target="category-{{ $menuCategory['id'] }}"
                                                >
                                                   <span class="shop-mega-trigger-copy">
                                                      <strong>{{ $menuCategory['name'] }}</strong>
                                                      <small>{{ collect($menuCategory['collections'])->count() }} collections</small>
                                                   </span>
                                                   <span class="shop-mega-trigger-meta">{{ $menuCategory['product_count'] }}</span>
                                                   <i class="fal fa-angle-right"></i>
                                                </button>
                                             @empty
                                                <div class="shop-mega-empty-state">
                                                   <strong>No categories available</strong>
                                                   <p>Add active categories, collections, and products to populate the menu.</p>
                                                </div>
                                             @endforelse
                                          </div>
                                       </div>

                                       <div class="shop-mega-column shop-mega-column-collections">
                                          @forelse($desktopShopMenu as $menuCategory)
                                             @php($menuCollections = collect($menuCategory['collections']))
                                             <div
                                                class="shop-mega-panel {{ $defaultCategoryId === $menuCategory['id'] ? 'is-active' : '' }}"
                                                data-panel-level="category"
                                                data-panel="category-{{ $menuCategory['id'] }}"
                                             >
                                                <div class="shop-mega-column-head">
                                                   <div>
                                                      <span class="shop-mega-eyebrow">Category</span>
                                                      <strong>{{ $menuCategory['name'] }}</strong>
                                                   </div>
                                                   <a href="{{ route('shop', ['category_id' => $menuCategory['id']]) }}">Explore</a>
                                                </div>
                                                <div class="shop-mega-list">
                                                   @forelse($menuCollections as $menuCollection)
                                                      <button
                                                         type="button"
                                                         class="shop-mega-trigger {{ $defaultCategoryId === $menuCategory['id'] && $defaultCollectionId === $menuCollection['id'] ? 'is-active' : '' }}"
                                                         data-panel-level="collection"
                                                         data-target="collection-{{ $menuCategory['id'] }}-{{ $menuCollection['id'] }}"
                                                      >
                                                         <span class="shop-mega-trigger-copy">
                                                            <strong>{{ $menuCollection['name'] }}</strong>
                                                            <small>{{ $menuCollection['product_count'] }} products</small>
                                                         </span>
                                                         <span class="shop-mega-trigger-meta">Open</span>
                                                         <i class="fal fa-angle-right"></i>
                                                      </button>
                                                   @empty
                                                      <div class="shop-mega-empty-state compact">
                                                         <strong>No collections yet</strong>
                                                         <p>This category has no active collections linked to products.</p>
                                                      </div>
                                                   @endforelse
                                                </div>
                                             </div>
                                          @empty
                                             <div class="shop-mega-panel is-active" data-panel-level="category" data-panel="category-empty">
                                                <div class="shop-mega-empty-state">
                                                   <strong>No collections available</strong>
                                                   <p>The second column will appear here once active category data exists.</p>
                                                </div>
                                             </div>
                                          @endforelse
                                       </div>

                                       <div class="shop-mega-column shop-mega-column-products">
                                          @forelse($desktopShopMenu as $menuCategory)
                                             @foreach(collect($menuCategory['collections']) as $menuCollection)
                                                @php($menuProducts = collect($menuCollection['products']))
                                                <div
                                                   class="shop-mega-panel {{ $defaultCategoryId === $menuCategory['id'] && $defaultCollectionId === $menuCollection['id'] ? 'is-active' : '' }}"
                                                   data-panel-level="collection"
                                                   data-panel="collection-{{ $menuCategory['id'] }}-{{ $menuCollection['id'] }}"
                                                >
                                                   <div class="shop-mega-column-head">
                                                      <div>
                                                         <span class="shop-mega-eyebrow">Collection</span>
                                                         <strong>{{ $menuCollection['name'] }}</strong>
                                                      </div>
                                                      <a href="{{ route('shop', ['category_id' => $menuCategory['id'], 'collection_type_id' => $menuCollection['id']]) }}">View all</a>
                                                   </div>
                                                   <div class="shop-mega-product-list">
                                                      @forelse($menuProducts as $menuProduct)
                                                         <a href="{{ route('product.details', $menuProduct['id']) }}" class="shop-mega-product-link">
                                                            <span class="shop-mega-product-name">{{ $menuProduct['name'] }}</span>
                                                            <i class="fal fa-arrow-right"></i>
                                                         </a>
                                                      @empty
                                                         <div class="shop-mega-empty-state compact">
                                                            <strong>No products available</strong>
                                                            <p>This collection does not have active products yet.</p>
                                                         </div>
                                                      @endforelse
                                                   </div>
                                                </div>
                                             @endforeach
                                          @empty
                                             <div class="shop-mega-panel is-active" data-panel-level="collection" data-panel="collection-empty">
                                                <div class="shop-mega-empty-state">
                                                   <strong>No products available</strong>
                                                   <p>The third column will show products once collections are available.</p>
                                                </div>
                                             </div>
                                          @endforelse
                                       </div>
                                    </div>
                                 </div>
                                 <ul class="shop-mobile-tree">
                                    @forelse($desktopShopMenu as $menuCategory)
                                       <li>
                                          <a href="{{ route('shop', ['category_id' => $menuCategory['id']]) }}">{{ $menuCategory['name'] }}</a>
                                          @if(collect($menuCategory['collections'])->isNotEmpty())
                                             <ul>
                                                @foreach(collect($menuCategory['collections']) as $menuCollection)
                                                   <li>
                                                      <a href="{{ route('shop', ['category_id' => $menuCategory['id'], 'collection_type_id' => $menuCollection['id']]) }}">{{ $menuCollection['name'] }}</a>
                                                   </li>
                                                @endforeach
                                             </ul>
                                          @endif
                                       </li>
                                    @empty
                                       <li><a href="{{ route('shop') }}">All Products</a></li>
                                    @endforelse
                                 </ul>
                              </li>
                              {{-- <li><a href="{{ route('about') }}">About Us</a></li> --}}
                              {{-- <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li> --}}
                              {{-- <li><a href="{{ route('contact') }}">Contact</a></li> --}}
                           </ul>
                        </nav>
                     </div>
                     <div class="menu-bar d-lg-none ml-20">
                        <a class="side-toggle" href="javascript:void(0)">
                           <div class="bar-icon">
                              <span></span>
                              <span></span>
                              <span></span>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!-- header area end -->

   <!-- Add your site or application content here -->
   <main>

   <style>
   
   .top-note-bar{
    position: relative;
    overflow: hidden;
    background: #95814f;
    color: #fff;
    padding: 10px 40px;
}

.scroll-text{
    white-space: nowrap;
    display: inline-block;
    animation: scrollText 12s linear infinite;
}

.scroll-text p{
    margin: 0;
    font-size: 15px;
        color: white;
}

.scroll-text span{
    color: #ff4a4a;
    font-weight: 600;
}

.note-close-btn{
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

@keyframes scrollText{
    0%{
        transform: translateX(100%);
    }
    100%{
        transform: translateX(-100%);
    }
}
      .main-menu3 .shop-menu-item {
         position: relative;
      }

      .main-menu3 .shop-menu-link {
         display: inline-flex;
         align-items: center;
         gap: 8px;
      }

      .main-menu3 .shop-menu-link i {
         font-size: 12px;
         transition: transform 0.25s ease;
      }

      .main-menu3 .shop-menu-item.is-open .shop-menu-link i {
         transform: rotate(180deg);
      }

      .main-menu3 .shop-menu-item .shop-mega-menu {
         position: absolute;
         top: calc(100% + 18px);
         left: 0;
         width: min(940px, calc(100vw - 32px));
         opacity: 0;
         visibility: hidden;
         pointer-events: none;
         transform: translateY(12px);
         transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
         z-index: 999;
      }

      .main-menu3 .shop-menu-item.is-open .shop-mega-menu {
         opacity: 1;
         visibility: visible;
         pointer-events: auto;
         transform: translateY(0);
      }

      .main-menu3 .shop-mega-shell {
         display: grid;
         grid-template-columns: minmax(210px, 0.9fr) minmax(240px, 1fr) minmax(260px, 1.1fr);
         min-height: 400px;
         background: linear-gradient(180deg, #ffffff 0%, #fbf7f1 100%);
         border: 1px solid rgba(22, 22, 22, 0.08);
         border-radius: 24px;
         overflow: hidden;
         box-shadow: 0 28px 80px rgba(18, 22, 33, 0.18);
      }

      .main-menu3 .shop-mega-column {
         min-width: 0;
         background: rgba(255, 255, 255, 0.76);
         backdrop-filter: blur(12px);
         border-right: 1px solid rgba(23, 23, 23, 0.08);
      }

      .main-menu3 .shop-mega-column:last-child {
         border-right: 0;
      }

      .main-menu3 .shop-mega-column-head {
         display: flex;
         align-items: flex-start;
         justify-content: space-between;
         gap: 16px;
         padding: 20px 22px 16px;
         border-bottom: 1px solid rgba(23, 23, 23, 0.08);
      }

      .main-menu3 .shop-mega-column-head strong {
         display: block;
         color: #171717;
         font-size: 18px;
         line-height: 1.2;
      }

      .main-menu3 .shop-mega-column-head a {
         flex-shrink: 0;
         color: #8a5a21;
         font-size: 13px;
         font-weight: 700;
         letter-spacing: 0.02em;
         text-transform: uppercase;
      }

      .main-menu3 .shop-mega-eyebrow {
         display: block;
         margin-bottom: 6px;
         color: #9a7a4b;
         font-size: 11px;
         font-weight: 700;
         letter-spacing: 0.16em;
         text-transform: uppercase;
      }

      .main-menu3 .shop-mega-list,
      .main-menu3 .shop-mega-product-list {
         padding: 14px;
         max-height: 330px;
         overflow-y: auto;
      }

      .main-menu3 .shop-mega-trigger {
         width: 100%;
         display: grid;
         grid-template-columns: minmax(0, 1fr) auto auto;
         align-items: center;
         gap: 12px;
         border: 0;
         border-radius: 18px;
         background: transparent;
         color: #171717;
         padding: 15px 16px;
         text-align: left;
         transition: background 0.22s ease, transform 0.22s ease, box-shadow 0.22s ease, color 0.22s ease;
      }

      .main-menu3 .shop-mega-trigger + .shop-mega-trigger,
      .main-menu3 .shop-mega-product-link + .shop-mega-product-link {
         margin-top: 8px;
      }

      .main-menu3 .shop-mega-trigger-copy {
         min-width: 0;
      }

      .main-menu3 .shop-mega-trigger-copy strong,
      .main-menu3 .shop-mega-product-name {
         display: block;
         color: inherit;
         font-size: 15px;
         line-height: 1.35;
      }

      .main-menu3 .shop-mega-trigger-copy small {
         display: block;
         margin-top: 4px;
         color: #6c6c6c;
         font-size: 12px;
         line-height: 1.4;
      }

      .main-menu3 .shop-mega-trigger-meta {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         min-width: 34px;
         height: 28px;
         padding: 0 10px;
         border-radius: 999px;
         background: rgba(23, 23, 23, 0.08);
         color: #171717;
         font-size: 11px;
         font-weight: 700;
      }

      .main-menu3 .shop-mega-trigger i,
      .main-menu3 .shop-mega-product-link i {
         color: #8b8b8b;
         font-size: 14px;
      }

      .main-menu3 .shop-mega-trigger:hover,
      .main-menu3 .shop-mega-trigger.is-active {
         background: #171717;
         color: #ffffff;
         transform: translateX(4px);
         box-shadow: 0 18px 40px rgba(23, 23, 23, 0.14);
      }

      .main-menu3 .shop-mega-trigger:hover .shop-mega-trigger-copy small,
      .main-menu3 .shop-mega-trigger.is-active .shop-mega-trigger-copy small,
      .main-menu3 .shop-mega-trigger:hover i,
      .main-menu3 .shop-mega-trigger.is-active i {
         color: rgba(255, 255, 255, 0.78);
      }

      .main-menu3 .shop-mega-trigger:hover .shop-mega-trigger-meta,
      .main-menu3 .shop-mega-trigger.is-active .shop-mega-trigger-meta {
         background: rgba(255, 255, 255, 0.16);
         color: #ffffff;
      }

      .main-menu3 .shop-mega-panel {
         display: none;
         height: 100%;
      }

      .main-menu3 .shop-mega-panel.is-active {
         display: block;
      }

      .main-menu3 .shop-mega-product-link {
         display: flex;
         align-items: center;
         justify-content: space-between;
         gap: 16px;
         padding: 14px 16px;
         border-radius: 18px;
         background: rgba(255, 255, 255, 0.78);
         border: 1px solid rgba(23, 23, 23, 0.06);
         transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
      }

      .main-menu3 .shop-mega-product-link:hover {
         border-color: rgba(139, 90, 33, 0.24);
         box-shadow: 0 16px 36px rgba(139, 90, 33, 0.12);
         transform: translateX(4px);
      }

      .main-menu3 .shop-mega-empty-state {
         padding: 28px 20px;
         color: #5d5d5d;
      }

      .main-menu3 .shop-mega-empty-state strong {
         display: block;
         margin-bottom: 8px;
         color: #171717;
         font-size: 15px;
      }

      .main-menu3 .shop-mega-empty-state p {
         margin: 0;
         font-size: 13px;
         line-height: 1.6;
      }

      .main-menu3 .shop-mega-empty-state.compact {
         padding: 18px 16px;
      }

      .main-menu3 .shop-mobile-tree {
         display: none;
      }

      @media (max-width: 1399.98px) {
         .main-menu3 .shop-mega-menu {
            width: min(860px, calc(100vw - 32px));
         }

         .main-menu3 .shop-mega-shell {
            grid-template-columns: minmax(190px, 0.85fr) minmax(220px, 0.95fr) minmax(240px, 1fr);
         }
      }

      @media (max-width: 1199.98px) {
         .main-menu3 .shop-mega-menu {
            width: min(760px, calc(100vw - 24px));
         }

         .main-menu3 .shop-mega-shell {
            grid-template-columns: minmax(170px, 0.85fr) minmax(200px, 0.95fr) minmax(220px, 1fr);
         }

         .main-menu3 .shop-mega-column-head {
            padding: 18px 18px 14px;
         }

         .main-menu3 .shop-mega-column-head strong {
            font-size: 16px;
         }
      }

      @media (max-width: 991.98px) {
         .main-menu3 .shop-mega-menu {
            display: none !important;
         }

         .main-menu3 .shop-mobile-tree {
            display: block;
         }

         .mean-container .shop-mega-menu,
         .mean-container .shop-mega-shell,
         .mean-container .shop-mega-column,
         .mean-container .shop-mega-column-head,
         .mean-container .shop-mega-list,
         .mean-container .shop-mega-panel,
         .mean-container .shop-mega-product-list,
         .mean-container .shop-mega-empty-state,
         .mean-container .shop-mega-trigger,
         .mean-container .shop-mega-product-link {
            display: none !important;
         }

         .mean-container .shop-mobile-tree {
            display: block !important;
         }

         .mean-container .shop-menu-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
         }

         .mean-container .shop-menu-link i {
            font-size: 11px;
            opacity: 0.65;
         }
      }
   </style>

   <script>
      document.addEventListener('DOMContentLoaded', function () {
         var shopMenus = document.querySelectorAll('[data-shop-menu]');

         shopMenus.forEach(function (shopMenu) {
            var toggle = shopMenu.querySelector('[data-shop-menu-toggle]');
            var panel = shopMenu.querySelector('[data-shop-menu-panel]');

            if (!toggle || !panel) {
               return;
            }

            var closeMenu = function () {
               shopMenu.classList.remove('is-open');
               toggle.setAttribute('aria-expanded', 'false');
               panel.style.left = '';
            };

            var positionPanel = function () {
               if (window.innerWidth < 992) {
                  panel.style.left = '';
                  return;
               }

               var itemRect = shopMenu.getBoundingClientRect();
               var panelWidth = panel.offsetWidth;
               var viewportPadding = 16;
               var desiredLeft = itemRect.left - 140;
               var clampedLeft = Math.max(
                  viewportPadding,
                  Math.min(desiredLeft, window.innerWidth - panelWidth - viewportPadding)
               );

               panel.style.left = (clampedLeft - itemRect.left) + 'px';
            };

            var openMenu = function () {
               if (window.innerWidth < 992) {
                  return;
               }

               positionPanel();
               shopMenu.classList.add('is-open');
               toggle.setAttribute('aria-expanded', 'true');
            };

            var resetCollectionPanels = function () {
               shopMenu.querySelectorAll('.shop-mega-trigger[data-panel-level="collection"]').forEach(function (button) {
                  button.classList.remove('is-active');
               });

               shopMenu.querySelectorAll('.shop-mega-panel[data-panel-level="collection"]').forEach(function (panelItem) {
                  panelItem.classList.remove('is-active');
               });
            };

            var activatePanel = function (level, target, triggerButton) {
               if (!target) {
                  return;
               }

               shopMenu.querySelectorAll('.shop-mega-trigger[data-panel-level="' + level + '"]').forEach(function (button) {
                  button.classList.remove('is-active');
               });

               if (triggerButton) {
                  triggerButton.classList.add('is-active');
               }

               shopMenu.querySelectorAll('.shop-mega-panel[data-panel-level="' + level + '"]').forEach(function (panelItem) {
                  panelItem.classList.toggle('is-active', panelItem.dataset.panel === target);
               });

               if (level === 'category') {
                  var activeCategoryPanel = shopMenu.querySelector('.shop-mega-panel[data-panel-level="category"][data-panel="' + target + '"]');
                  var firstCollectionButton = activeCategoryPanel ? activeCategoryPanel.querySelector('.shop-mega-trigger[data-panel-level="collection"]') : null;

                  if (firstCollectionButton) {
                     activatePanel('collection', firstCollectionButton.dataset.target, firstCollectionButton);
                  } else {
                     resetCollectionPanels();
                  }
               }
            };

            shopMenu.querySelectorAll('.shop-mega-trigger[data-panel-level]').forEach(function (button) {
               button.addEventListener('click', function () {
                  openMenu();
                  activatePanel(button.dataset.panelLevel, button.dataset.target, button);
               });
            });

            toggle.addEventListener('click', function (event) {
               if (window.innerWidth < 992) {
                  return;
               }

               event.preventDefault();

               if (shopMenu.classList.contains('is-open')) {
                  closeMenu();
                  return;
               }

               document.querySelectorAll('[data-shop-menu].is-open').forEach(function (openShopMenu) {
                  if (openShopMenu !== shopMenu) {
                     openShopMenu.classList.remove('is-open');
                     var openToggle = openShopMenu.querySelector('[data-shop-menu-toggle]');

                     if (openToggle) {
                        openToggle.setAttribute('aria-expanded', 'false');
                     }
                  }
               });

               openMenu();
            });

            document.addEventListener('click', function (event) {
               if (!shopMenu.contains(event.target)) {
                  closeMenu();
               }
            });

            document.addEventListener('keydown', function (event) {
               if (event.key === 'Escape') {
                  closeMenu();
               }
            });

            window.addEventListener('resize', function () {
               if (window.innerWidth < 992) {
                  closeMenu();
                  return;
               }

               if (shopMenu.classList.contains('is-open')) {
                  positionPanel();
               }
            });
         });
      });
   </script>


      <!-- side toggle start -->
      <div class="fix">
         <div class="side-info">
            <div class="side-info-content">
               <div class="offset-widget offset-logo mb-40">
                  <div class="row align-items-center">
                     <div class="col-9">
                        <a href="{{ route('home') }}">
                           <img src="{{ asset('frontend/assets/img/logo/logo.png') }}" width="100px"  alt="Logo">
                        </a>
                     </div>
                     <div class="col-3 text-end"><button class="side-info-close"><i class="fal fa-times"></i></button>
                     </div>
                  </div>
               </div>
               <div class="mobile-menu d-lg-none fix"></div>
               <div class="offset-profile-action d-lg-none">
                  <div class="offset-widget mb-40">
                     @if(auth()->check())
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
                     @endif
                     <div class="action-list action-list-header1 mb-20">
                        @if(auth()->check())
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
                        @endif
                        @if(!auth()->check())
                           <div class="action-item">
                              <a href="{{ route('login') }}" class="action-btn-text">Sign in</a>
                           </div>
                        @endif
                     </div>
                     <div class="action-list action-list-header1">
                        <div class="action-item action-item-cart">
                           <a href="#" class="view-cart-button" aria-label="Open cart sidebar">
                              <i class="fal fa-shopping-bag"></i>
                              <span class="action-item-number cart-count">{{ auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->count() : 0 }}</span>
                           </a>
                        </div>
                        <div class="action-item action-item-wishlist">
                           <a href="#" class="view-wishlist-button" aria-label="Open wishlist sidebar">
                              <i class="fal fa-heart"></i>
                              <span class="action-item-number wishlist-count">{{ auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0 }}</span>
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

      <div class="fix">
         <div class="sidebar-action sidebar-cart">
            <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
            <h4 class="sidebar-action-title">Shopping Cart</h4>
            <div class="sidebar-action-list">
               @if(auth()->check())
                  <?php
                     $sidebarCartItems = \App\Models\Cart::where('user_id', auth()->id())
                        ->with(['product.images', 'color'])
                        ->latest()
                        ->get();
                     $sidebarCartTotal = $sidebarCartItems->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                     });
                  ?>

                  @forelse($sidebarCartItems as $cartItem)
                     <div class="sidebar-list-item">
                        <div class="product-image pos-rel">
                           <a href="{{ route('product.details', $cartItem->product->id) }}" class="">
                              @if($cartItem->product->images->first())
                                 <img src="{{ Storage::url($cartItem->product->images->first()->image_path) }}" alt="{{ $cartItem->product->name }}">
                              @else
                                 <img src="{{ asset('frontend/assets/img/product/product-img1.jpg') }}" alt="{{ $cartItem->product->name }}">
                              @endif
                           </a>
                        </div>
                        <div class="product-desc">
                           <div class="product-name"><a href="{{ route('product.details', $cartItem->product->id) }}">{{ $cartItem->product->name }}</a></div>
                           <div class="product-pricing">
                              <span class="item-number">{{ $cartItem->quantity }} &times;</span>
                              <span class="price-now">INR {{ number_format($cartItem->product->price, 2) }}</span>
                           </div>
                           <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="remove-item" onclick="return confirm('Remove this item?')"><i class="fal fa-times"></i></button>
                           </form>
                        </div>
                     </div>
                  @empty
                     <div class="text-center py-4">
                        <i class="fal fa-shopping-cart" style="font-size: 48px; color: #ddd;"></i>
                        <p class="text-muted mt-2">Your cart is empty</p>
                     </div>
                  @endforelse
               @else
                  <div class="text-center py-4">
                     <i class="fal fa-shopping-cart" style="font-size: 48px; color: #ddd;"></i>
                     <p class="text-muted mt-2">Please login to view cart</p>
                  </div>
               @endif
            </div>
            @if(auth()->check())
               @if($sidebarCartItems->count() > 0)
                  <div class="product-price-total">
                     <span>Subtotal :</span>
                     <span class="subtotal-price">INR {{ number_format($sidebarCartTotal, 2) }}</span>
                  </div>
                  <div class="sidebar-action-btn">
                     <a href="{{ route('cart.index') }}" class="fill-btn">View cart</a>
                     <a href="{{ route('checkout') }}" class="border-btn">Checkout</a>
                  </div>
               @endif
            @endif
         </div>
      </div>
      <div class="fix">
         <div class="sidebar-action sidebar-wishlist">
            <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
            <h4 class="sidebar-action-title">Wishlist</h4>
            <div class="sidebar-action-list">
               @if(auth()->check())
                  <?php
                     $sidebarWishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                        ->with(['product.images'])
                        ->latest()
                        ->get();
                  ?>

                  @forelse($sidebarWishlistItems as $wishlistItem)
                     <div class="sidebar-list-item">
                        <div class="product-image pos-rel">
                           <a href="{{ route('product.details', $wishlistItem->product->id) }}" class="">
                              @if($wishlistItem->product->images->first())
                                 <img src="{{ Storage::url($wishlistItem->product->images->first()->image_path) }}" alt="{{ $wishlistItem->product->name }}">
                              @else
                                 <img src="{{ asset('frontend/assets/img/product/product-img1.jpg') }}" alt="{{ $wishlistItem->product->name }}">
                              @endif
                           </a>
                        </div>
                        <div class="product-desc">
                           <div class="product-name"><a href="{{ route('product.details', $wishlistItem->product->id) }}">{{ $wishlistItem->product->name }}</a></div>
                           <div class="product-pricing">
                              <span class="price-now">INR {{ number_format($wishlistItem->product->price, 2) }}</span>
                           </div>
                           <form action="{{ route('wishlist.destroy', $wishlistItem->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="remove-item" onclick="return confirm('Remove from wishlist?')"><i class="fal fa-times"></i></button>
                           </form>
                        </div>
                     </div>
                  @empty
                     <div class="text-center py-4">
                        <i class="fal fa-heart" style="font-size: 48px; color: #ddd;"></i>
                        <p class="text-muted mt-2">Your wishlist is empty</p>
                     </div>
                  @endforelse
               @else
                  <div class="text-center py-4">
                     <i class="fal fa-heart" style="font-size: 48px; color: #ddd;"></i>
                     <p class="text-muted mt-2">Please login to view wishlist</p>
                  </div>
               @endif
            </div>
            <div class="sidebar-action-btn">
               <a href="{{ route('wishlist.index') }}" class="fill-btn">View Wishlist</a>
               <a href="{{ route('shop') }}" class="border-btn">Continue Shopping</a>
            </div>
         </div>
      </div>