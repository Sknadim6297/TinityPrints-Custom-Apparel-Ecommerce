@extends('frontend.layout.app')

@section('title', 'Return Policy')
@section('content')

<!-- page title area start -->

<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpg') }}">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Return Policy</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin">
                           <a href="{{ route('home') }}"><span>Home</span></a>
                        </li>
                        <li class="trail-item trail-end">
                           <span>Return Policy</span>
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

<!-- return policy content -->

<section class="refund-policy-area pt-120 pb-120">
   <div class="container container-small">
      <div class="row">
         <div class="col-lg-12">
        <div class="refund-policy-content">


           <!-- Policy Overview -->
           <div class="policy-section mb-40">

              <div class="section-title">
                 <h2 class="section-main-title mb-30">Easy Returns for Your Convenience</h2>
              </div>

              <p class="mb-30">
                 At Tinnity, we want you to love every purchase. If something isn’t right, you can return your item easily within 30 days of delivery.
              </p>

              <p>
                 Our goal is to provide a smooth and hassle-free return experience while ensuring the quality and integrity of our products.
              </p>

           </div>



           <!-- 30-Day Return Guarantee -->
           <div class="why-why-box mb-40">
              <div class="row">
                 <div class="col-lg-12">

                    <div class="single-why-choose">

                       <div class="why-choose-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                               viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                             <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                             <polyline points="22 4 12 14.01 9 11.01"></polyline>
                          </svg>
                       </div>

                       <div class="why-choose-text">
                          <h4 class="mb-10">30-Day Return Guarantee</h4>
                          <p class="mb-0">Return items within 30 days if they don't meet your expectations.</p>
                       </div>

                    </div>

                 </div>
              </div>
           </div>



           <!-- Return Eligibility -->
           <div class="policy-section mb-40">

              <div class="section-title">
                 <h3 class="section-main-title mb-30">Return Eligibility</h3>
              </div>

              <div class="row">

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="why-why-box">
                       <div class="single-why-choose">
                          <div class="why-choose-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                  viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Unused Condition</h5>
                             <p class="mb-0 text-small">Items must be unworn, unwashed and unused.</p>
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
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Return Within 30 Days</h5>
                             <p class="mb-0 text-small">Return requests must be initiated within 30 days of delivery.</p>
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
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Original Packaging</h5>
                             <p class="mb-0 text-small">Items should include original tags and packaging.</p>
                          </div>
                       </div>
                    </div>
                 </div>


                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="why-why-box">
                       <div class="single-why-choose">
                          <div class="why-choose-icon" style="color:#dc3545;">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                  viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                             </svg>
                          </div>

                          <div class="why-choose-text">
                             <h5 class="mb-10">Non-Returnable Items</h5>
                             <p class="mb-0 text-small">Final sale or personalized products cannot be returned.</p>
                          </div>
                       </div>
                    </div>
                 </div>


              </div>

           </div>



           <!-- Return Process -->
           <div class="policy-section mb-40">

              <div class="section-title">
                 <h3 class="section-main-title mb-30">How to Return an Item</h3>
              </div>

              <div class="row">

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="process-box">
                       <div class="process-step-number">1</div>
                       <h5 class="mb-15">Contact Support</h5>
                       <p>Email us with your order number and reason for return.</p>
                    </div>
                 </div>

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="process-box">
                       <div class="process-step-number">2</div>
                       <h5 class="mb-15">Receive Return Instructions</h5>
                       <p>Our team will provide return authorization and instructions.</p>
                    </div>
                 </div>

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="process-box">
                       <div class="process-step-number">3</div>
                       <h5 class="mb-15">Ship the Product</h5>
                       <p>Package your item securely and send it to our return address.</p>
                    </div>
                 </div>

                 <div class="col-lg-6 col-md-6 mb-30">
                    <div class="process-box">
                       <div class="process-step-number">4</div>
                       <h5 class="mb-15">Inspection & Refund</h5>
                       <p>After inspection, we will process your refund within 5-7 business days.</p>
                    </div>
                 </div>

              </div>

           </div>



           <!-- Contact -->
           <div class="policy-section">

              <div class="section-title">
                 <h3 class="section-main-title mb-30">Need Help With Returns?</h3>
              </div>

              <p>
                 If you have questions regarding our return policy, please contact our support team and we will gladly assist you.
              </p>

           </div>



           <!-- Last Updated -->
           <div class="policy-footer mt-60 pt-30 border-top text-center">
              <p class="text-small text-muted">
                 <strong>Last Updated:</strong> February 20, 2026<br>
                 Our return policy may change periodically. Please review this page regularly.
              </p>
           </div>


        </div>

     </div>
  </div>
```

   </div>
</section>

@endsection
