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

        @if($wishlistItems->count() > 0)
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                @php
                    $product = $item->product;
                    $productImagePath = optional($product->images->first())->image_path;
                    $productImage = $productImagePath
                        ? (\Illuminate\Support\Str::startsWith($productImagePath, ['http://', 'https://']) ? $productImagePath : Storage::url($productImagePath))
                        : asset('frontend/assets/img/product_category/product-cat-6.jpeg');
                    $productColors = $product->colors ?? collect();
                @endphp

                <div class="wishlist-card">
                    <div class="wishlist-image-wrap">
                        @if($product->is_limited_edition)
                            <span class="wishlist-badge">LIMITED</span>
                        @elseif($product->created_at >= now()->subDays(30))
                            <span class="wishlist-badge">NEW</span>
                        @endif

                        <button class="btn-remove-wishlist"
                                data-wishlist-id="{{ $item->id }}"
                                type="button"
                                aria-label="Remove from wishlist">
                            <i class="far fa-heart"></i>
                        </button>

                        <a href="{{ route('product.details', $product->id) }}" style="display:block;width:100%;height:100%;">
                            <img src="{{ $productImage }}" alt="{{ $product->name }}">
                        </a>

                        <a href="{{ route('product.details', $product->id) }}" class="wishlist-view-btn">VIEW PRODUCT</a>
                    </div>

                    <div class="wishlist-info">
                        <h4 class="wishlist-title">
                            <a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                        </h4>

                        <div class="wishlist-price">₹{{ number_format($product->price, 2) }}</div>

                        @if($productColors->count() > 0)
                            <div class="color-badges">
                                @foreach($productColors->take(5) as $color)
                                    <span class="color-dot"
                                          style="background-color: {{ $color->hex_code ?? '#cccccc' }}"
                                          title="{{ $color->color_name }}"></span>
                                @endforeach
                                @if($productColors->count() > 5)
                                    <span class="more-colors">+{{ $productColors->count() - 5 }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @else
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
        @endif
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

.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 28px;
}

.wishlist-card {
    background: #fff;
}

.wishlist-image-wrap {
    position: relative;
    overflow: hidden;
    height: 400px;
}

.wishlist-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.wishlist-card:hover .wishlist-image-wrap img {
    transform: scale(1.05);
}

.wishlist-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    background: #111;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    letter-spacing: .5px;
    text-transform: uppercase;
}

.btn-remove-wishlist {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, .2);
    color: #d62828;
    transition: transform .2s ease;
}

.btn-remove-wishlist:hover {
    transform: scale(1.08);
}

.wishlist-view-btn {
    position: absolute;
    bottom: -50px;
    left: 0;
    width: 100%;
    background: #000;
    color: #fff;
    text-align: center;
    padding: 13px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: bottom .3s ease;
    text-decoration: none;
}

.wishlist-card:hover .wishlist-view-btn {
    bottom: 0;
    color: #fff;
}

.wishlist-info {
    padding: 14px 0 10px;
}

.wishlist-title {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
    margin-bottom: 6px;
}

.wishlist-title a {
    color: #111;
    text-decoration: none;
}

.wishlist-price {
    font-size: 15px;
    color: #e53935;
    font-weight: 700;
    margin-bottom: 8px;
}

.wishlist-colors-label {
    font-size: 12px;
    color: #666;
    margin-bottom: 6px;
}

.color-badges {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
}

.color-dot {
    width: 18px;
    height: 18px;
    display: inline-block;
    border-radius: 50%;
    border: 1px solid #ddd;
}

.more-colors {
    font-size: 12px;
    color: #888;
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

@media(max-width: 1200px) {
    .wishlist-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media(max-width: 991px) {
    .wishlist-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .wishlist-image-wrap {
        height: 320px;
    }
}

@media(max-width: 575px) {
    .wishlist-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection