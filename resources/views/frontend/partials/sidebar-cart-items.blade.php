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
