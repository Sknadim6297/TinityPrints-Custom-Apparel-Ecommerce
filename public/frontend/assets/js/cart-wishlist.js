/**
 * Cart and Wishlist AJAX Functionality
 */
(function($) {
    'use strict';

    let removeWishlistModal = null;
    let pendingRemoveProductId = null;
    let lastToastKey = '';
    let lastToastAt = 0;

    function ensureRemoveWishlistModal() {
        if (document.getElementById('globalRemoveWishlistModal')) {
            if (!removeWishlistModal && typeof bootstrap !== 'undefined') {
                removeWishlistModal = new bootstrap.Modal(document.getElementById('globalRemoveWishlistModal'));
            }
            return;
        }

        const modalHtml = `
            <div class="modal fade" id="globalRemoveWishlistModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Remove from Wishlist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove this item from your wishlist?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirm-remove-wishlist-btn">Remove</button>
                        </div>
                    </div>
                </div>
            </div>`;

        $('body').append(modalHtml);

        if (typeof bootstrap !== 'undefined') {
            removeWishlistModal = new bootstrap.Modal(document.getElementById('globalRemoveWishlistModal'));
        }

        $(document).on('click', '#confirm-remove-wishlist-btn', function() {
            if (!pendingRemoveProductId) {
                return;
            }

            const productId = pendingRemoveProductId;
            pendingRemoveProductId = null;

            $.ajax({
                url: '/wishlist/product/' + productId,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const selector = '.add-to-wishlist-btn[data-product-id="' + productId + '"]';
                    $(selector).removeClass('wl-active').prop('disabled', false);
                    $(selector).each(function() {
                        const $icon = $(this).find('i');
                        if ($icon.length) {
                            $icon.removeClass('fas').addClass('far').css('color', '');
                        }
                    });

                    if (response && typeof response.wishlist_count !== 'undefined') {
                        $('.wishlist-count').text(response.wishlist_count);
                    }

                    refreshSidebarWishlist();
                    showMessage((response && response.message) || 'Removed from wishlist.', 'success');
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {};
                    showMessage(response.message || 'Unable to remove from wishlist.', 'error');
                },
                complete: function() {
                    if (removeWishlistModal) {
                        removeWishlistModal.hide();
                    }
                }
            });
        });
    }

    function markWishlistButtonsActive(productId) {
        const selector = '.add-to-wishlist-btn[data-product-id="' + productId + '"]';
        $(selector).addClass('wl-active').prop('disabled', false);
        $(selector).each(function() {
            const $icon = $(this).find('i');
            if ($icon.length) {
                $icon.removeClass('far').addClass('fas').css('color', '#e60023');
            }
        });
    }

    function handleWishlistButton($btn) {
        if (!$btn || !$btn.length) {
            return false;
        }

        if ($btn.data('wlProcessing') === true) {
            return false;
        }

        if ($btn.hasClass('wl-active')) {
            pendingRemoveProductId = $btn.data('product-id');
            if (removeWishlistModal) {
                removeWishlistModal.show();
            } else {
                const shouldRemove = window.confirm('Are you sure you want to remove this item from your wishlist?');
                if (shouldRemove) {
                    $('#confirm-remove-wishlist-btn').trigger('click');
                }
            }
            return false;
        }

        const productId = $btn.data('product-id');

        // Check if user is authenticated
        const isAuthenticated = $('meta[name="user-auth"]').attr('content') === 'true' ||
            $('body').find('.user-profile-trigger').length > 0 ||
            $('body').find('a[href*="logout"]').length > 0;

        if (!isAuthenticated) {
            // Store the intended URL and redirect through auth
            window.location.href = '/auth/login?redirect_to=' + encodeURIComponent(window.location.href);
            return false;
        }

        // Disable button during request
        $btn.data('wlProcessing', true);
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

                    // Mark as active on all matching buttons for the same product.
                    markWishlistButtonsActive(productId);

                    // Refresh sidebar wishlist
                    refreshSidebarWishlist();

                    // Show success message
                    showMessage(response.message || 'Product added to wishlist successfully!', 'success');
                } else {
                    // API returns this shape when product is already in wishlist.
                    markWishlistButtonsActive(productId);
                    showMessage(response.message || 'Already in wishlist.', 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/auth/login';
                } else {
                    const response = xhr.responseJSON;
                    showMessage(response.message || 'Error adding product to wishlist.', 'error');
                }
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.data('wlProcessing', false);
            }
        });

        return false;
    }

    // Direct helper so inline onclick buttons (home cards) can reliably use same flow.
    window.tinnityToggleWishlist = function(event, element) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        return handleWishlistButton($(element));
    };

    // On initial page load, mark already wishlisted products in red on every page.
    $(function() {
        ensureRemoveWishlistModal();

        const rawIds = ($('meta[name="wishlist-product-ids"]').attr('content') || '[]').trim();
        let ids = [];

        try {
            ids = JSON.parse(rawIds);
        } catch (e) {
            ids = [];
        }

        if (!Array.isArray(ids)) {
            ids = [];
        }

        ids.forEach(function(id) {
            markWishlistButtonsActive(id);
        });
    });

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
            // Store the intended URL and redirect through auth
            window.location.href = '/auth/login?redirect_to=' + encodeURIComponent(window.location.href);
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
                    window.location.href = '/auth/login';
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
        if (e.isDefaultPrevented()) {
            return false;
        }

        e.preventDefault();
        e.stopPropagation();

        return handleWishlistButton($(this));
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
                            syncCartSidebarFooter($parent, response);
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

    function syncCartSidebarFooter($parent, response) {
        const cartCount = parseInt((response && response.cart_count) || 0, 10);
        const cartTotal = parseFloat((response && response.cart_total) || 0);
        const totalText = 'INR ' + cartTotal.toFixed(2);

        let $total = $parent.find('.product-price-total');
        let $actions = $parent.find('.sidebar-action-btn');

        if (cartCount > 0) {
            if ($total.length === 0) {
                $total = $(
                    '<div class="product-price-total">' +
                    '  <span>Subtotal :</span>' +
                    '  <span class="subtotal-price"></span>' +
                    '</div>'
                );
                $parent.append($total);
            }

            $total.find('.subtotal-price').text(totalText);

            if ($actions.length === 0) {
                $actions = $(
                    '<div class="sidebar-action-btn">' +
                    '  <a href="/cart" class="fill-btn">View Full Cart</a>' +
                    '  <a href="/checkout" class="border-btn">Checkout</a>' +
                    '</div>'
                );
                $parent.append($actions);
            }
        } else {
            $total.remove();
            $actions.remove();
        }
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

    function ensureToastStyles() {
        if (document.getElementById('tinnity-toast-styles')) {
            return;
        }

        const css = `
            #tinnity-toast-stack {
                position: fixed;
                top: 24px;
                right: 24px;
                z-index: 11000;
                display: flex;
                flex-direction: column;
                gap: 10px;
                pointer-events: none;
            }

            .tinnity-toast {
                min-width: 280px;
                max-width: 360px;
                border-radius: 12px;
                border: 1px solid #ececec;
                background: #ffffff;
                color: #171717;
                box-shadow: 0 16px 30px rgba(0, 0, 0, 0.14);
                transform: translateY(-12px) scale(.98);
                opacity: 0;
                transition: all .22s ease;
                pointer-events: auto;
                overflow: hidden;
            }

            .tinnity-toast.is-visible {
                transform: translateY(0) scale(1);
                opacity: 1;
            }

            .tinnity-toast__body {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 14px;
                font-size: 13px;
                line-height: 1.45;
                font-weight: 500;
            }

            .tinnity-toast__icon {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                margin-top: 1px;
                font-size: 11px;
            }

            .tinnity-toast.t-success {
                border-left: 4px solid #0f9f5f;
            }

            .tinnity-toast.t-success .tinnity-toast__icon {
                color: #fff;
                background: #0f9f5f;
            }

            .tinnity-toast.t-error {
                border-left: 4px solid #111;
            }

            .tinnity-toast.t-error .tinnity-toast__icon {
                color: #111;
                background: #ffd54f;
            }

            .tinnity-toast__progress {
                height: 2px;
                width: 100%;
                transform-origin: left;
                animation: tinnity-toast-progress 3.2s linear forwards;
            }

            .tinnity-toast.t-success .tinnity-toast__progress {
                background: #0f9f5f;
            }

            .tinnity-toast.t-error .tinnity-toast__progress {
                background: #111;
            }

            @keyframes tinnity-toast-progress {
                from { transform: scaleX(1); }
                to { transform: scaleX(0); }
            }

            @media (max-width: 768px) {
                #tinnity-toast-stack {
                    top: 14px;
                    right: 14px;
                    left: 14px;
                }

                .tinnity-toast {
                    min-width: auto;
                    max-width: none;
                }
            }
        `;

        $('<style id="tinnity-toast-styles"></style>').text(css).appendTo('head');
    }

    function getToastContainer() {
        ensureToastStyles();

        let $stack = $('#tinnity-toast-stack');
        if ($stack.length === 0) {
            $('body').append('<div id="tinnity-toast-stack" aria-live="polite" aria-atomic="true"></div>');
            $stack = $('#tinnity-toast-stack');
        }

        return $stack;
    }

    // Helper function to show messages
    function showMessage(message, type) {
        const text = (message || '').toString().trim();
        if (!text) {
            return;
        }

        const now = Date.now();
        const key = type + '::' + text;
        if (key === lastToastKey && (now - lastToastAt) < 900) {
            return;
        }
        lastToastKey = key;
        lastToastAt = now;

        const toastType = type === 'success' ? 't-success' : 't-error';
        const iconClass = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation';
        const $toast = $(`
            <div class="tinnity-toast ${toastType}" role="status">
                <div class="tinnity-toast__body">
                    <span class="tinnity-toast__icon"><i class="${iconClass}"></i></span>
                    <span class="tinnity-toast__text"></span>
                </div>
                <div class="tinnity-toast__progress"></div>
            </div>
        `);

        $toast.find('.tinnity-toast__text').text(text);
        getToastContainer().append($toast);

        requestAnimationFrame(function() {
            $toast.addClass('is-visible');
        });

        setTimeout(function() {
            $toast.removeClass('is-visible');
            setTimeout(function() {
                $toast.remove();
            }, 230);
        }, 3200);
    }

})(jQuery);
