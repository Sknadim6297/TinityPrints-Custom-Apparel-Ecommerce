<!-- Cart Sidebar -->
<div class="fix">
   <div class="sidebar-action sidebar-cart">
      <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
      <h4 class="sidebar-action-title">Shopping Cart</h4>
      <div class="sidebar-action-list">
         @auth
            @php
               $sidebarCartItems = \App\Models\Cart::where('user_id', auth()->id())
                  ->with(['product.images', 'color'])
                  ->latest()
                  ->take(3)
                  ->get();
               $sidebarCartTotal = $sidebarCartItems->sum(function($item) {
                  return $item->product->price * $item->quantity;
               });
            @endphp
            
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
         @endauth
      </div>
      @auth
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
      @endauth
   </div>
</div>

<!-- Wishlist Sidebar -->
<div class="fix">
   <div class="sidebar-action sidebar-wishlist">
      <button class="close-sidebar">Close<i class="fal fa-times"></i></button>
      <h4 class="sidebar-action-title">Wishlist</h4>
      <div class="sidebar-action-list">
         @auth
            @php
               $sidebarWishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                  ->with(['product.images'])
                  ->latest()
                  ->take(3)
                  ->get();
            @endphp
            
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
         @endauth
      </div>
      <div class="sidebar-action-btn">
         <a href="{{ route('wishlist.index') }}" class="fill-btn">View Wishlist</a>
         <a href="{{ route('shop') }}" class="border-btn">Continue Shopping</a>
      </div>
   </div>
</div>
