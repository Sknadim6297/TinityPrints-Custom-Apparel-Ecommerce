/**
 * Cart and Wishlist AJAX Functionality
 */
(function($) {
    'use strict';

    // Add to Cart AJAX
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const quantity = $('#product-quantity').val() || 1;
        const selectedColor = $('input[name="product_color"]:checked').val();
        const selectedSize = $('input[name="product_size"]:checked').val();
        
        // Check if user is authenticated
        const isAuthenticated = $('body').find('.user-profile-trigger').length > 0 || 
                               $('body').find('a[href*="logout"]').length > 0;
        
        if (!isAuthenticated) {
            window.location.href = '/login';
            return;
        }

        // Disable button during request
        $btn.prop('disabled', true);
        const originalText = $btn.text();
        $btn.text('Adding...');

        $.ajax({
            url: '/cart',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                color_id: selectedColor,
                size: selectedSize,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update cart count
                    $('.cart-count').text(response.cart_count);
                    
                    // Show success message
                    showMessage('Product added to cart successfully!', 'success');
                    
                    // Reset button
                    $btn.text(originalText);
                    $btn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                // Reset button
                $btn.text(originalText);
                $btn.prop('disabled', false);
                
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    showMessage('Error adding product to cart. Please try again.', 'error');
                }
            }
        });
    });

    // Add to Wishlist AJAX
    $(document).on('click', '.add-to-wishlist-btn', function(e) {
        e.preventDefault();
        
        const $btn = $(this);
        const productId = $btn.data('product-id');
        
        // Check if user is authenticated
        const isAuthenticated = $('body').find('.user-profile-trigger').length > 0 || 
                               $('body').find('a[href*="logout"]').length > 0;
        
        if (!isAuthenticated) {
            window.location.href = '/login';
            return;
        }

        // Disable button during request
        $btn.prop('disabled', true);

        $.ajax({
            url: '/wishlist',
            method: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update wishlist count
                    $('.wishlist-count').text(response.wishlist_count);
                    
                    // Show success message
                    showMessage(response.message || 'Product added to wishlist successfully!', 'success');
                    
                    // Enable button again
                    $btn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                // Enable button again
                $btn.prop('disabled', false);
                
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    const response = xhr.responseJSON;
                    showMessage(response.message || 'Error adding product to wishlist.', 'error');
                }
            }
        });
    });

    // Helper function to show messages
    function showMessage(message, type) {
        // Remove any existing messages
        $('.ajax-message').remove();
        
        // Create message element
        const $message = $('<div>', {
            class: 'ajax-message alert alert-' + (type === 'success' ? 'success' : 'danger'),
            text: message,
            css: {
                position: 'fixed',
                top: '20px',
                right: '20px',
                zIndex: 9999,
                minWidth: '250px'
            }
        });
        
        // Add to body
        $('body').append($message);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            $message.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

})(jQuery);
