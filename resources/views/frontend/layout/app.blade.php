<!doctype html>
<html class="no-js" lang="zxx">

<head>
   @php($frontendAsset = asset('frontend/assets'))
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>@yield('title', config('app.name', 'Tinnity Ecom'))</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="user-auth" content="{{ Auth::check() ? 'true' : 'false' }}">
   @auth
      <meta name="wishlist-product-ids" content='@json(\App\Models\Wishlist::where('user_id', Auth::id())->pluck('product_id')->values()->all())'>
   @else
      <meta name="wishlist-product-ids" content='[]'>
   @endauth
   
   <link rel="icon" type="image/png" href="{{ asset('frontend/assets/img/logo/logo.png') }}">
   <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/assets/img/logo/logo.png') }}">
   
   <!-- CSS here -->
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/backToTop.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/ui-range-slider.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/nice-select.css') }}">
   <!-- Font Awesome 5 Pro - Local -->
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontAwesome5Pro.css') }}">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/flaticon.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
   <style>
      /* Custom User Profile Dropdown Styling */
      .user-profile-trigger {
         display: flex;
         flex-direction: column;
         align-items: center;
         text-decoration: none;
         color: #171717;
         gap: 5px;
      }
      .user-profile-trigger:hover {
         text-decoration: none;
      }
      .user-profile-trigger .user-icon {
         margin-bottom: 0;
      }
      .user-profile-trigger .user-name-text {
         font-size: 12px;
         font-weight: 500;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         max-width: 80px;
      }
      /* Remove Bootstrap default dropdown arrow */
      .user-profile-trigger::after {
         display: none !important;
      }
      /* Mobile user info styling */
      .mobile-user-info {
         padding: 15px;
         background: #f8f9fa;
         border-radius: 8px;
      }

      /* Offer popup */
      .offer-popup-overlay {
         position: fixed;
         inset: 0;
         background: rgba(0, 0, 0, 0.72);
         backdrop-filter: blur(3px);
         z-index: 9999;
         display: flex;
         align-items: center;
         justify-content: center;
         padding: 16px;
         opacity: 0;
         visibility: hidden;
         transition: opacity 0.35s ease, visibility 0.35s ease;
      }

      .offer-popup-overlay.is-visible {
         opacity: 1;
         visibility: visible;
      }

      .offer-popup-modal {
         position: relative;
         width: min(88vw, 520px);
         transform: translateY(12px) scale(0.98);
         transition: transform 0.35s ease;
      }

      .offer-popup-overlay.is-visible .offer-popup-modal {
         transform: translateY(0) scale(1);
      }

      .offer-popup-image {
         display: block;
         width: 100%;
         height: auto;
         max-height: 78vh;
         object-fit: contain;
         border-radius: 14px;
         box-shadow: 0 18px 50px rgba(0, 0, 0, 0.45);
      }

      .offer-popup-close {
         position: absolute;
         top: -12px;
         right: -12px;
         width: 34px;
         height: 34px;
         border: 0;
         border-radius: 50%;
         background: #ffffff;
         color: #111111;
         font-size: 20px;
         line-height: 1;
         font-weight: 700;
         cursor: pointer;
         box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
      }

      @media (max-width: 767px) {
         .offer-popup-modal {
            width: min(90vw, 360px);
         }

         .offer-popup-close {
            top: -10px;
            right: -6px;
         }
      }
   </style>
   @yield('styles')
</head>
<body>
 @include('frontend.partials.header')

    @if(!empty($showOfferPopup))
    <div class="offer-popup-overlay" id="offerPopupOverlay" aria-hidden="true">
        <div class="offer-popup-modal" role="dialog" aria-modal="true" aria-label="Special Offer">
            <button type="button" class="offer-popup-close" id="offerPopupClose" aria-label="Close popup">&times;</button>
            <img
                src=""
                data-src="{{ $offerPopupImageUrl }}"
                alt="Special offer"
                class="offer-popup-image"
                id="offerPopupImage"
                decoding="async"
            >
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')
   @yield('scripts')
     <!-- back to top start -->
   <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
   </div>
   <!-- back to top end -->


   <!-- JS here -->
   <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/vendor/waypoints.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/meanmenu.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/magnific-popup.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/parallax.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/backToTop.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/jquery-ui-slider-range.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/nice-select.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/counterup.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/ajax-form.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/cart-wishlist.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/auth-protection.js') }}"></script>
   <script>
      (function () {
         var popupSeenKey = 'tinnity_offer_popup_seen';
         var overlay = document.getElementById('offerPopupOverlay');
         var closeButton = document.getElementById('offerPopupClose');
         var popupImage = document.getElementById('offerPopupImage');
         var autoCloseTimer = null;

         if (!overlay || !closeButton) {
            return;
         }

         function closePopup() {
            if (!overlay.classList.contains('is-visible')) {
               return;
            }

            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
            sessionStorage.setItem(popupSeenKey, '1');

            if (autoCloseTimer) {
               window.clearTimeout(autoCloseTimer);
               autoCloseTimer = null;
            }
         }

         function openPopup() {
            overlay.classList.add('is-visible');
            overlay.setAttribute('aria-hidden', 'false');

            autoCloseTimer = window.setTimeout(function () {
               closePopup();
            }, 15000);
         }

         function loadPopupImage(onReady) {
            if (!popupImage) {
               onReady(false);
               return;
            }

            var targetSrc = popupImage.getAttribute('data-src');
            if (!targetSrc) {
               onReady(false);
               return;
            }

            if (popupImage.getAttribute('src') === targetSrc && popupImage.complete) {
               onReady(true);
               return;
            }

            popupImage.onload = function () {
               onReady(true);
            };
            popupImage.onerror = function () {
               onReady(false);
            };
            popupImage.src = targetSrc;
         }

         if (sessionStorage.getItem(popupSeenKey) === '1') {
            return;
         }

         closeButton.addEventListener('click', closePopup);

         overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
               closePopup();
            }
         });

         document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
               closePopup();
            }
         });

         if (popupImage) {
            popupImage.addEventListener('error', function () {
               closePopup();
            });
         }

         window.addEventListener('load', function () {
            loadPopupImage(function (loaded) {
               if (loaded) {
                  openPopup();
               }
            });
         });
      })();
   </script>
   @stack('scripts')
</body>
</html>