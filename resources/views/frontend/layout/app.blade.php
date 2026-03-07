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
   </style>
   @yield('styles')
</head>
<body>
 @include('frontend.partials.header')

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
   @stack('scripts')
</body>
</html>