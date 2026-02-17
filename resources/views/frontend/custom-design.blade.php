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
      <div class="row align-items-center">
         <div class="col-lg-6 mb-60">
            <div class="custom-design-content">
               <div class="section-title mb-30">
                  <h2 class="section-main-title">Create Your Unique Design</h2>
               </div>
               <p class="mb-30">Bring your imagination to life with our custom design service. Whether you have a specific vision or need creative guidance, our design team is here to help you create something truly unique.</p>
               
               <ul class="custom-process-list">
                  <li class="process-step">
                     <span class="step-number">1</span>
                     <div class="step-content">
                        <strong class="step-title">Professional Design Team</strong>
                        <p class="step-desc">Our experienced designers will work with you to create the perfect design for your needs.</p>
                     </div>
                  </li>
                  <li class="process-step">
                     <span class="step-number">2</span>
                     <div class="step-content">
                        <strong class="step-title">High-Quality Materials</strong>
                        <p class="step-desc">We use only premium fabrics and printing techniques to ensure your design looks amazing and lasts long.</p>
                     </div>
                  </li>
                  <li class="process-step">
                     <span class="step-number">3</span>
                     <div class="step-content">
                        <strong class="step-title">Fast Delivery</strong>
                        <p class="step-desc">Get your custom designs delivered within 7-14 business days anywhere in the country.</p>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         
         <div class="col-lg-6">
            <div class="custom-design-form bg-gray p-40 rounded">
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
                        <select name="product_type" class="form-control no-nice-select" required>
                           <option value="">Select Product Type*</option>
                           @foreach($productTypes as $typeValue => $typeLabel)
                              <option value="{{ $typeValue }}" {{ old('product_type') === $typeValue ? 'selected' : '' }}>
                                 {{ $typeLabel }}
                              </option>
                           @endforeach
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
                        <select name="quantity" class="form-control no-nice-select" required>
                           <option value="">Select Quantity*</option>
                           <option value="1-5" {{ old('quantity') === '1-5' ? 'selected' : '' }}>1-5 pieces</option>
                           <option value="6-10" {{ old('quantity') === '6-10' ? 'selected' : '' }}>6-10 pieces</option>
                           <option value="11-25" {{ old('quantity') === '11-25' ? 'selected' : '' }}>11-25 pieces</option>
                           <option value="26-50" {{ old('quantity') === '26-50' ? 'selected' : '' }}>26-50 pieces</option>
                           <option value="50+" {{ old('quantity') === '50+' ? 'selected' : '' }}>50+ pieces</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-20">
                        <select name="budget" class="form-control no-nice-select">
                           <option value="">Budget Range</option>
                           <option value="under-5000" {{ old('budget') === 'under-5000' ? 'selected' : '' }}>Under INR 5000</option>
                           <option value="5000-10000" {{ old('budget') === '5000-10000' ? 'selected' : '' }}>INR 5000 - 10000</option>
                           <option value="10000-20000" {{ old('budget') === '10000-20000' ? 'selected' : '' }}>INR 10000 - 20000</option>
                           <option value="20000+" {{ old('budget') === '20000+' ? 'selected' : '' }}>INR 20000+</option>
                        </select>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="border-btn">Submit Design Request</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- custom design area end -->

<!-- design preview area start -->
<section class="design-preview-area pt-120 pb-120 bg-gray">
   <div class="container">
      <div class="row justify-content-center mb-60">
         <div class="col-xl-8">
            <div class="section-title text-center">
               <h2 class="section-main-title">Design Preview</h2>
               <p>Latest design request details submitted by customers</p>
            </div>
         </div>
      </div>

      @if($latestDesignRequest)
          @php
            $path = $latestDesignRequest->design_file_path ?? '';
            $hasPath = $path !== '';
            $previewUrl = $hasPath && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/'))
               ? $path
               : ($hasPath ? Storage::url($path) : null);
            $fileExt = $latestDesignRequest->file_format ?: ($hasPath ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : null);
            $isImage = $previewUrl && in_array($fileExt, ['png', 'jpg', 'jpeg', 'webp']);
          @endphp
         <div class="row">
            <div class="col-lg-4 mb-30">
               <div class="bg-white rounded-lg p-20 text-center">
                  @if($isImage)
                     <img src="{{ $previewUrl }}" alt="Design preview" class="img-fluid mb-20">
                  @else
                     <div class="bg-gray p-40 mb-20">{{ strtoupper($fileExt ?: 'FILE') }}</div>
                  @endif
                  <p class="mb-10">Design File Preview</p>
                  @if($previewUrl)
                     <a href="{{ $previewUrl }}" class="border-btn" download>Download print-ready design</a>
                  @endif
               </div>
            </div>
            <div class="col-lg-8">
               <div class="bg-white rounded-lg p-20">
                  <div class="row">
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Customer Name</p>
                        <p class="mb-0">{{ $latestDesignRequest->customer_name }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Phone</p>
                        <p class="mb-0">{{ $latestDesignRequest->phone }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Email</p>
                        <p class="mb-0">{{ $latestDesignRequest->email }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Selected Size</p>
                        <p class="mb-0">{{ strtoupper($latestDesignRequest->selected_size) }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Front Label</p>
                        <p class="mb-0">{{ $latestDesignRequest->front_label ?? '—' }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Back Label</p>
                        <p class="mb-0">{{ $latestDesignRequest->back_label ?? '—' }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Status</p>
                        <p class="mb-0">{{ ucwords(str_replace('_', ' ', $latestDesignRequest->status)) }}</p>
                     </div>
                     <div class="col-md-6 mb-20">
                        <p class="text-muted mb-5">Payment</p>
                        <p class="mb-0">{{ $latestDesignRequest->payment_unlocked ? 'Unlocked' : 'Locked' }}</p>
                     </div>
                  </div>

                  <div class="mt-10">
                     <h4 class="mb-15">Print File Checks</h4>
                     <div class="row">
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">File Unlocked</p>
                           <p class="mb-0">{{ $latestDesignRequest->file_locked ? 'No' : 'Yes' }}</p>
                        </div>
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">Format (PNG / PSD / AI)</p>
                           <p class="mb-0">{{ strtoupper($latestDesignRequest->file_format ?? $fileExt ?? '—') }}</p>
                        </div>
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">DPI</p>
                           <p class="mb-0">{{ $latestDesignRequest->dpi ?? '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">Print Width</p>
                           <p class="mb-0">{{ $latestDesignRequest->print_width ?? '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">Print Height</p>
                           <p class="mb-0">{{ $latestDesignRequest->print_height ?? '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-20">
                           <p class="text-muted mb-5">Unit</p>
                           <p class="mb-0">{{ strtoupper($latestDesignRequest->print_unit ?? '—') }}</p>
                        </div>
                     </div>
                  </div>

                  <div class="mt-10">
                     <h4 class="mb-15">File Management</h4>
                     <p class="mb-0">{{ $latestDesignRequest->remarks ?? 'No remarks yet.' }}</p>
                  </div>
               </div>
            </div>
         </div>
      @else
         <div class="text-center">
            <h3>No Design Requests Yet</h3>
            <p>Please check back after a customer submits a design request.</p>
         </div>
      @endif
   </div>
</section>
<!-- design preview area end -->

<!-- newsletter section start -->
<section class="newsletter-area pt-120 pb-120">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-8">
            <div class="newsletter-content text-center">
               <div class="newsletter-icon">
                  <i class="fas fa-bullhorn"></i>
               </div>
               <h2 class="section-main-title newsletter-title mb-35">Get Notified for Custom Drops</h2>
               <p class="newsletter-desc mb-40">Subscribe to our newsletter and never miss custom design updates</p>
               <form action="#" class="newsletter-form-custom">
                  <div class="newsletter-input-wrapper">
                     <input type="email" placeholder="Enter your email address" class="newsletter-email-input" required>
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
</section>
<!-- newsletter section end -->
@endsection