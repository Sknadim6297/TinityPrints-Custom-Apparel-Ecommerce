<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<main>
    <!-- Breadcrumb Start -->
    <section class="page-title-area" data-background="<?php echo e(asset('frontend/assets/img/banner/banner-1-1.jpg')); ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">Shopping Cart</h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
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
            <!-- Alert Container for Cart Messages -->
            <div id="cart-message-container"></div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($cartItems->count() > 0): ?>
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
                                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-cart-id="<?php echo e($item->id); ?>">
                                            <td class="product-thumbnail">
                                                <a href="<?php echo e(route('product.details', $item->product->id)); ?>">
                                                    <?php if($item->product->images->first()): ?>
                                                        <img src="<?php echo e(Storage::url($item->product->images->first()->image_path)); ?>" 
                                                             alt="<?php echo e($item->product->name); ?>" 
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('frontend/assets/img/product/product-img1.jpg')); ?>" 
                                                             alt="<?php echo e($item->product->name); ?>" 
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="<?php echo e(route('product.details', $item->product->id)); ?>">
                                                    <?php echo e($item->product->name); ?>

                                                </a>
                                                <?php if($item->color): ?>
                                                    <br><small class="text-muted">Color: <?php echo e($item->color->color_name); ?></small>
                                                <?php endif; ?>
                                                <?php if($item->size): ?>
                                                    <br><small class="text-muted">Size: <?php echo e($item->size); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="product-price">
                                                <span class="amount">INR <?php echo e(number_format($item->product->price, 2)); ?></span>
                                            </td>
                                            <td class="product-quantity text-center">
                                                <div class="product-quantity mt-10 mb-10">
                                                    <div class="product-quantity-form">
                                                        <button class="cart-minus" data-id="<?php echo e($item->id); ?>" type="button">
                                                            <i class="fal fa-minus"></i>
                                                        </button>
                                                        <input class="cart-input" type="text" value="<?php echo e($item->quantity); ?>" readonly>
                                                        <button class="cart-plus" data-id="<?php echo e($item->id); ?>" type="button">
                                                            <i class="far fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount item-total">INR <?php echo e(number_format($item->product->price * $item->quantity, 2)); ?></span>
                                            </td>
                                            <td class="product-remove">
                                                <form action="<?php echo e(route('cart.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-link text-danger p-0" 
                                                            onclick="return confirm('Are you sure you want to remove this item?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="<?php echo e(route('shop')); ?>" class="fill-btn">
                                    <i class="fal fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                            <div class="col-md-6">
                                <!-- Coupon Section -->
                                <div class="coupon-section mb-4">
                                    <h4 class="mb-3">Have a Coupon?</h4>
                                    <div class="input-group">
                                        <input type="text" id="coupon_code" class="form-control" placeholder="Enter coupon code" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px 0 0 5px;">
                                        <button class="btn btn-primary" id="apply_coupon_btn" type="button" style="background-color: var(--clr-common-heading); border: none; color: white; padding: 10px 20px; border-radius: 0 5px 5px 0; cursor: pointer;">Apply</button>
                                    </div>
                                    <div id="coupon_message" class="mt-2"></div>

                                    <!-- Applied Coupon Display -->
                                    <div id="applied_coupon_box" class="mt-3" style="display: none; background-color: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px; border-radius: 5px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <h5 style="margin: 0; color: #2e7d32;"><i class="fal fa-check-circle"></i> Coupon Applied</h5>
                                            <button id="remove_coupon_btn" type="button" style="background: none; border: none; color: #d32f2f; cursor: pointer; font-size: 18px;"><i class="fal fa-times"></i></button>
                                        </div>
                                        <div style="font-size: 14px; color: #333;">
                                            <p style="margin: 5px 0;"><strong>Code:</strong> <span id="applied_code"></span></p>
                                            <p style="margin: 5px 0;"><strong>Discount:</strong> <span id="applied_discount" style="color: #4caf50; font-weight: bold;"></span></p>
                                        </div>
                                    </div>

                                    <!-- Available Coupons Display -->
                                    <div id="available_coupons" class="mt-4"></div>
                                </div>

                                <div class="cart-page-total">
                                    <h2>Cart Totals</h2>
                                    <ul class="mb-20">
                                        <li>Subtotal <span id="cart-subtotal">₹<?php echo e(number_format($subtotal, 2)); ?></span></li>
                                        <li id="discount-row" style="display: none;">Discount <span id="cart-discount" style="color: #28a745;">-₹0.00</span></li>
                                        <li><strong>Total</strong> <span id="cart-total"><strong>₹<?php echo e(number_format($subtotal, 2)); ?></strong></span></li>
                                    </ul>
                                    <a class="border-btn" href="<?php echo e(route('checkout')); ?>">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fal fa-shopping-cart" style="font-size: 80px; color: #ddd;"></i>
                            <h3 class="mt-4">Your cart is empty</h3>
                            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                            <a href="<?php echo e(route('shop')); ?>" class="fill-btn mt-3">Start Shopping</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Cart Area End -->
</main>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        console.log('Cart page loaded. jQuery version:', $.fn.jquery);
        
        // Debug: Check if button exists
        console.log('Apply button found:', $('#apply_coupon_btn').length);
        console.log('Coupon code input found:', $('#coupon_code').length);
        
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
                url: '<?php echo e(url("cart")); ?>/' + cartId,
                method: 'PATCH',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update the quantity input
                        row.find('.cart-input').val(quantity);
                        
                        // Update the item total - Ensure proper INR formatting
                        let formattedTotal = (parseFloat(response.itemTotal) || 0).toFixed(2);
                        row.find('.item-total').text('₹' + parseFloat(formattedTotal).toLocaleString('en-IN'));
                        
                        // Update the cart subtotal and total
                        let formattedSubtotal = (parseFloat(response.subtotal) || 0).toFixed(2);
                        $('#cart-subtotal').text('₹' + parseFloat(formattedSubtotal).toLocaleString('en-IN'));
                        $('#cart-total').text('₹' + parseFloat(formattedSubtotal).toLocaleString('en-IN'));
                        
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
            
            // Clear previous messages and show new one in specific container
            $('#cart-message-container').html(alertHtml);
            
            // Auto-dismiss after 3 seconds
            setTimeout(function() {
                $('#cart-message-container').fadeOut('slow', function() {
                    $(this).html('').show();
                });
            }, 3000);
        }

        // Handle Coupon Application
        console.log('Setting up coupon button handler...');
        
        var button = $('#apply_coupon_btn');
        console.log('Button jQuery object:', button);
        console.log('Button DOM element:', button[0]);
        console.log('Button HTML:', button.html());
        console.log('Button ID:', button.attr('id'));
        
        if (button.length > 0) {
            button.click(function(e) {
                console.log('Apply button clicked!');
                e.preventDefault();
                e.stopPropagation();
                
                let couponCode = $('#coupon_code').val().trim();
                console.log('Coupon code entered:', couponCode);
                
                if (!couponCode) {
                    console.log('Empty coupon code');
                    showCouponMessage('Please enter a coupon code', 'error');
                    return;
                }

                console.log('Sending AJAX request with coupon:', couponCode);
                
                $.ajax({
                    url: '<?php echo e(route("cart.apply-coupon")); ?>',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        coupon_code: couponCode
                    },
                    success: function(response) {
                        console.log('AJAX success response:', response);
                        if (response.success) {
                            // Update totals
                            $('#cart-subtotal').text('₹' + parseFloat(response.subtotal).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            
                            if (response.discount > 0) {
                                $('#discount-row').show();
                                $('#cart-discount').text('-₹' + parseFloat(response.discount).toLocaleString('en-IN', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }));
                            }
                            
                            $('#cart-total').html('<strong>₹' + parseFloat(response.total).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + '</strong>');
                            
                            // Show applied coupon box
                            $('#applied_code').text(response.coupon_code);
                            $('#applied_discount').text('-₹' + parseFloat(response.discount).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            $('#applied_coupon_box').show();
                            
                            $('#coupon_code').val('');
                            showCouponMessage(response.message, 'success');
                            
                            // Reload available coupons
                            loadAvailableCoupons();
                        }
                    },
                    error: function(xhr) {
                        let message = 'Error applying coupon';
                        console.log('AJAX error response:', xhr);
                        
                        // Handle validation errors (422)
                        if (xhr.status === 422) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                // Validation error with field errors
                                message = Object.values(xhr.responseJSON.errors)[0][0];
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                // General validation error or custom message
                                message = xhr.responseJSON.message;
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        console.log('Error message to display:', message);
                        showCouponMessage(message, 'error');
                    }
                });
            });
        } else {
            console.error('Apply button not found!');
        }

        // Handle Enter key on coupon input
        $(document).on('keypress', '#coupon_code', function(e) {
            if (e.which === 13) {
                console.log('Enter key pressed on coupon input');
                e.preventDefault();
                $('#apply_coupon_btn').click();
                return false;
            }
        });

        function showCouponMessage(message, type) {
            let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            let alertHtml = `<div class="alert ${alertClass}" style="margin-top: 10px; padding: 10px; border-radius: 5px;">${message}</div>`;
            $('#coupon_message').html(alertHtml);
            
            setTimeout(function() {
                $('#coupon_message').fadeOut('slow', function() {
                    $(this).html('');
                    $(this).show();
                });
            }, 3000);
        }

        // Load available coupons on page load
        console.log('About to load available coupons...');
        loadAvailableCoupons();

        function loadAvailableCoupons() {
            console.log('loadAvailableCoupons() called');
            $.ajax({
                url: '<?php echo e(route("cart.available-coupons")); ?>',
                method: 'GET',
                success: function(response) {
                    console.log('Available coupons response:', response);
                    if (response.success && response.coupons.length > 0) {
                        console.log('Displaying', response.coupons.length, 'coupons');
                        displayAvailableCoupons(response.coupons);
                    } else {
                        console.log('No coupons available or API error');
                    }
                },
                error: function(xhr) {
                    console.log('Error loading coupons:', xhr);
                }
            });
        }

        function displayAvailableCoupons(coupons) {
            let html = '<div style="margin-top: 20px;"><h5 style="margin-bottom: 15px;">Available Coupons</h5>';
            
            coupons.forEach(function(coupon) {
                let discountText = coupon.discount_type === 'flat' 
                    ? '₹' + parseFloat(coupon.discount_value).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})
                    : coupon.discount_value + '%';
                
                let minOrderText = coupon.min_order_value 
                    ? 'Min: ₹' + parseFloat(coupon.min_order_value).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})
                    : 'No Minimum';
                
                let expiryText = coupon.expires_at 
                    ? 'Expires: ' + new Date(coupon.expires_at).toLocaleDateString('en-IN')
                    : 'No Expiry';

                html += `
                    <div class="coupon-card" data-coupon-code="${coupon.code}" style="background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 8px; padding: 12px; margin-bottom: 10px; cursor: pointer; transition: all 0.3s;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong style="font-size: 16px; color: var(--clr-common-heading);">${coupon.code}</strong>
                                <span style="margin-left: 10px; background-color: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                                    ${discountText} OFF
                                </span>
                            </div>
                            <div style="text-align: right; font-size: 12px; color: #666;">
                                <p style="margin: 2px 0;">${minOrderText}</p>
                                <p style="margin: 2px 0;">${expiryText}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            $('#available_coupons').html(html);
            
            // Add hover effects and click handlers using jQuery
            $('.coupon-card').hover(
                function() {
                    $(this).css({
                        'box-shadow': '0 2px 8px rgba(0,0,0,0.1)',
                        'transform': 'translateY(-2px)'
                    });
                },
                function() {
                    $(this).css({
                        'box-shadow': 'none',
                        'transform': 'translateY(0)'
                    });
                }
            );
            
            $('.coupon-card').click(function() {
                let code = $(this).data('coupon-code');
                applyCouponByCode(code);
            });
        }

        function applyCouponByCode(code) {
            console.log('applyCouponByCode() called with code:', code);
            $('#coupon_code').val(code);
            console.log('Coupon code set to:', $('#coupon_code').val());
            console.log('Triggering apply button click...');
            $('#apply_coupon_btn').click();
        }

        // Remove applied coupon
        $(document).on('click', '#remove_coupon_btn', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo e(route("cart.remove-coupon")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        // Reset to original subtotal
                        let originalSubtotal = parseFloat(response.subtotal);
                        $('#cart-subtotal').text('₹' + originalSubtotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                        $('#discount-row').hide();
                        $('#cart-discount').text('-₹0.00');
                        $('#cart-total').html('<strong>₹' + originalSubtotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</strong>');
                        $('#applied_coupon_box').hide();
                        $('#coupon_code').val('');
                        showCouponMessage('Coupon removed successfully!', 'success');
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\cart.blade.php ENDPATH**/ ?>