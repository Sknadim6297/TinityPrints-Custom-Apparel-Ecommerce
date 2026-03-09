    @extends('frontend.layout.app')

    @section('title', 'Contact Us')

    @section('content')
    <main>


        <!-- side toggle start -->
        <div class="fix">
            <div class="side-info">
                <div class="side-info-content">
                <div class="offset-widget offset-logo mb-40">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <a href="{{ route('home') }}">
                            <img src="{{ asset('frontend/assets/img/logo/logo.png') }}" width="100px" alt="Logo">
                            </a>
                        </div>
                        <div class="col-3 text-end"><button class="side-info-close"><i class="fal fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mobile-menu d-lg-none fix"></div>
                <div class="offset-profile-action d-lg-none">
                    <div class="offset-widget mb-40">
                        @auth
                            <div class="mobile-user-info mb-20 text-center">
                                <div class="user-icon" style="display: inline-block; margin-bottom: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="38"
                                        viewBox="0 0 16.077 19">
                                        <g id="avatar" transform="translate(-39.385)">
                                            <g id="Group_6" data-name="Group 6" transform="translate(39.385)">
                                                <path id="Path_32" data-name="Path 32"
                                                    d="M50.288,8.81a4.872,4.872,0,1,0-5.729,0,8.052,8.052,0,0,0-5.174,7.511A2.683,2.683,0,0,0,42.064,19H52.782a2.683,2.683,0,0,0,2.679-2.679A8.052,8.052,0,0,0,50.288,8.81ZM44.013,4.872a3.41,3.41,0,1,1,3.41,3.41A3.414,3.414,0,0,1,44.013,4.872Zm8.769,12.667H42.064a1.219,1.219,0,0,1-1.218-1.218A6.577,6.577,0,1,1,54,16.32,1.219,1.219,0,0,1,52.782,17.538Z"
                                                    transform="translate(-39.385)" fill="#171717"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="user-name" style="font-weight: 600; font-size: 16px;">{{ Auth::user()->name }}</div>
                            </div>
                        @endauth
                        <div class="action-list action-list-header1 mb-20">
                            @auth
                                <div class="action-item">
                                    <a href="{{ route('orders') }}" class="action-btn-text">My Orders</a>
                                </div>
                                <div class="action-item">
                                    <a href="{{ route('profile.edit') }}" class="action-btn-text">Profile</a>
                                </div>
                                <div class="action-item">
                                    <a href="{{ route('contact') }}" class="action-btn-text">Support</a>
                                </div>
                                <div class="action-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="action-btn-text">Logout</button>
                                    </form>
                                </div>
                            @else
                                <div class="action-item">
                                    <a href="{{ route('login') }}" class="action-btn-text">Sign in</a>
                                </div>
                            @endauth
                        </div>
                        <div class="action-list action-list-header1">
                            <div class="action-item action-item-cart">
                                <a href="{{ route('cart.index') }}">
                                    <i class="fal fa-shopping-bag"></i>
                                    @auth
                                        @php
                                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                        @endphp
                                        <span class="action-item-number cart-count">{{ $cartCount }}</span>
                                    @else
                                        <span class="action-item-number cart-count">0</span>
                                    @endauth
                                </a>
                            </div>
                            <div class="action-item action-item-wishlist">
                                <a href="{{ route('wishlist.index') }}">
                                    <i class="far fa-heart"></i>
                                    @auth
                                        @php
                                            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                        @endphp
                                        <span class="action-item-number wishlist-count">{{ $wishlistCount }}</span>
                                    @else
                                        <span class="action-item-number wishlist-count">0</span>
                                    @endauth
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offset-widget offset_searchbar mb-30">
                    <form action="#" class="filter-search-input">
                        <input type="text" placeholder="Search keyword">
                        <button><i class="fal fa-search"></i></button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-overlay"></div>
        <div class="offcanvas-overlay-white"></div>


        <!-- side toggle end -->

        <!-- page title area start  -->
        <section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
            <div class="container">
                <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">Contact Us</h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                <li class="trail-item trail-end"><span>Contact Us</span></li>
                            </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <!-- page title area end  -->

        <!-- contact main area start  -->
        <section class="contact-main-area pt-120 pb-60">
            <div class="container container-small">
                <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="contact-main-wrapper mb-60">
                        <div class="section-title">
                            <h2 class="section-main-title mb-40">Get in Touch</h2>
                        </div>
                        <div class="contact-main-form">
<form action="{{ route('contact.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="single-form-input">
                <input type="text" name="name" placeholder="Name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-form-input">
                <input type="text" name="phone" placeholder="Phone" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="single-form-input">
                <input type="email" name="email" placeholder="Email" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="single-form-input">
                <textarea name="message" placeholder="Messages" required></textarea>
            </div>
        </div>
    </div>

    <div class="contact-btn">
        <button type="submit" class="fill-btn">Submit Now</button>
    </div>
</form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sidebar-widget-wrapper mb-60">
                        <div class="sidebar-widget">
                            <h4 class="sidebar-widget-title">Support Contact</h4>
                            <div class="sidebar-widget-content">
                            <div class="contact-list">
                                <div class="contact-list-item">
                                    <div class="irc-item">
                                        <div class="irc-item-icon">
                                        <svg id="Layer_3" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg"
                                            width="21.375" height="21.375" viewBox="0 0 21.375 21.375">
                                            <path id="Path_8" data-name="Path 8"
                                                d="M1.688,16.386c.038-.031,4.3-3.085,5.463-2.885.556.1.875.477,1.513,1.238.1.123.35.415.541.624a8.877,8.877,0,0,0,1.176-.479,9.761,9.761,0,0,0,4.5-4.5A8.876,8.876,0,0,0,15.363,9.2c-.209-.192-.5-.439-.628-.544-.756-.634-1.135-.953-1.233-1.51C13.3,6,16.354,1.725,16.386,1.687A1.631,1.631,0,0,1,17.6,1c1.238,0,4.774,4.586,4.774,5.359,0,.045-.065,4.608-5.691,10.331C10.966,22.31,6.4,22.375,6.359,22.375,5.586,22.375,1,18.84,1,17.6A1.629,1.629,0,0,1,1.688,16.386Zm4.75,4.56c.623-.051,4.452-.556,9.239-5.26,4.727-4.813,5.22-8.653,5.269-9.248a19.276,19.276,0,0,0-3.353-3.962c-.028.029-.066.071-.115.127a25.216,25.216,0,0,0-2.546,4.32,8.469,8.469,0,0,0,.724.649,7.149,7.149,0,0,1,1.077,1.013l.173.242-.051.293A8.135,8.135,0,0,1,16.166,11,11.193,11.193,0,0,1,11,16.166a8.115,8.115,0,0,1-1.882.688l-.293.051-.242-.173A7.209,7.209,0,0,1,7.568,15.65c-.223-.266-.522-.622-.634-.722A25.054,25.054,0,0,0,2.6,17.477c-.059.05-.1.088-.128.113a19.259,19.259,0,0,0,3.962,3.354Z"
                                                transform="translate(-1 -1)" fill="#171717" />
                                        </svg>

                                        </div>
                                        <div class="irc-item-content">
                                        <div class="irc-item-heading">Phone</div>
                                        @php
                                            $mobile = $contactSettings->mobile_phone ?? '(+88)872-670-780';
                                            $hotline = $contactSettings->hotline_phone ?? '(+88)422-655-793';
                                        @endphp
                                        <span>Mobile : <a href="tel:{{ preg_replace('/\D+/', '', $mobile) }}"><span>{{ $mobile }}</span></a></span>
                                        <span>Hotline : <a href="tel:{{ preg_replace('/\D+/', '', $hotline) }}"><span>{{ $hotline }}</span></a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-list-item">
                                    <div class="irc-item">
                                        <div class="irc-item-icon">
                                        <svg id="email_3_" data-name="email (3)" xmlns="http://www.w3.org/2000/svg"
                                            width="22.57" height="16.271" viewBox="0 0 22.57 16.271">
                                            <path id="Path_10" data-name="Path 10"
                                                d="M20.933,20.521H4.137A2.9,2.9,0,0,1,1.25,17.634V7.137A2.9,2.9,0,0,1,4.137,4.25h16.8A2.9,2.9,0,0,1,23.82,7.137v10.5A2.9,2.9,0,0,1,20.933,20.521Zm-16.8-14.7A1.312,1.312,0,0,0,2.825,7.137v10.5a1.312,1.312,0,0,0,1.312,1.312h16.8a1.312,1.312,0,0,0,1.312-1.312V7.137a1.312,1.312,0,0,0-1.312-1.312Z"
                                                transform="translate(-1.25 -4.25)" fill="#171717" />
                                            <path id="Path_11" data-name="Path 11"
                                                d="M12.534,13.7a3.412,3.412,0,0,1-1.732-.472L1.638,7.778a.8.8,0,0,1-.283-1.05A.777.777,0,0,1,2.4,6.455l9.175,5.438a1.774,1.774,0,0,0,1.848,0L22.6,6.455a.777.777,0,0,1,1.05.273.8.8,0,0,1-.283,1.05l-9.1,5.448a3.412,3.412,0,0,1-1.732.472Z"
                                                transform="translate(-1.249 -4.145)" fill="#171717" />
                                        </svg>


                                        </div>
                                        <div class="irc-item-content">
                                        <div class="irc-item-heading">Email</div>
                                        @php
                                            $email1 = $contactSettings->email_primary ?? 'info@tinnityecom.com';
                                            $email2 = $contactSettings->email_secondary ?? 'support@tinnityecom.com';
                                        @endphp
                                        <span><a href="mailto:{{ $email1 }}">{{ $email1 }}</a></span>
                                        <span><a href="mailto:{{ $email2 }}">{{ $email2 }}</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-list-item">
                                    <div class="irc-item">
                                        <div class="irc-item-icon">
                                        <svg id="pin" xmlns="http://www.w3.org/2000/svg" width="17.41" height="21.729"
                                            viewBox="0 0 17.41 21.729">
                                            <g id="Group_2184" data-name="Group 2184" transform="translate(4.671 4.671)">
                                                <g id="Group_2183" data-name="Group 2183">
                                                    <path id="Path_3602" data-name="Path 3602"
                                                    d="M164.981,110.062a4.034,4.034,0,1,0,4.034,4.034A4.039,4.039,0,0,0,164.981,110.062Zm0,6.369a2.335,2.335,0,1,1,2.335-2.335A2.338,2.338,0,0,1,164.981,116.431Z"
                                                    transform="translate(-160.947 -110.062)" fill="#171717" />
                                                </g>
                                            </g>
                                            <g id="Group_2186" data-name="Group 2186">
                                                <g id="Group_2185" data-name="Group 2185">
                                                    <path id="Path_3603" data-name="Path 3603"
                                                    d="M59.59,0a8.715,8.715,0,0,0-8.7,8.7v.241c0,2.428,1.392,5.256,4.137,8.408A35.783,35.783,0,0,0,59.056,21.3l.534.431.534-.431a35.775,35.775,0,0,0,4.035-3.944c2.745-3.151,4.137-5.98,4.137-8.408V8.705A8.715,8.715,0,0,0,59.59,0ZM66.6,8.946c0,4.1-5.286,9.068-7.006,10.576-1.721-1.508-7.006-6.474-7.006-10.576V8.705a7.006,7.006,0,0,1,14.013,0Z"
                                                    transform="translate(-50.885)" fill="#171717" />
                                                </g>
                                            </g>
                                        </svg>


                                        </div>
                                        <div class="irc-item-content">
                                        <div class="irc-item-heading">Location</div>
                                        <span>{{ $contactSettings->address ?? 'Abbot Kinney Blvd. New York, USA-5785' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <!-- contact main area end  -->

        <!-- contact map area start  -->
        <div class="contact-map-area mb-120">
            <div class="container container-small">
                <div class="row">
                <div class="col-lg-12">
                    <div class="contact-map-wrapper">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29551.13751693757!2d-74.115804243905!3d40.85532782107006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1649153266682!5m2!1sen!2sbd"></iframe>
                    </div>
                </div>
                </div>
            </div>
        </div>

    @endsection