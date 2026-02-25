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
