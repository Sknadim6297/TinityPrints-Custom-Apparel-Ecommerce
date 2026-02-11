<!doctype html>
<html class="no-js" lang="zxx">

<head>
   @php($frontendAsset = asset('frontend/assets'))
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>@yield('title', config('app.name', 'Tinnity Ecom'))</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
   
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
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontAwesome5Pro.css') }}">
   <!-- Font Awesome 6 CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/flaticon.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
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
</body>
</html>