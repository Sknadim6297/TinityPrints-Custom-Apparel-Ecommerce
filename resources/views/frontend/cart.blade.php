@extends('frontend.layout.app')
@section('title', 'Shopping Cart')

@section('content')
<main>
    <!-- Breadcrumb Start -->
    <section class="page-title-area" data-background="{{ asset('assets/img/bg/page-title-bg.html') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">Shopping Cart</h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                    <li class="trail-item trail-end"><span>Cart</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Cart Area Start -->
    <section class="cart-area pt-100 pb-100">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr data-cart-id="{{ $item->id }}">
                                            <td class="product-thumbnail">
                                                <a href="{{ route('product.details', $item->product->id) }}">
                                                    @if($item->product->images->first())
                                                        <img src="{{ Storage::url($item->product->images->first()->image_path) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/product/product-img1.jpg') }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{ route('product.details', $item->product->id) }}">
                                                    {{ $item->product->name }}
                                                </a>
                                                @if($item->color)
                                                    <br><small class="text-muted">Color: {{ $item->color->color_name }}</small>
                                                @endif
                                                @if($item->size)
                                                    <br><small class="text-muted">Size: {{ $item->size }}</small>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                <span class="amount">INR {{ number_format($item->product->price, 2) }}</span>
                                            </td>
                                            <td class="product-quantity text-center">
                                                <div class="product-quantity mt-10 mb-10">
                                                    <div class="product-quantity-form">
                                                        <button class="cart-minus" data-id="{{ $item->id }}" type="button">
                                                            <i class="far fa-minus"></i>
                                                        </button>
                                                        <input class="cart-input" type="text" value="{{ $item->quantity }}" readonly>
                                                        <button class="cart-plus" data-id="{{ $item->id }}" type="button">
                                                            <i class="far fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount item-total">INR {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                            </td>
                                            <td class="product-remove">
                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" 
                                                            onclick="return confirm('Are you sure you want to remove this item?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('shop') }}" class="fill-btn">
                                    <i class="fal fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="cart-page-total float-md-end">
                                    <h2>Cart Totals</h2>
                                    <ul class="mb-20">
                                        <li>Subtotal <span id="cart-subtotal">₹{{ number_format($subtotal, 2) }}</span></li>
                                        <li><strong>Total</strong> <span id="cart-total"><strong>₹{{ number_format($subtotal, 2) }}</strong></span></li>
                                    </ul>
                                    <a class="border-btn" href="{{ route('checkout') }}">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fal fa-shopping-cart" style="font-size: 80px; color: #ddd;"></i>
                            <h3 class="mt-4">Your cart is empty</h3>
                            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                            <a href="{{ route('shop') }}" class="fill-btn mt-3">Start Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Cart Area End -->
</main>

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle quantity increase
        $('.cart-plus').on('click', function(e) {
            e.preventDefault();
            let cartId = $(this).data('id');
            let input = $(this).siblings('.cart-input');
            let currentQty = parseInt(input.val());
            let newQty = currentQty + 1;
            
            updateCartQuantity(cartId, newQty, $(this).closest('tr'));
        });

        // Handle quantity decrease
        $('.cart-minus').on('click', function(e) {
            e.preventDefault();
            let cartId = $(this).data('id');
            let input = $(this).siblings('.cart-input');
            let currentQty = parseInt(input.val());
            
            if (currentQty > 1) {
                let newQty = currentQty - 1;
                updateCartQuantity(cartId, newQty, $(this).closest('tr'));
            }
        });

        function updateCartQuantity(cartId, quantity, row) {
            $.ajax({
                url: '{{ url("cart") }}/' + cartId,
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update the quantity input
                        row.find('.cart-input').val(quantity);
                        
                        // Update the item total
                        row.find('.item-total').text('₹' + response.itemTotal.toFixed(2));
                        
                        // Update the cart subtotal and total
                        $('#cart-subtotal').text('₹' + response.subtotal.toFixed(2));
                        $('#cart-total').text('₹' + response.subtotal.toFixed(2));
                        
                        // Show success message
                        showMessage('Cart updated successfully', 'success');
                    }
                },
                error: function(xhr) {
                    let message = 'Error updating cart';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showMessage(message, 'error');
                }
            });
        }

        function showMessage(message, type) {
            let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            let alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            $('.container').prepend(alertHtml);
            
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>
@endpush
@endsection