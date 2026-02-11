@extends('frontend.layout.app')

@section('title', 'Custom Design')
@section('content')
<!-- page title area start  -->
<section class="page-title-area" data-background="assets/img/bg/page-title-bg.html">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Custom Design</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end"><span>Custom Design</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- page title area end  -->

<!-- custom design area start -->
<section class="custom-design-area pt-120 pb-120">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 mb-60">
            <div class="custom-design-content">
               <h2 class="section-title mb-30">Create Your Unique Design</h2>
               <p class="mb-30">Bring your imagination to life with our custom design service. Whether you have a specific vision or need creative guidance, our design team is here to help you create something truly unique.</p>
               
               <div class="feature-list">
                  <div class="feature-item mb-20">
                     <i class="fas fa-palette text-primary mr-3"></i>
                     <div>
                        <h5>Professional Design Team</h5>
                        <p>Our experienced designers will work with you to create the perfect design for your needs.</p>
                     </div>
                  </div>
                  <div class="feature-item mb-20">
                     <i class="fas fa-cogs text-primary mr-3"></i>
                     <div>
                        <h5>High-Quality Materials</h5>
                        <p>We use only premium fabrics and printing techniques to ensure your design looks amazing and lasts long.</p>
                     </div>
                  </div>
                  <div class="feature-item mb-20">
                     <i class="fas fa-shipping-fast text-primary mr-3"></i>
                     <div>
                        <h5>Fast Delivery</h5>
                        <p>Get your custom designs delivered within 7-14 business days anywhere in the country.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         <div class="col-lg-6">
            <div class="custom-design-form bg-light p-40 rounded">
               <h3 class="form-title mb-30">Start Your Custom Design</h3>
               <form action="#" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6 mb-20">
                        <input type="text" name="name" class="form-control" placeholder="Your Name*" required>
                     </div>
                     <div class="col-md-6 mb-20">
                        <input type="email" name="email" class="form-control" placeholder="Your Email*" required>
                     </div>
                     <div class="col-md-6 mb-20">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number*" required>
                     </div>
                     <div class="col-md-6 mb-20">
                        <select name="product_type" class="form-control" required>
                           <option value="">Select Product Type*</option>
                           <option value="t-shirt">T-Shirt</option>
                           <option value="hoodie">Hoodie</option>
                           <option value="bag">Bag</option>
                           <option value="other">Other</option>
                        </select>
                     </div>
                     <div class="col-md-12 mb-20">
                        <textarea name="design_description" class="form-control" rows="4" placeholder="Describe your design idea in detail*" required></textarea>
                     </div>
                     <div class="col-md-12 mb-20">
                        <label class="form-label">Upload Reference Images (Optional)</label>
                        <input type="file" name="reference_images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">You can upload multiple images for reference</small>
                     </div>
                     <div class="col-md-6 mb-20">
                        <select name="quantity" class="form-control" required>
                           <option value="">Select Quantity*</option>
                           <option value="1-5">1-5 pieces</option>
                           <option value="6-10">6-10 pieces</option>
                           <option value="11-25">11-25 pieces</option>
                           <option value="26-50">26-50 pieces</option>
                           <option value="50+">50+ pieces</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-20">
                        <select name="budget" class="form-control">
                           <option value="">Budget Range</option>
                           <option value="under-500">Under $500</option>
                           <option value="500-1000">$500 - $1000</option>
                           <option value="1000-2000">$1000 - $2000</option>
                           <option value="2000+">$2000+</option>
                        </select>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="fill-btn">Submit Design Request</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      
      <!-- Design Process Section -->
      <div class="row mt-80">
         <div class="col-lg-12">
            <div class="section-title text-center mb-60">
               <h2 class="section-main-title">Our Design Process</h2>
               <p>From concept to completion, we make sure your custom design exceeds expectations</p>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-3 col-md-6 mb-40 text-center">
            <div class="process-step">
               <div class="step-number">1</div>
               <h4>Submit Request</h4>
               <p>Fill out our form with your design ideas and requirements</p>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 mb-40 text-center">
            <div class="process-step">
               <div class="step-number">2</div>
               <h4>Design Consultation</h4>
               <p>Our team contacts you to discuss details and provide a quote</p>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 mb-40 text-center">
            <div class="process-step">
               <div class="step-number">3</div>
               <h4>Design & Approval</h4>
               <p>We create your design and send it for your approval</p>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 mb-40 text-center">
            <div class="process-step">
               <div class="step-number">4</div>
               <h4>Production & Delivery</h4>
               <p>Once approved, we produce and ship your custom items</p>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- custom design area end -->

<style>
.feature-item {
   display: flex;
   align-items: flex-start;
}

.feature-item i {
   font-size: 1.5rem;
   margin-top: 5px;
}

.process-step .step-number {
   width: 60px;
   height: 60px;
   background: #007bff;
   color: white;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 1.5rem;
   font-weight: bold;
   margin: 0 auto 20px;
}

.form-control {
   padding: 12px 15px;
   border: 1px solid #ddd;
   border-radius: 5px;
   font-size: 14px;
}

.bg-light {
   background-color: #f8f9fa !important;
}

.p-40 {
   padding: 40px;
}

.text-primary {
   color: #007bff !important;
}

.mr-3 {
   margin-right: 1rem;
}

.mb-20 {
   margin-bottom: 20px;
}

.mb-30 {
   margin-bottom: 30px;
}

.mb-40 {
   margin-bottom: 40px;
}

.mb-60 {
   margin-bottom: 60px;
}

.mt-80 {
   margin-top: 80px;
}
</style>
@endsection