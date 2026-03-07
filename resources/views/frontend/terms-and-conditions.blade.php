@extends('frontend.layout.app')

@section('title', 'Terms & Conditions')
@section('content')

<!-- page title area start -->

<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Terms & Conditions</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin">
                           <a href="{{ route('home') }}"><span>Home</span></a>
                        </li>
                        <li class="trail-item trail-end">
                           <span>Terms & Conditions</span>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- page title area end -->

<!-- terms content -->

<section class="refund-policy-area pt-120 pb-120">
   <div class="container container-small">
      <div class="row">
         <div class="col-lg-12">

```
        <div class="refund-policy-content">

           <!-- Introduction -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h2 class="section-main-title mb-30">Introduction</h2>
              </div>

              <p class="mb-30">
                 Welcome to Tinnity. By accessing and using our website, you agree to comply with and be bound by the following Terms & Conditions.
              </p>

              <p>
                 These terms apply to all visitors, users, and customers who access or use our services.
              </p>
           </div>



           <!-- Use of Website -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Use of Our Website</h3>
              </div>

              <p>
                 By using our website, you agree to use it only for lawful purposes. You must not misuse the website or engage in any activity that could harm our services or other users.
              </p>
           </div>



           <!-- Product Information -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Product Information</h3>
              </div>

              <p class="mb-20">
                 We strive to ensure that all product descriptions, images, and prices are accurate. However, errors may occur.
              </p>

              <p>
                 Tinnity reserves the right to correct any errors, update information, or cancel orders if information is inaccurate.
              </p>
           </div>



           <!-- Orders & Payments -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Orders & Payments</h3>
              </div>

              <div class="row">

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="why-why-box">
                       <div class="single-why-choose">
                          <div class="why-choose-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                  viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Order Acceptance</h5>
                             <p class="mb-0 text-small">
                                All orders placed on our website are subject to availability and confirmation.
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>



                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="why-why-box">
                       <div class="single-why-choose">
                          <div class="why-choose-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                  viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Secure Payments</h5>
                             <p class="mb-0 text-small">
                                We use secure payment gateways to protect your transactions.
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>

              </div>
           </div>



           <!-- Intellectual Property -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Intellectual Property</h3>
              </div>

              <p>
                 All content on this website including logos, images, text, and design belongs to Tinnity and may not be copied or used without permission.
              </p>
           </div>



           <!-- Limitation of Liability -->
           <div class="policy-section mb-40">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Limitation of Liability</h3>
              </div>

              <p>
                 Tinnity shall not be liable for any direct, indirect, incidental, or consequential damages arising from the use of our website or products.
              </p>
           </div>



           <!-- Changes to Terms -->
           <div class="policy-section">
              <div class="section-title">
                 <h3 class="section-main-title mb-30">Changes to Terms</h3>
              </div>

              <p>
                 We reserve the right to update or modify these Terms & Conditions at any time. Continued use of the website means you accept the updated terms.
              </p>
           </div>



           <!-- Last Updated -->
           <div class="policy-footer mt-60 pt-30 border-top text-center">
              <p class="text-small text-muted">
                 <strong>Last Updated:</strong> February 20, 2026<br>
                 Please review these terms regularly for updates.
              </p>
           </div>

        </div>

     </div>
  </div>
```

   </div>
</section>

@endsection
