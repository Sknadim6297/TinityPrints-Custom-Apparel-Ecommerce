/**
 * Authentication & Protected Action Handler
 * This script handles unauthenticated user attempts to access protected actions
 * and redirects them to login with proper intent handling for redirect-after-login
 */

document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const CONFIG = {
        loginRoute: '/login',
        cartRoute: '/cart',
        wishlistRoute: '/wishlist',
        cartStoreRoute: '/cart'
    };

    /**
     * Check if user is authenticated
     * This is a simple check - in production, use a dedicated endpoint
     */
    function isAuthenticated() {
        // Check if Laravel session contains user data (basic check)
        return document.querySelector('meta[name="user-auth"]')?.content === 'true';
    }

    /**
     * Redirect to login with intended URL
     * @param {string} intendedUrl - The URL to redirect to after login
     */
    function redirectToLoginWithIntent(intendedUrl) {
        const loginUrl = new URL(CONFIG.loginRoute, window.location.origin);
        loginUrl.searchParams.set('redirect', intendedUrl || window.location.pathname);
        window.location.href = loginUrl.toString();
    }

    /**
     * Make AJAX request with proper error handling
     */
    async function makeRequest(url, options = {}) {
        try {
            const response = await fetch(url, {
                method: options.method || 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content,
                    'X-Requested-With': 'XMLHttpRequest',
                    ...options.headers
                },
                body: options.body ? JSON.stringify(options.body) : undefined
            });

            // Handle 401 Unauthorized - redirect to login
            if (response.status === 401) {
                const data = await response.json();
                redirectToLoginWithIntent(window.location.pathname);
                return null;
            }

            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Request error:', error);
            return null;
        }
    }

    /**
     * Handle Add to Cart button click
     */
    function setupAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        
        addToCartButtons.forEach(button => {
            const originalClickHandler = button.onclick;
            
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Check authentication
                if (!isAuthenticated()) {
                    redirectToLoginWithIntent(window.location.pathname);
                    return;
                }

                // Get selected size and color
                const selectedSize = document.querySelector('input[name="product_size"]:checked')?.value;
                const selectedColor = document.querySelector('input[name="product_color"]:checked')?.value;
                const quantity = parseInt(document.querySelector('#product-quantity')?.value || 1);
                const productId = this.dataset.productId;

                if (!productId) {
                    alert('Product ID not found');
                    return;
                }

                // Make add to cart request
                const result = await makeRequest(CONFIG.cartStoreRoute, {
                    method: 'POST',
                    body: {
                        product_id: productId,
                        color_id: selectedColor,
                        size: selectedSize,
                        quantity: quantity
                    }
                });

                if (result && result.success) {
                    // Show success message
                    showNotification('Product added to cart!', 'success');
                    
                    // Update cart count if available
                    updateCartCount(result.cart_count);
                } else if (result && result.error) {
                    showNotification(result.error, 'error');
                    if (result.error.includes('login')) {
                        redirectToLoginWithIntent(window.location.pathname);
                    }
                }
            });
        });
    }

    /**
     * Handle Add to Wishlist button click
     */
    function setupAddToWishlistButtons() {
        const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist-btn');
        
        addToWishlistButtons.forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Check authentication
                if (!isAuthenticated()) {
                    redirectToLoginWithIntent(CONFIG.wishlistRoute);
                    return;
                }

                const productId = this.dataset.productId;

                if (!productId) {
                    alert('Product ID not found');
                    return;
                }

                // Make add to wishlist request
                const result = await makeRequest(CONFIG.wishlistRoute, {
                    method: 'POST',
                    body: {
                        product_id: productId
                    }
                });

                if (result && result.success) {
                    showNotification('Product added to wishlist!', 'success');
                    updateWishlistCount(result.wishlist_count);
                } else if (result && result.error) {
                    showNotification(result.error, 'error');
                    if (result.error.includes('login')) {
                        redirectToLoginWithIntent(CONFIG.wishlistRoute);
                    }
                }
            });
        });
    }

    /**
     * Protect cart access
     */
    function protectCartAccess() {
        const cartLinks = document.querySelectorAll('a[href="/cart"]');
        cartLinks.forEach(function(cartLink) {
            cartLink.addEventListener('click', function(e) {
                if (!isAuthenticated()) {
                    e.preventDefault();
                    redirectToLoginWithIntent(CONFIG.cartRoute);
                    return false;
                }
            });
        });
    }

    /**
     * Protect wishlist access
     */
    function protectWishlistAccess() {
        const wishlistLinks = document.querySelectorAll('a[href="/wishlist"]');
        wishlistLinks.forEach(function(wishlistLink) {
            wishlistLink.addEventListener('click', function(e) {
                if (!isAuthenticated()) {
                    e.preventDefault();
                    redirectToLoginWithIntent(CONFIG.wishlistRoute);
                    return false;
                }
            });
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
            color: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    /**
     * Update cart count in header
     */
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => {
            el.textContent = count;
        });
    }

    /**
     * Update wishlist count in header
     */
    function updateWishlistCount(count) {
        const wishlistCountElements = document.querySelectorAll('.wishlist-count');
        wishlistCountElements.forEach(el => {
            el.textContent = count;
        });
    }

    /**
     * Handle redirect after login
     * Check if there's a redirect parameter in the URL and redirect the user
     */
    function handlePostLoginRedirect() {
        const params = new URLSearchParams(window.location.search);
        const redirect = params.get('redirect');
        
        if (redirect && isAuthenticated()) {
            // Remove the redirect param from history
            window.history.replaceState({}, document.title, window.location.pathname);
            // Could redirect here if needed
        }
    }

    // Initialize all handlers
    // NOTE: setupAddToCartButtons() is disabled - cart-wishlist.js handles add-to-cart with jQuery event delegation
    // setupAddToCartButtons();
    setupAddToWishlistButtons();
    protectCartAccess();
    protectWishlistAccess();
    handlePostLoginRedirect();
});
