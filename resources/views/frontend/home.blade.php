@extends('frontend.layout.app')
@section('title', 'Home')
@section('content')
    @php
        $frontendAsset = asset('frontend/assets');
        $homeSettings = $homeSettings ?? \App\Models\HomeSetting::defaults();
        $heroSlides = $homeSettings['hero_slides'] ?? [];
        $sideBanners = $homeSettings['side_banners'] ?? [];
        $bestSellerConfig = $homeSettings['best_seller'] ?? [];
        $brandStory = $homeSettings['brand_story'] ?? [];
        $limitedEditionConfig = $homeSettings['limited_edition'] ?? [];
        $collectionReels = $homeSettings['collection_reels'] ?? [];
        $customDesign = $homeSettings['custom_design'] ?? [];
        $whyChoose = $homeSettings['why_choose'] ?? [];
        $blogConfig = $homeSettings['blog'] ?? [];
        $instagramConfig = $homeSettings['instagram'] ?? [];
        $contactCta = $homeSettings['contact_cta'] ?? [];
        $featureBoxes = $homeSettings['feature_boxes'] ?? [];

        $resolveLink = function ($link, $fallback = '#') {
            if (blank($link)) {
                return $fallback;
            }

            return \Illuminate\Support\Str::startsWith($link, ['http://', 'https://', 'mailto:', 'tel:'])
                ? $link
                : url($link);
        };

        $storyImage = $brandStory['image_url'] ?? '/frontend/assets/img/banner/story.jpg';
        $storyImageUrl = \Illuminate\Support\Str::startsWith($storyImage, ['http://', 'https://'])
            ? $storyImage
            : asset(ltrim($storyImage, '/'));
    @endphp
    <style>
        /* Hero Banner Section */

        html,
        body {
            overflow-x: hidden;
        }

        .side-images-section {
            overflow: hidden;
        }

        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        .hero-banner-slider {
            position: relative;
            width: 100%;
        }

        .hero-banner {
            position: relative;
            height: 600px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: rgba(0, 0, 0, 0.4); */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            color: white;
            padding: 40px;
            text-align: center;
            margin-bottom: 80px;
        }

        .hero-subtitle {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #facc15;
            animation: fadeInUp 0.6s ease;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 30px;
            /* text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); */
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero-btn {
            display: inline-block;
            padding: 14px 35px;
            background: linear-gradient(to right, #ffffff, #ffffff);
            color: black;
            text-decoration: none;
            /* border-radius: 8px; */
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 15px;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .hero-btn:hover {
            background: linear-gradient(to right, #ffffff, #ffffff);
            color: black
                /* transform: translateY(-2px); */
                /* box-shadow: 0 8px 20px rgba(250, 204, 21, 0.3); */
        }

        /* Swiper Slider Styles */
        .hero-slider__active {
            width: 100%;
            position: relative;
        }

        .hero-pagination {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .hero-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.6);
            opacity: 0.6;
            transition: all 0.3s ease;
            border-radius: 50%;
            cursor: pointer;
        }

        .hero-pagination .swiper-pagination-bullet-active {
            background: #facc15;
            opacity: 1;
            width: 30px;
            border-radius: 6px;
        }

        .hero-button-prev,
        .hero-button-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .hero-button-prev {
            left: 30px;
        }

        .hero-button-next {
            right: 30px;
        }

        .hero-button-prev:hover,
        .hero-button-next:hover {
            background: #facc15;
            border-color: #facc15;
            color: #111;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-banner {
                height: 400px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 14px;
            }

            .hero-content {
                padding: 30px 20px;
                max-width: 100%;
                margin-bottom: 60px;
            }

            .hero-button-prev,
            .hero-button-next {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .hero-button-prev {
                left: 15px;
            }

            .hero-button-next {
                right: 15px;
            }
        }


        /* Side Images Section */
        /* Side Images Section */

        .side-images-section {
            background: #f9f9f9;
            padding: 0;
            overflow: hidden;
        }

        .side-image-col {
            position: relative;
            height: 450px;
            overflow: hidden;
            border-top: 3px solid #fff;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* split line */
        .side-image-col:first-child {
            border-right: 3px solid #fff;
        }

        /* overlay content */

        .image {
            text-align: bottom-left;
            color: #000000;
            /* background: rgba(0, 0, 0, 0.45); */
            padding: 30px;
            border-radius: 6px;
        }

        .image h3 {
            font-size: 35px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #000000;
        }

        .image p {
            font-size: 20px;
            margin-bottom: 18px;
            color: #000000;
        }

        /* button */

        .image .btn {
            /* display: inline-block; */
            background: #ffffff;
            color: #111;
            padding: 12px 26px;
            font-weight: 600;
            text-decoration: none;
            border: none
                /* border-radius: 4px; */
        }

        .image .btn:hover {
            /* background: #eab308; */
        }


        /* STORY SECTION */

        .brand-story-section {
            width: 100%;
        }

        .brand-story-wrapper {
            display: flex;
            min-height: 550px;
        }

        /* LEFT IMAGE */

        .brand-story-image {
            width: 50%;
        }

        .brand-story-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* RIGHT CONTENT */

        .brand-story-content {
            width: 50%;
            background: #000;
            color: #fff;
            padding: 80px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .story-title {
            font-size: 48px;
            font-weight: 800;
            color: white margin-bottom: 10px;
        }

        .story-subtitle {
            font-size: 22px;
            letter-spacing: 3px;
            color: white margin-bottom: 25px;
        }

        .story-text {
            font-size: 16px;
            line-height: 1.7;
            color: white;
            opacity: .85;
            margin-bottom: 40px;
        }

        /* FEATURES */

        .story-features {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .story-feature {
            text-align: center;
            width: 22%;
        }

        .story-feature i {
            font-size: 28px;
            margin-bottom: 10px;
            display: block;
        }

        .story-feature span {
            font-size: 13px;
            letter-spacing: 1px;
        }

        /* RESPONSIVE */

        @media(max-width:991px) {

            .brand-story-wrapper {
                flex-direction: column;
            }

            .brand-story-image,
            .brand-story-content {
                width: 100%;
            }

            .brand-story-content {
                padding: 50px 30px;
                text-align: center;
            }

            .story-features {
                justify-content: center;
            }

            .story-feature {
                width: 45%;
            }

        }

        .author-thumb {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #eee;
        }

        .author-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .best-seller {
            padding: 60px 0;
            background: #fff;
        }

        .best-seller .container {
            width: 100%;
            max-width: 1200px;
            padding: 0 20px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            width: 100%;
        }

        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px;
            }

            .section-header {
                flex-wrap: wrap;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .best-seller .container,
            .limited-edition .container {
                padding: 0 14px;
            }

            .section-header {
                align-items: flex-start;
                margin-bottom: 20px;
            }

            .section-header h2 {
                font-size: 26px;
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .product-card {
                min-height: auto;
            }

            .product-img img {
                height: 340px;
            }
        }

        .product-card {
            position: relative;
            min-height: 450px;
            display: flex;
            flex-direction: column;
        }

        .product-info {
            padding-top: 10px;
        }

        .product-info h4 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .section-header h2 {
            font-size: 32px;
            margin: 0;
        }

        .section-header p {
            color: #777;
            margin: 0;
        }

        .shop-link {
            text-decoration: none;
            font-weight: 600;
            color: #000;
        }

        .price {
            font-size: 14px;
        }

        .price .old {
            text-decoration: line-through;
            color: #999;
            margin-right: 6px;
        }

        .price .new {
            color: #e53935;
            font-weight: 600;
        }

        .product-img {
            position: relative;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e53935;
            color: #fff;
            padding: 4px 10px;
            font-size: 12px;
            border-radius: 4px;
            z-index: 2;
        }

        .wishlist {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .cart-btn {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            background: #000;
            color: #fff;
            border: none;
            padding: 12px;
            transition: 0.3s;
        }

        .product-img:hover .cart-btn {
            bottom: 0;
        }

        /* Compact testimonial section overrides */
        .testimonials-area {
            padding: 60px 0 !important;
        }
        .testimonial-wrapper {
            max-width: 800px !important;
        }
        .testimonial-author {
            margin-bottom: 15px !important;
        }
        .testimonial-author .author-name {
            font-size: 24px !important;
        }
        .author-text p {
            font-size: 20px !important;
            margin-bottom: 20px !important;
            line-height: 1.4;
        }
        .author-thumb {
            width: 120px !important;
            height: 120px !important;
        }
        .testimonial-pagination {
            margin-top: 30px !important;
        }
        .testimonial-button-prev,
        .testimonial-button-next {
            top: 100px !important;
        }

        .limited-edition {
            padding: 60px 0;
            background: #fff;
        }

        .limited-edition .container {
            width: 100%;
            max-width: 1200px;
            padding: 0 20px;
            margin: 0 auto;
        }

        .section-divider {
            border: none;
            height: 2.5px;
            background: #4b4545;
            margin: 40px 0;
        }

        .collection-reels {
            padding: 60px 0;
            text-align: center;
        }

        .reel-title {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .reel-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .reel-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
        }

        .reel-slider::-webkit-scrollbar {
            display: none;
        }

        .reel-card {
            min-width: 220px;
            height: 380px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .reel-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reel-overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            color: white;
            font-weight: 600;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        }

        .reel-btn {
            background: white;
            border: none;
            font-size: 22px;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }


        .reel-card {
            min-width: 220px;
            height: 380px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
            text-decoration: none;
            display: block;
        }

        .custom-design-section {
            display: flex;
            width: 100%;
            height: 450px;
            margin: 80px 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        /* LEFT SIDE */

        .custom-left {
            flex: 1;
            background: #000;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            clip-path: polygon(0 0, 90% 0, 106% 100%, 0% 100%);
            position: relative;
            z-index: 2;
        }

        /* RIGHT SIDE */

        .custom-right {
            flex: 1;
            background: #d4af37;
            color: #000;
            display: flex;
            align-items: center;
            /* clip-path: polygon(0 0, 90% 0, 106% 100%, 0% 100%); */
            justify-content: center;

            /* IMPORTANT FIX */
            margin-left: -120px;
            padding-left: 140px;
        }

        @media (max-width: 992px) {
            .custom-design-section {
                flex-direction: column;
                height: auto;
                margin: 50px 0;
            }

            .custom-left,
            .custom-right {
                width: 100%;
                clip-path: none;
            }

            .custom-left {
                padding: 50px 20px 30px;
            }

            .custom-right {
                margin-left: 0;
                padding: 30px 20px 50px;
            }

            .custom-left h2,
            .custom-right h2 {
                font-size: 36px;
            }

            .custom-left .content,
            .custom-right .content {
                max-width: 100%;
            }
        }

        .custom-left .content {
            max-width: 380px;
        }

        .custom-left h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .custom-left p {
            font-size: 16px;
            color: #cfcfcf;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .design-btn {
            display: inline-block;
            padding: 14px 32px;
            background: #d4af37;
            color: #000;
            font-weight: 600;
            /* border-radius:6px; */
            text-decoration: none;
            transition: 0.3s;
        }

        .design-btn:hover {
            background: #c59a2e;
        }

        /* RIGHT SIDE */



        .custom-right .content {
            max-width: 380px;
        }

        .custom-right h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .custom-right p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .shop-btn {
            display: inline-block;
            padding: 14px 32px;
            background: #000;
            color: #fff;
            font-weight: 600;
            /* border-radius:6px; */
            text-decoration: none;
            transition: 0.3s;
        }

        .shop-btn:hover {
            background: white;
        }

        .design-steps {
            display: flex;
            width: 100%;
            margin: 0;
            font-family: Poppins, sans-serif;
        }

        .step {
            flex: 1;
            position: relative;
            padding: 40px 60px;
            clip-path: polygon(0 0, 92% 0, 100% 50%, 92% 100%, 0 100%, 8% 50%);
        }

        .step-content {
            max-width: 260px;
        }

        .step h3 {
            font-size: 34px;
            margin-bottom: 10px;
        }

        .step h4 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .step p {
            font-size: 14px;
            line-height: 1.5;
        }

        /* COLORS */

        .step-dark {
            background: #000;
            color: #fff;
        }

        .step-light {
            background: #f5f5f5;
            color: #000;
        }

        /* CONNECT STEPS */

        .step+.step {
            margin-left: -60px;
        }

        .blog-section {
            padding: 50px 0;

            font-family: Poppins, sans-serif;
            width: 100%;
            max-width: 1200px;
            padding: 0 20px;
            margin: 0 auto;
        }

        .blog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .blog-header h2 {
            font-size: 36px;
            margin-bottom: 5px;
        }

        .blog-header p {
            color: #666;
        }

        .view-all {
            text-decoration: none;
            color: #000;
            font-weight: 600;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .blog-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .blog-content {
            padding-top: 15px;
        }

        .blog-date {
            font-size: 12px;
            color: #999;
            letter-spacing: 1px;
        }

        .blog-tag {
            display: inline-block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #111;
        }

        .blog-content h3 {
            font-size: 22px;
            margin: 10px 0;
        }

        .blog-content p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .read-more {
            display: inline-block;
            margin-top: 10px;
            font-weight: 600;
            color: #000;
            text-decoration: none;
            border-bottom: 1px solid #000;
        }

        @media (max-width: 992px) {
            .blog-section {
                padding: 0 16px;
            }

            .blog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 22px;
            }

            .blog-content h3 {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .blog-section {
                padding: 0 14px;
            }

            .blog-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 24px;
            }

            .blog-header h2 {
                font-size: 28px;
            }

            .blog-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .blog-card img {
                height: 220px;
            }

            .blog-content h3 {
                font-size: 18px;
                line-height: 1.35;
            }

            .blog-content p {
                font-size: 13px;
            }
        }

        .why-choose-section {
            padding: 80px 0;
            background: #f9f9f9;
            font-family: Poppins, sans-serif;
        }

        .why-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .why-header h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .why-header p {
            color: #666;
            font-size: 16px;
        }

        /* grid */

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        /* card */

        .why-card {
            background: #fff;
            padding: 35px 25px;
            text-align: center;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .why-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* icon */

        .why-icon {
            font-size: 32px;
            color: #facc15;
            margin-bottom: 15px;
        }

        .why-card h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .why-card p {
            font-size: 14px;
            color: #666;
        }

        /* responsive */

        @media(max-width:992px) {
            .why-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:576px) {
            .why-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>


    <!-- hero banner start -->
    <div class="hero-banner-slider">
        <div class="swiper-container hero-slider__active">
            <div class="swiper-wrapper">
                @foreach ($heroSlides as $slide)
                    <div class="swiper-slide">
                        <div class="hero-banner" style="background-image: url('{{ $slide['image_url'] ?? '' }}')">
                            <div class="hero-content">
                                <div class="hero-subtitle">{{ $slide['subtitle'] ?? '' }}</div>
                                <h1 class="hero-title">{{ $slide['title_line_1'] ?? '' }}<br>{{ $slide['title_line_2'] ?? '' }}</h1>
                                <a href="{{ $resolveLink($slide['button_link'] ?? '/shop', route('shop')) }}" class="hero-btn">{{ $slide['button_text'] ?? 'Shop Now' }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-prev hero-button-prev"><i class="fas fa-chevron-left"></i></div>
            <div class="swiper-button-next hero-button-next"><i class="fas fa-chevron-right"></i></div>
        </div>
    </div>
    <!-- hero banner end -->

    <!-- side images section start -->
    <section class="side-images-section">
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                @foreach ($sideBanners as $banner)
                    <div class="col-lg-6 side-image-col" style="background-image: url('{{ $banner['image_url'] ?? '' }}')">
                        <div class="image">
                            <h3 style="background-color: #000; padding:10px;color: white;margin-top: 50px;">{{ $banner['title'] ?? '' }}</h3>
                            <p style="background-color: #000; padding:10px;color: white;">{{ $banner['subtitle'] ?? '' }}</p>
                            <a href="{{ $resolveLink($banner['button_link'] ?? '/shop', route('shop')) }}" class="btn btn-primary">{{ $banner['button_text'] ?? 'Shop Now' }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- side images section end -->

    <!-- product area start  -->
    <section class="best-seller">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>{{ $bestSellerConfig['title'] ?? 'Best Seller' }}</h2>
                    <p>{{ $bestSellerConfig['subtitle'] ?? '' }}</p>
                </div>
                <a href="{{ $resolveLink($bestSellerConfig['view_all_link'] ?? '/shop', route('shop')) }}" class="shop-link">{{ $bestSellerConfig['view_all_text'] ?? 'View All' }}</a>
            </div>

            <div class="product-grid">
                @forelse ($bestSellerProducts as $product)
                    @php
                        $productImagePath = optional($product->images->first())->image_path;
                        $productImage = $productImagePath
                            ? Storage::url($productImagePath)
                            : 'https://via.placeholder.com/600x800?text=Product+Image';
                    @endphp
                    <div class="product-card">
                        <span class="badge">{{ $product->is_limited_edition ? ($limitedEditionConfig['badge_text'] ?? 'LIMITED') : 'TRENDING' }}</span>
                        <span class="wishlist">♡</span>
                        <div class="product-img">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ $productImage }}" alt="{{ $product->name }}">
                            </a>
                            <a href="{{ route('product.details', $product->id) }}" class="cart-btn text-center">VIEW PRODUCT</a>
                        </div>
                        <div class="product-info">
                            <h4>{{ strtoupper($product->name) }}</h4>
                            <div class="price">
                                <span class="new">Rs.{{ number_format((float) $product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No products available right now.</p>
                @endforelse
            </div>
        </div>
    </section>
    <!-- product area end  -->

    <section class="brand-story-section">
        <div class="brand-story-wrapper">
            <div class="brand-story-image">
                <img src="{{ $storyImageUrl }}" alt="Our Story">
            </div>
            <div class="brand-story-content">
                <h2 class="story-title" style="color: white">{{ $brandStory['title'] ?? 'TINNITY STORY' }}</h2>
                <h4 class="story-subtitle" style="color: white">{{ $brandStory['subtitle'] ?? 'OUR STORY' }}</h4>
                <p class="story-text" style="color: white">{{ $brandStory['description'] ?? '' }}</p>
                <div class="story-features">
                    @foreach ($brandStory['features'] ?? [] as $feature)
                        <div class="story-feature">
                            <i class="{{ $feature['icon'] ?? 'fas fa-star' }}"></i>
                            <span>{{ $feature['text'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="limited-edition">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>{{ $limitedEditionConfig['title'] ?? 'Limited Edition' }}</h2>
                    <p>{{ $limitedEditionConfig['subtitle'] ?? '' }}</p>
                </div>
                <a href="{{ $resolveLink($limitedEditionConfig['view_all_link'] ?? '/limited-edition', route('limited-edition')) }}" class="shop-link">{{ $limitedEditionConfig['view_all_text'] ?? 'View All' }}</a>
            </div>

            <div class="product-grid">
                @forelse ($limitedEditionProducts as $product)
                    @php
                        $limitedImagePath = optional($product->images->first())->image_path;
                        $limitedImage = $limitedImagePath
                            ? Storage::url($limitedImagePath)
                            : 'https://via.placeholder.com/600x800?text=Limited+Edition';
                    @endphp
                    <div class="product-card">
                        <span class="badge">{{ $limitedEditionConfig['badge_text'] ?? 'LIMITED' }}</span>
                        <span class="wishlist">♡</span>
                        <div class="product-img">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ $limitedImage }}" alt="{{ $product->name }}">
                            </a>
                            <a href="{{ route('product.details', $product->id) }}" class="cart-btn text-center">VIEW PRODUCT</a>
                        </div>
                        <div class="product-info">
                            <h4>{{ strtoupper($product->name) }}</h4>
                            <div class="price">
                                <span class="new">Rs.{{ number_format((float) $product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No limited edition products available right now.</p>
                @endforelse
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <section class="collection-reels">
        <h2 class="reel-title">{{ $collectionReels['title'] ?? 'Explore Our Collection' }}</h2>
        <div class="reel-slider">
            @foreach ($collectionReels['cards'] ?? [] as $card)
                <a href="{{ $resolveLink($card['link'] ?? '/shop', route('shop')) }}" class="reel-card">
                    <img src="{{ $card['image_url'] ?? '' }}" alt="Collection">
                    <div class="reel-overlay">{{ $card['text'] ?? '' }}</div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="custom-design-section">
        <div class="custom-left">
            <div class="content">
                <h2 style="color: white">{{ $customDesign['left_title'] ?? 'DESIGN' }}</h2>
                <p>{{ $customDesign['left_description'] ?? '' }}</p>
                <a href="{{ $resolveLink($customDesign['left_button_link'] ?? '/custom-design', route('custom-design')) }}" class="design-btn">{{ $customDesign['left_button_text'] ?? 'Design Your Own' }}</a>
            </div>
        </div>

        <div class="custom-right">
            <div class="content">
                <h2>{{ $customDesign['right_title'] ?? 'SHOP' }}</h2>
                <p>{{ $customDesign['right_description'] ?? '' }}</p>
                <a href="{{ $resolveLink($customDesign['right_button_link'] ?? '/shop', route('shop')) }}" class="shop-btn">{{ $customDesign['right_button_text'] ?? 'Shop Collection' }}</a>
            </div>
        </div>
    </section>

    {{-- <section class="design-steps">

        <div class="step step-dark">
            <div class="step-content">
                <h3>01</h3>
                <h4>Choose T-Shirt</h4>
                <p>Select the base T-shirt style, size and color.</p>
            </div>
        </div>

        <div class="step step-light">
            <div class="step-content">
                <h3>02</h3>
                <h4>Upload Design</h4>
                <p>Add your logo, artwork or custom text.</p>
            </div>
        </div>

        <div class="step step-dark">
            <div class="step-content">
                <h3>03</h3>
                <h4>Customize</h4>
                <p>Adjust placement, colors and preview design.</p>
            </div>
        </div>

        <div class="step step-light">
            <div class="step-content">
                <h3>04</h3>
                <h4>Order</h4>
                <p>Place your order and receive your custom T-shirt.</p>
            </div>
        </div>

    </section> --}}

    <!-- why choose us section start -->


    <section class="why-choose-section">
        <div class="container">
            <div class="why-header">
                <h2>{{ $whyChoose['title'] ?? 'Why Choose Tinnity' }}</h2>
                <p>{{ $whyChoose['subtitle'] ?? '' }}</p>
            </div>

            <div class="why-grid">
                @foreach ($whyChoose['cards'] ?? [] as $card)
                    <div class="why-card">
                        <div class="why-icon">
                            <i class="{{ $card['icon'] ?? 'fas fa-star' }}"></i>
                        </div>
                        <h4>{{ $card['title'] ?? '' }}</h4>
                        <p>{{ $card['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- testimonials area start -->
    @if (isset($testimonials) && $testimonials->count())
        <section class="testimonials-area pt-60 pb-60">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title text-center">
                            <h2 class="section-main-title mb-50">What Our Customers Say</h2>
                            <p>Real stories from real customers who love their Tinnity T-shirts</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-wrapper">
                    <div class="swiper-container testimonial-slider">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="testimonial-item text-center">
                                        @if ($testimonial->image_path)
                                            <div class="author-thumb mb-30">
                                                <img src="{{ Storage::url($testimonial->image_path) }}" alt="Customer">
                                            </div>
                                        @endif
                                        <div class="author-text">
                                            <p>"{{ $testimonial->content }}"</p>
                                        </div>
                                        <div class="testimonial-author">
                                            <div class="author-name">{{ $testimonial->author_name }}</div>
                                            @if ($testimonial->author_desc)
                                                <div class="author-desc">{{ $testimonial->author_desc }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Navigation -->
                        <div class="testimonial-pagination"></div>
                        <div class="testimonial-button-prev"><i class="fas fa-arrow-left"></i></div>
                        <div class="testimonial-button-next"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonials area end -->
    @endif

    <section class="blog-section">

        @php
            $homepageBlogPosts = collect($homeBlogPosts ?? []);
            $homepageConfigPosts = collect($blogConfig['posts'] ?? []);
            $blogCards = $homepageBlogPosts->isNotEmpty()
                ? $homepageBlogPosts->map(function ($post) {
                    $imagePath = $post->featured_image;
                    $imageUrl = $imagePath
                        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : Storage::url($imagePath))
                        : asset('frontend/assets/img/blog/b-1.jpg');

                    return [
                        'tag' => 'Blog',
                        'date' => optional($post->published_at ?? $post->created_at)->format('F d Y'),
                        'title' => $post->title,
                        'description' => $post->excerpt ?: Str::limit(strip_tags($post->content), 160),
                        'image_url' => $imageUrl,
                        'link_text' => 'Read more',
                        'link' => route('blog.show', $post->slug),
                    ];
                })
                : $homepageConfigPosts;
        @endphp

        <div class="blog-header">
            <div>
                <h2>{{ $blogConfig['title'] ?? 'Latest Newssss' }}</h2>
                <p>{{ $blogConfig['subtitle'] ?? 'Hot off the press: All the latest news in fashion' }}</p>
            </div>

            <a href="{{ $resolveLink($blogConfig['view_all_link'] ?? '/blog', route('blog.index')) }}" class="view-all">{{ $blogConfig['view_all_text'] ?? 'View all posts' }}</a>
        </div>


        <div class="blog-grid">
            @foreach ($blogCards as $post)
                <div class="blog-card">
                    <img src="{{ $post['image_url'] ?? '' }}" alt="Blog">
                    <div class="blog-content">
                        <span class="blog-tag">{{ $post['tag'] ?? 'Blog' }}</span>
                        <span class="blog-date">{{ $post['date'] ?? '' }}</span>
                        <h3>{{ $post['title'] ?? '' }}</h3>
                        <p>{{ $post['description'] ?? '' }}</p>
                        <a href="{{ $resolveLink($post['link'] ?? '#', '#') }}" class="read-more">{{ $post['link_text'] ?? 'Read more' }}</a>
                    </div>
                </div>
            @endforeach

        </div>

    </section>
    <!-- instagram gallery section start -->
    <section class="instagram-gallery-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center mb-60">
                <div class="col-xl-8">
                    <div class="section-title text-center">
                        <h2 class="section-main-title mb-35">
                            <i class="fab fa-instagram"></i> {{ $instagramConfig['title'] ?? '#TinnityStyle' }}
                        </h2>
                        <p>{{ $instagramConfig['subtitle'] ?? '' }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($instagramConfig['items'] ?? [] as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                        <div class="instagram-item">
                            <img src="{{ $item['image_url'] ?? '' }}" class="instagram-img">
                            <div class="instagram-overlay">
                                <i class="fab fa-instagram"></i>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row">
                <div class="col-lg-12 text-center mt-30">
                    <a href="{{ $resolveLink($instagramConfig['follow_link'] ?? '#', '#') }}" class="border-btn">{{ $instagramConfig['follow_text'] ?? 'Follow @tinnity_official' }}</a>
                </div>
            </div>
        </div>
    </section>
    <!-- instagram gallery section end -->

    <!-- newsletter section start -->
    {{-- <section class="newsletter-area pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="newsletter-content text-center">
                        <div class="newsletter-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h2 class="section-main-title newsletter-title mb-35">Get Notified for Limited Drops</h2>
                        <p class="newsletter-desc mb-40">Subscribe to our newsletter and never miss exclusive limited
                            edition collections</p>

                        <form action="#" class="newsletter-form-custom">
                            <div class="newsletter-input-wrapper">
                                <input type="email" placeholder="Enter your email address"
                                    class="newsletter-email-input" required>
                                <button type="submit" class="border-btn newsletter-submit-btn">Subscribe Now</button>
                            </div>
                        </form>

                        <div class="newsletter-note">
                            <i class="fas fa-check-circle"></i> Join 10,000+ subscribers • No spam • Unsubscribe anytime
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- newsletter section end -->

    <!-- contact cta banner start -->
    <section class="contact-cta-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-cta-banner">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="contact-cta-content">
                                    <h2 class="cta-title">
                                        <i class="fas fa-headset"></i> {{ $contactCta['title'] ?? "Need Help? We're Here!" }}
                                    </h2>
                                    <p class="cta-desc">{{ $contactCta['description'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-right text-center mt-lg-0 mt-4">
                                <a href="{{ $resolveLink($contactCta['whatsapp_link'] ?? 'https://wa.me/1234567890', '#') }}" class="border-btn whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                    {{ $contactCta['whatsapp_text'] ?? 'WhatsApp Support' }}
                                </a>
                                <a href="{{ $resolveLink($contactCta['email_link'] ?? 'mailto:support@tinnity.com', '#') }}" class="border-btn email-btn ml-3"
                                    style="margin-top: 10px;">
                                    {{ $contactCta['email_text'] ?? 'Email Us' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact cta banner end -->

    <!-- features area start  -->
    <div class="features-area features-area2">
        <div class="container">
            <div class="hr1"></div>
            <div class="features-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="features-single">
                            <div class="irc-item">
                                <div class="irc-item-icon">
                                    <svg id="_003-scooter" data-name="003-scooter" xmlns="http://www.w3.org/2000/svg"
                                        width="46.699" height="40.604" viewBox="0 0 46.699 40.604">
                                        <path id="Path_3267" data-name="Path 3267"
                                            d="M50.456,29.234h11.6a3.356,3.356,0,0,0,3.352-3.352V14.731a3.427,3.427,0,0,0-3.423-3.424H50.456a3.427,3.427,0,0,0-3.423,3.424V25.81a3.427,3.427,0,0,0,3.423,3.424ZM61.983,12.722a2.011,2.011,0,0,1,2.008,2.009V25.882a1.939,1.939,0,0,1-1.937,1.937h-11.6a2.011,2.011,0,0,1-2.008-2.009V14.731a2.01,2.01,0,0,1,2.008-2.009Z"
                                            transform="translate(-47.033 -11.307)" fill="#171717" />
                                        <path id="Path_3268" data-name="Path 3268"
                                            d="M46.526,41.883H59.247a.708.708,0,0,0,.708-.708V37.97a3.33,3.33,0,0,0-3.326-3.325h-10.1A3.33,3.33,0,0,0,43.2,37.97v.587a3.33,3.33,0,0,0,3.326,3.326ZM58.54,40.468H46.526a1.91,1.91,0,0,1-1.91-1.91v-.587a1.91,1.91,0,0,1,1.91-1.91h10.1a1.91,1.91,0,0,1,1.91,1.91Z"
                                            transform="translate(-38.869 -18.132)" fill="#171717" />
                                        <path id="Path_3269" data-name="Path 3269"
                                            d="M26.589,55.345H57.783a.708.708,0,1,0,0-1.415H26.589A1.79,1.79,0,0,1,24.8,52.193c1.031-6.683,6.17-7.871,6.389-7.918A.708.708,0,1,0,30.9,42.89c-.064.013-6.344,1.415-7.5,9.149a.747.747,0,0,0-.008.105A3.207,3.207,0,0,0,26.589,55.345Z"
                                            transform="translate(-23.386 -20.539)" fill="#171717" />
                                        <path id="Path_3270" data-name="Path 3270"
                                            d="M46.021,55.345a.708.708,0,0,0,.551-1.15,7.567,7.567,0,0,1-.035-10.131A.708.708,0,1,0,45.5,43.1a9.113,9.113,0,0,0-.034,11.983A.708.708,0,0,0,46.021,55.345Z"
                                            transform="translate(-25.643 -20.538)" fill="#171717" />
                                        <path id="Path_3271" data-name="Path 3271"
                                            d="M53.272,65.441A6.246,6.246,0,0,0,59.511,59.2a.708.708,0,0,0-1.415,0,4.824,4.824,0,1,1-9.648,0,.708.708,0,0,0-1.415,0A6.246,6.246,0,0,0,53.272,65.441Z"
                                            transform="translate(-41.138 -25.107)" fill="#171717" />
                                        <path id="Path_3272" data-name="Path 3272"
                                            d="M55.106,52.1h3.267a.708.708,0,1,0,0-1.415H55.108a.708.708,0,1,0,0,1.415Z"
                                            transform="translate(-45.92 -22.824)" fill="#171717" />
                                        <path id="Path_3273" data-name="Path 3273"
                                            d="M13.5,63.317A6.5,6.5,0,1,0,7,56.808,6.5,6.5,0,0,0,13.5,63.317Zm0-11.59a5.088,5.088,0,1,1-5.082,5.082A5.088,5.088,0,0,1,13.5,51.727Z"
                                            transform="translate(26.691 -22.714)" fill="#171717" />
                                        <path id="Path_3274" data-name="Path 3274"
                                            d="M8.107,55.337a.708.708,0,0,0,.675-.92,7.783,7.783,0,1,1,15.2-2.36,5.785,5.785,0,0,1-.114,1.216.676.676,0,0,0-.016.146.708.708,0,0,0,1.411.1,7.358,7.358,0,0,0,.134-1.459A9.2,9.2,0,1,0,7.432,54.846.708.708,0,0,0,8.107,55.337Z"
                                            transform="translate(21.302 -20.535)" fill="#171717" />
                                        <path id="Path_3275" data-name="Path 3275"
                                            d="M19.709,48.117a.708.708,0,0,0,.708-.708V34.222a5.8,5.8,0,0,1,4.528-5.757l.047-.008,2.519,10.637a.707.707,0,1,0,1.377-.325L26.225,27.511a.7.7,0,0,0-.747-.541,7.877,7.877,0,0,0-.786.1A7.14,7.14,0,0,0,19,34.222V47.409A.708.708,0,0,0,19.709,48.117Z"
                                            transform="translate(9.301 -15.887)" fill="#171717" />
                                        <path id="Path_3276" data-name="Path 3276"
                                            d="M19.708,25.984H31.1a.708.708,0,0,0,.708-.708v-5.8a.708.708,0,0,0-.708-.708H28.722A4.029,4.029,0,0,0,24.7,22.792v1.775h-4.99a.708.708,0,1,0,0,1.415ZM30.4,24.569H26.113V22.794a2.612,2.612,0,0,1,2.609-2.609H30.4Z"
                                            transform="translate(6.396 -13.489)" fill="#171717" />
                                        <path id="Path_3277" data-name="Path 3277"
                                            d="M47.741,20.915H64.7a.708.708,0,1,0,0-1.415H47.741a.708.708,0,1,0,0,1.415Z"
                                            transform="translate(-47.033 -13.703)" fill="#171717" />
                                        <path id="Path_3278" data-name="Path 3278"
                                            d="M14.831,61.427a3.284,3.284,0,1,0-3.284-3.284,3.285,3.285,0,0,0,3.284,3.284Zm0-5.153a1.869,1.869,0,1,1-1.869,1.869A1.869,1.869,0,0,1,14.831,56.274Z"
                                            transform="translate(25.366 -24.044)" fill="#171717" />
                                    </svg>
                                </div>
                                <div class="irc-item-content">
                                    <div class="irc-item-heading">{{ $featureBoxes[0]['title'] ?? 'Free Shipping' }}</div>
                                    <p>{{ $featureBoxes[0]['description'] ?? 'On All Order Over $599' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="features-single">
                            <div class="irc-item">
                                <div class="irc-item-icon">
                                    <svg id="_004-return" data-name="004-return" xmlns="http://www.w3.org/2000/svg"
                                        width="41.583" height="40.603" viewBox="0 0 41.583 40.603">
                                        <path id="Path_3279" data-name="Path 3279"
                                            d="M263.129,392.394a.609.609,0,0,0,.609-.609v-1.07a.609.609,0,1,0-1.219,0v1.07A.609.609,0,0,0,263.129,392.394Zm0,0"
                                            transform="translate(-241.198 -358.423)" fill="#171717" />
                                        <path id="Path_3280" data-name="Path 3280"
                                            d="M408.754,392.394a.609.609,0,0,0,.609-.609v-1.07a.609.609,0,1,0-1.219,0v1.07A.609.609,0,0,0,408.754,392.394Zm0,0"
                                            transform="translate(-374.997 -358.423)" fill="#171717" />
                                        <path id="Path_3281" data-name="Path 3281"
                                            d="M319.429,404.232a2.54,2.54,0,0,0,1.918-.854.609.609,0,1,0-.917-.8,1.364,1.364,0,0,1-2,0,.609.609,0,0,0-.918.8,2.539,2.539,0,0,0,1.918.854Zm0,0"
                                            transform="translate(-291.586 -369.69)" fill="#171717" />
                                        <path id="Path_3282" data-name="Path 3282"
                                            d="M101.007,7.387l5.508,4.8a1.492,1.492,0,0,0,2.453-1.116v-.948a10.7,10.7,0,0,1,4.372,1.2,7.814,7.814,0,0,1,3.65,4.446,1.492,1.492,0,0,0,1.427,1.031c.156,0,.312-.013.467-.02a1.508,1.508,0,0,0,1.425-1.569V15.2a11.929,11.929,0,0,0-1.032-4.222,13.808,13.808,0,0,0-5.852-6.143,20.344,20.344,0,0,0-4.458-1.784V1.47A1.5,1.5,0,0,0,106.515.354l-5.508,4.8a1.5,1.5,0,0,0,0,2.232Zm.8-1.313,5.508-4.8a.263.263,0,0,1,.434.2V3.519a.609.609,0,0,0,.471.593c.117.027.248.063.368.1A19.209,19.209,0,0,1,112.8,5.886a12.639,12.639,0,0,1,5.364,5.6,10.7,10.7,0,0,1,.924,3.785v.009a.277.277,0,0,1-.264.287l-.4.018h-.014a.281.281,0,0,1-.268-.187,9.043,9.043,0,0,0-4.229-5.142,12.136,12.136,0,0,0-5.5-1.375.625.625,0,0,0-.673.608v1.584a.264.264,0,0,1-.434.2l-5.508-4.8a.265.265,0,0,1,0-.395Zm0,0"
                                            transform="translate(-92.345 -0.001)" fill="#171717" />
                                        <path id="Path_3283" data-name="Path 3283"
                                            d="M1.81,228.131H3.284v9.584A2.485,2.485,0,0,0,5.766,240.2H35.817a2.485,2.485,0,0,0,2.482-2.482v-9.584h1.473a1.831,1.831,0,0,0,1.684-2.485l-3.2-8.025a.609.609,0,0,0-.566-.384H34.472a.609.609,0,0,0,0,1.219h2.805l3.048,7.641a.6.6,0,0,1-.552.815H20.689a.6.6,0,0,1-.552-.374l-3.224-8.082H32.035a.609.609,0,1,0,0-1.218H3.893a.609.609,0,0,0-.566.383l-3.2,8.025a1.83,1.83,0,0,0,1.684,2.485Zm14.2,6.444a.609.609,0,0,0,.609-.609V221.019L19,226.99a1.8,1.8,0,0,0,1.684,1.141H37.081v9.584a1.265,1.265,0,0,1-1.264,1.264H16.623V236.4a.609.609,0,1,0-1.219,0v2.576H5.766A1.265,1.265,0,0,1,4.5,237.716v-9.584h6.837a1.824,1.824,0,0,0,1.684-1.141l2.382-5.971v12.948a.609.609,0,0,0,.609.609ZM1.258,226.1l3.048-7.641H15.115l-3.224,8.082a.6.6,0,0,1-.552.374H1.81a.6.6,0,0,1-.552-.815Zm0,0"
                                            transform="translate(0 -199.595)" fill="#171717" />
                                    </svg>

                                </div>
                                <div class="irc-item-content">
                                    <div class="irc-item-heading">{{ $featureBoxes[1]['title'] ?? 'Easy Returns' }}</div>
                                    <p>{{ $featureBoxes[1]['description'] ?? '30 Day Returns Policy' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="features-single">
                            <div class="irc-item">
                                <div class="irc-item-icon">
                                    <svg id="_001-payment-security" data-name="001-payment-security"
                                        xmlns="http://www.w3.org/2000/svg" width="40.603" height="40.604"
                                        viewBox="0 0 40.603 40.604">
                                        <g id="Group_2181" data-name="Group 2181" transform="translate(0 0)">
                                            <path id="Path_3246" data-name="Path 3246"
                                                d="M33.47,353.747a.6.6,0,0,0-.595.595v9.775a.992.992,0,0,1-.991.991H2.184a.992.992,0,0,1-.991-.991v-7.935a.595.595,0,1,0-1.19,0v7.935A2.183,2.183,0,0,0,2.184,366.3h29.7a2.183,2.183,0,0,0,2.181-2.181v-9.775A.6.6,0,0,0,33.47,353.747Z"
                                                transform="translate(-0.003 -325.694)" fill="#171717" />
                                            <path id="Path_3247" data-name="Path 3247"
                                                d="M66.156,433.576a.595.595,0,1,0,0-1.19H54.816a.595.595,0,1,0,0,1.19Z"
                                                transform="translate(-49.921 -398.097)" fill="#171717" />
                                            <path id="Path_3248" data-name="Path 3248"
                                                d="M236.331,433.576a.595.595,0,1,0,0-1.19h-1.8a.595.595,0,1,0,0,1.19Z"
                                                transform="translate(-215.386 -398.097)" fill="#171717" />
                                            <path id="Path_3249" data-name="Path 3249"
                                                d="M288.17,433.576a.595.595,0,1,0,0-1.19h-1.8a.595.595,0,1,0,0,1.19Z"
                                                transform="translate(-263.114 -398.097)" fill="#171717" />
                                            <path id="Path_3250" data-name="Path 3250"
                                                d="M340.011,433.576a.595.595,0,1,0,0-1.19h-1.8a.595.595,0,0,0,0,1.19Z"
                                                transform="translate(-310.844 -398.097)" fill="#171717" />
                                            <path id="Path_3251" data-name="Path 3251"
                                                d="M290.864,196.963a.6.6,0,0,0-.812-.218l-.492.284v-.568a.595.595,0,0,0-1.19,0v.568l-.492-.284a.595.595,0,0,0-.595,1.03l.492.284-.492.284a.595.595,0,1,0,.595,1.03l.492-.284v.568a.595.595,0,0,0,1.19,0v-.568l.492.284a.595.595,0,1,0,.595-1.03l-.492-.284.492-.284A.6.6,0,0,0,290.864,196.963Z"
                                                transform="translate(-264.227 -180.334)" fill="#171717" />
                                            <path id="Path_3252" data-name="Path 3252"
                                                d="M351.244,196.963a.6.6,0,0,0-.812-.218l-.492.284v-.568a.595.595,0,0,0-1.19,0v.568l-.492-.284a.595.595,0,1,0-.595,1.03l.492.284-.492.284a.595.595,0,1,0,.595,1.03l.492-.284v.568a.595.595,0,0,0,1.19,0v-.568l.492.284a.595.595,0,0,0,.595-1.03l-.492-.284.492-.284A.6.6,0,0,0,351.244,196.963Z"
                                                transform="translate(-319.819 -180.334)" fill="#171717" />
                                            <path id="Path_3253" data-name="Path 3253"
                                                d="M410.32,196.462a.595.595,0,0,0-1.19,0v.568l-.492-.284a.595.595,0,0,0-.595,1.03l.492.284-.492.284a.595.595,0,1,0,.595,1.03l.492-.284v.568a.595.595,0,1,0,1.19,0v-.568l.492.284a.595.595,0,1,0,.595-1.03l-.492-.284.492-.284a.595.595,0,1,0-.595-1.03l-.492.284Z"
                                                transform="translate(-375.411 -180.334)" fill="#171717" />
                                            <path id="Path_3254" data-name="Path 3254"
                                                d="M40.011,3.005H35.4a5.768,5.768,0,0,1-4-1.6h0L30.213.275a.99.99,0,0,0-1.369,0L27.67,1.4a5.767,5.767,0,0,1-4,1.607H19.057a.6.6,0,0,0-.595.595V15.592a10.728,10.728,0,0,0,1.165,4.855H1.193V18.874a.992.992,0,0,1,.991-.991H16.527a.595.595,0,0,0,0-1.19H2.184A2.183,2.183,0,0,0,0,18.874v8.646a.595.595,0,0,0,1.19,0V25.39H24.644l4.368,2.746a1,1,0,0,0,1.056,0l5.538-3.485a10.7,10.7,0,0,0,5-9.055V3.6a.6.6,0,0,0-.595-.595ZM1.193,21.636H20.334A10.742,10.742,0,0,0,22.811,24.2H1.193V21.636ZM39.417,15.6a9.459,9.459,0,0,1-4.445,8.049L29.54,27.063,24.1,23.643a9.459,9.459,0,0,1-4.448-8.051V4.2h4.014a6.951,6.951,0,0,0,4.826-1.937l1.037-.992,1.049,1h0A6.952,6.952,0,0,0,35.4,4.195h4.021V15.6Z"
                                                transform="translate(-0.003 0)" fill="#171717" />
                                            <path id="Path_3255" data-name="Path 3255"
                                                d="M349.634,64.249a.771.771,0,0,1-.77-.77.595.595,0,1,0-1.19,0,1.963,1.963,0,0,0,1.365,1.867v.722a.595.595,0,1,0,1.19,0v-.722a1.96,1.96,0,0,0-.595-3.827l-.043,0a.77.77,0,1,1,.814-.769.595.595,0,0,0,1.19,0,1.963,1.963,0,0,0-1.365-1.867v-.722a.595.595,0,0,0-1.19,0v.722a1.96,1.96,0,0,0,.595,3.827l.043,0a.77.77,0,0,1-.043,1.54Z"
                                                transform="translate(-320.103 -53.002)" fill="#171717" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="irc-item-content">
                                    <div class="irc-item-heading">{{ $featureBoxes[2]['title'] ?? 'Secure Payment' }}</div>
                                    <p>{{ $featureBoxes[2]['description'] ?? '100% Secure Guarantee' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="features-single">
                            <div class="irc-item">
                                <div class="irc-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="33.672" height="40.472"
                                        viewBox="0 0 33.672 40.472">
                                        <g id="headphones" transform="translate(-43.008)">
                                            <g id="Group_2248" data-name="Group 2248"
                                                transform="translate(57.528 6.231)">
                                                <g id="Group_2247" data-name="Group 2247">
                                                    <path id="Path_3446" data-name="Path 3446"
                                                        d="M242.332,79.14a.794.794,0,0,0-1.255.971,15.1,15.1,0,0,1,3.183,9.326v2.327a2.338,2.338,0,0,0-.761-.127h-2.189a1.943,1.943,0,0,0-1.871-1.426h-2.175a1.942,1.942,0,0,0-1.939,1.939v10.408a1.942,1.942,0,0,0,1.939,1.94h2.175a1.947,1.947,0,0,0,.3-.024,6.063,6.063,0,0,1-6.005,5.285h-.419a2.146,2.146,0,0,0-2.1-1.726h-2.378a2.145,2.145,0,0,0-2.143,2.143v.754a2.145,2.145,0,0,0,2.143,2.143h2.378a2.146,2.146,0,0,0,2.1-1.726h.419a7.651,7.651,0,0,0,7.643-7.642.789.789,0,0,0-.134-.441,1.925,1.925,0,0,0,.064-.193H243.5a2.35,2.35,0,0,0,2.348-2.347V89.437A16.675,16.675,0,0,0,242.332,79.14Zm-10.561,31.79h0a.556.556,0,0,1-.555.555h-2.378a.556.556,0,0,1-.555-.555v-.754a.556.556,0,0,1,.555-.555h2.378a.556.556,0,0,1,.555.555Zm8.021-18.5v10.127a.353.353,0,0,1-.353.353h-2.175a.353.353,0,0,1-.352-.353V92.15a.353.353,0,0,1,.352-.352h2.175a.353.353,0,0,1,.353.352Zm4.468,1.989v6.3a.762.762,0,0,1-.761.76h-2.12v-8.26h2.12a.762.762,0,0,1,.761.761Z"
                                                        transform="translate(-226.694 -78.832)" fill="#171717" />
                                                </g>
                                            </g>
                                            <g id="Group_2250" data-name="Group 2250" transform="translate(43.008)">
                                                <g id="Group_2249" data-name="Group 2249" transform="translate(0)">
                                                    <path id="Path_3447" data-name="Path 3447"
                                                        d="M69.648,3.148a16.837,16.837,0,0,0-26.64,13.689V28.123a2.35,2.35,0,0,0,2.348,2.347h2.189A1.943,1.943,0,0,0,49.416,31.9h2.175a1.942,1.942,0,0,0,1.939-1.94V19.549a1.942,1.942,0,0,0-1.939-1.939H49.416a1.943,1.943,0,0,0-1.871,1.426H45.356a2.338,2.338,0,0,0-.761.127V16.836a15.251,15.251,0,0,1,24.128-12.4.794.794,0,1,0,.925-1.289ZM49.063,29.677V19.549a.353.353,0,0,1,.353-.352h2.175a.353.353,0,0,1,.352.352V29.957a.353.353,0,0,1-.352.353H49.416a.353.353,0,0,1-.353-.353Zm-3.707-9.054h2.12v8.26h-2.12a.762.762,0,0,1-.761-.76V21.384A.762.762,0,0,1,45.356,20.623Z"
                                                        transform="translate(-43.008 0)" fill="#171717" />
                                                </g>
                                            </g>
                                            <g id="Group_2252" data-name="Group 2252"
                                                transform="translate(70.161 4.444)">
                                                <g id="Group_2251" data-name="Group 2251" transform="translate(0)">
                                                    <path id="Path_3448" data-name="Path 3448"
                                                        d="M387.284,56.22a.794.794,0,0,0,0,1.587A.794.794,0,0,0,387.284,56.22Z"
                                                        transform="translate(-386.517 -56.22)" fill="#171717" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="irc-item-content">
                                    <div class="irc-item-heading">{{ $featureBoxes[3]['title'] ?? 'Special Support' }}</div>
                                    <p>{{ $featureBoxes[3]['description'] ?? '24/7 Dedicated Support' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Initialize Product Carousel logging
        window.addEventListener('DOMContentLoaded', function() {
            const productGrid = document.querySelector('.product-grid');
            const productCards = document.querySelectorAll('.product-card');

            if (productGrid && productCards.length > 0) {
                console.log('Product Carousel loaded with', productCards.length, 'products');
                console.log('Carousel animation is running');
            }
        });

        // Wait for Swiper to be loaded and DOM to be ready
        function initHeroSlider() {
            if (typeof Swiper !== 'undefined') {
                const heroSlider = new Swiper('.hero-slider__active', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: true,
                    speed: 1000,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.hero-pagination',
                        clickable: true,
                        type: 'bullets',
                    },
                    navigation: {
                        nextEl: '.hero-button-next',
                        prevEl: '.hero-button-prev',
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true,
                    },
                });
                console.log('Hero Slider Initialized Successfully');
            } else {
                // Retry if Swiper not loaded yet
                setTimeout(initHeroSlider, 100);
            }
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHeroSlider);
        } else {
            initHeroSlider();
        }
    </script>

    <script>
        const slider = document.querySelector('.reel-slider');

        let scrollAmount = 0;
        let cardWidth = 250;

        setInterval(() => {

            if (scrollAmount >= slider.scrollWidth - slider.clientWidth) {
                scrollAmount = 0;
            } else {
                scrollAmount += cardWidth;
            }

            slider.scrollTo({
                left: scrollAmount,
                behavior: "smooth"
            });

        }, 2500);
    </script>
@endsection
