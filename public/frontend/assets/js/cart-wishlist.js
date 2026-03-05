/**
 * Cart and Wishlist AJAX Functionality
 */
(function($) {
    'use strict';

    // Add to Cart AJAX
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $btn = $(this);
        const productId = $btn.data('product-id');
        
        // Validate product selection (size/color) if validation function exists
        if (typeof window.validateProductSelection === 'function') {
            if (!window.validateProductSelection()) {
                return false;
            }
        }
        
        // Get quantity from product details page, default to 1 if not found
        const quantityElement = $('#product-quantity');
        const quantity = quantityElement.length > 0 ? quantityElement.val() : 1;
        const selectedColor = $('input[name="product_color"]:checked').val();
        const selectedSize = $('input[name="product_size"]:checked').val();
        
        // Check if user is authenticated
        const isAuthenticated = $('meta[name="user-auth"]').attr('content') === 'true' ||
                               $('body').find('.user-profile-trigger').length > 0 || 
                               $('body').find('a[href*="logout"]').length > 0;
        
        if (!isAuthenticated) {
            window.location.href = '/login';
            return false;
        }

        // Disable button during request
        $btn.prop('disabled', true);
        const originalText = $btn.html();
        $btn.html('Adding...');

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
                    // Update all cart count instances on the page
                    updateAllCartCounts(response.cart_count);
                    
                    // Refresh sidebar cart in real-time
                    refreshSidebarCart();
                    
                    // Show success message
                    showMessage('Product added to cart successfully!', 'success');
                    
                    // Reset button
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                // Reset button
                $btn.html(originalText);
                $btn.prop('disabled', false);
                
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'Error adding product to cart. Please try again.';
                    showMessage(errorMessage, 'error');
                }
            }
        });
        
        return false;
    });

    // Add to Wishlist AJAX
    $(document).on('click', '.add-to-wishlist-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $btn = $(this);
        const productId = $btn.data('product-id');
        
        // Check if user is authenticated
        const isAuthenticated = $('meta[name="user-auth"]').attr('content') === 'true' ||
                               $('body').find('.user-profile-trigger').length > 0 || 
                               $('body').find('a[href*="logout"]').length > 0;
        
        if (!isAuthenticated) {
            window.location.href = '/login';
            return false;
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
                    
                    // Refresh sidebar wishlist
                    refreshSidebarWishlist();
                    
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
        
        return false;
    });

    // Function to refresh sidebar cart
    function refreshSidebarCart() {
        $.ajax({
            url: '/cart/sidebar-items',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Update all sidebar cart instances
                    $('.sidebar-action-list').each(function() {
                        const $parent = $(this).closest('.sidebar-cart');
                        if ($parent.length) {
                            $parent.find('.sidebar-action-list').html(response.html);
                            // Update sidebar totals
                            if (response.cart_total) {
                                $parent.find('.subtotal-price').text('INR ' + parseFloat(response.cart_total).toFixed(2));
                            }
                        }
                    });
                    
                    // Update cart count badges on the header/navigation
                    if (response.cart_count) {
                        updateAllCartCounts(response.cart_count);
                    }
                    
                    // If user is on the cart page, optionally refresh cart data 
                    // (can be extended to reload the page or update cart items dynamically)
                }
            },
            error: function(xhr) {
                console.log('Error refreshing sidebar cart:', xhr);
            }
        });
    }

    // Function to refresh sidebar wishlist
    function refreshSidebarWishlist() {
        $.ajax({
            url: '/wishlist/sidebar-items',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('.sidebar-action-list').each(function() {
                        const $parent = $(this).closest('.sidebar-wishlist');
                        if ($parent.length) {
                            $parent.find('.sidebar-action-list').html(response.html);
                        }
                    });
                }
            }
        });
    }

    // Function to update all cart count instances on the page
    function updateAllCartCounts(cartCount) {
        // Update all cart count badges
        $('.cart-count').each(function() {
            $(this).text(cartCount);
        });
        
        // Update any cart badge elements
        $('[data-cart-count]').text(cartCount);
    }

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
