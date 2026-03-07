@extends('frontend.layout.app')

@section('title', 'My Wishlist')

@section('content')
<!-- page title area start  -->
<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-wrapper text-center">
                    <h1 class="page-title mb-10">My Wishlist</h1>
                    <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin">
                                    <a href="{{ route('home') }}"><span>Home</span></a>
                                </li>
                                <li class="trail-item trail-end"><span>Wishlist</span></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page title area end  -->

<!-- wishlist area start  -->
<div class="wishlist-area pt-100 pb-100">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fal fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fal fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="wishlist-header mb-30">
                    <h4>Your Wishlist ({{ $wishlistItems->count() }} {{ $wishlistItems->count() == 1 ? 'item' : 'items' }})</h4>
                </div>
            </div>
        </div>

        @forelse($wishlistItems as $item)
            @if($loop->first)
            <div class="row">
            @endif
            
            @php
                $product = $item->product;
                $productImage = optional($product->images->first())->image_path;
                $productColors = $product->colors ?? collect();
            @endphp

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                <div class="single-product wishlist-product-item">
                    <div class="product-image pos-rel">
                        <a href="{{ route('product.details', $product->id) }}">
                            <img src="{{ $productImage ? Storage::url($productImage) : asset('frontend/assets/img/product/product-img1.jpg') }}" 
                                 alt="{{ $product->name }}">
                        </a>
                        
                        <div class="product-action">
                            <button class="quick-view-btn" data-product-id="{{ $product->id }}">
                                <i class="far fa-eye"></i>
                            </button>
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

                        <!-- Wishlist Remove Button (Top Right) -->
                        <div class="wishlist-remove-btn" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            <button class="btn-remove-wishlist" 
                                    data-wishlist-id="{{ $item->id }}"
                                    style="background: white; border: none; border-radius: 50%; width: 35px; height: 35px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer;">
                                <i class="fal fa-times" style="color: #ff4444;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="product-desc">
                        <div class="product-name">
                            <a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                        </div>
                        
                        <div class="product-price mb-2">
                            <span class="price-now">₹{{ number_format($product->price, 2) }}</span>
                        </div>

                        @if($productColors->count() > 0)
                        <div class="product-colors mb-2">
                            <small class="text-muted">Available in:</small>
                            <div class="color-badges mt-1">
                                @foreach($productColors->take(5) as $color)
                                <span class="badge" 
                                      style="background-color: {{ $color->hex_code ?? '#cccccc' }}; 
                                             width: 20px; 
                                             height: 20px; 
                                             display: inline-block; 
                                             border-radius: 50%; 
                                             margin-right: 3px;
                                             border: 1px solid #ddd;"
                                      title="{{ $color->color_name }}"></span>
                                @endforeach
                                @if($productColors->count() > 5)
                                <small class="text-muted">+{{ $productColors->count() - 5 }}</small>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="product-actions mt-3">
                            <button class="btn add-to-cart-btn w-100 mb-2" 
                        </div>
                    </div>
                </div>
            </div>

            @if($loop->last)
            </div>
            @endif
        @empty
        <!-- Empty Wishlist State -->
        <div class="row">
            <div class="col-12">
                <div class="empty-wishlist text-center py-5">
                    <div class="empty-wishlist-icon mb-4">
                        <i class="far fa-heart" style="font-size: 80px; color: #e0e0e0;"></i>
                    </div>
                    <h3 class="mb-3" style="color: var(--clr-common-heading);">Your Wishlist is Empty</h3>
                    <p class="mb-4" style="color: var(--clr-common-text); max-width: 500px; margin: 0 auto;">
                        Save your favorite products and come back to them later. Start adding items you love!
                    </p>
                    <a href="{{ route('shop') }}" 
                       class="btn fill-btn" 
                       style="background-color: var(--clr-common-heading); 
                              color: white; 
                              padding: 12px 30px; 
                              border-radius: 5px;
                              font-weight: 600;
                              text-decoration: none;">
                        <i class="fal fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
<!-- wishlist area end  -->

<!-- Remove Confirmation Modal -->
<div class="modal fade" id="removeConfirmModal" tabindex="-1" aria-labelledby="removeConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeConfirmModalLabel">Remove from Wishlist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this item from your wishlist?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="removeWishlistForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist functionality
    const removeButtons = document.querySelectorAll('.btn-remove-wishlist');
    const removeModal = new bootstrap.Modal(document.getElementById('removeConfirmModal'));
    const removeForm = document.getElementById('removeWishlistForm');

    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const wishlistId = this.dataset.wishlistId;
            const actionUrl = `/wishlist/${wishlistId}`;
            removeForm.setAttribute('action', actionUrl);
            removeModal.show();
        });
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush

<style>
.wishlist-product-item .product-actions button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.wishlist-remove-btn button:hover {
    box-shadow: 0 4px 12px rgba(255, 68, 68, 0.3);
    transform: scale(1.1);
}

.color-badges {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 3px;
}

.alert {
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 20px;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-wishlist-icon i {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>
@endsection