@extends('frontend.layout.app')

@section('title', 'Custom Design - Tinnity')

@section('content')
@php($frontendAsset = asset('frontend/assets'))
<main>
   <!-- page title area start  -->
   <section class="page-title-area" data-background="{{ $frontendAsset }}/img/bg/page-title-bg.html">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="page-title-wrapper text-center">
                  <h1 class="page-title mb-10">Design Your T-Shirt</h1>
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

   <!-- custom design form area start -->
   <section class="custom-design-form-area pt-120 pb-120">
      <div class="container container-small">
         @auth
            <div class="row">
               <div class="col-lg-8">
                  <div class="custom-design-wrapper mb-60">
                     <div class="section-title mb-40">
                        <h2 class="section-main-title">Upload Your Custom Design</h2>
                     </div>

                     <div class="custom-design-form">
                        <form action="{{ route('custom-design.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf

                           <!-- User Information Section -->
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <input type="text" 
                                           name="customer_name" 
                                           value="{{ old('customer_name', Auth::user()->name) }}"
                                           placeholder="Full Name *"
                                           required>
                                    @error('customer_name')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', Auth::user()->email) }}"
                                           placeholder="Email Address *"
                                           required>
                                    @error('email')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <input type="tel" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           placeholder="Phone Number *"
                                           required>
                                    @error('phone')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <!-- T-Shirt Options Section -->
                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <select name="selected_size" required>
                                       <option value="">Select Size *</option>
                                       <option value="m" {{ old('selected_size') === 'm' ? 'selected' : '' }}>Medium (M)</option>
                                       <option value="l" {{ old('selected_size') === 'l' ? 'selected' : '' }}>Large (L)</option>
                                       <option value="xl" {{ old('selected_size') === 'xl' ? 'selected' : '' }}>Extra Large (XL)</option>
                                    </select>
                                    @error('selected_size')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <select name="sleeve_type" required>
                                       <option value="">Select Sleeve Type *</option>
                                       <option value="full" {{ old('sleeve_type') === 'full' ? 'selected' : '' }}>Full Sleeve</option>
                                       <option value="half" {{ old('sleeve_type') === 'half' ? 'selected' : '' }}>Half Sleeve</option>
                                    </select>
                                    @error('sleeve_type')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <label for="color" class="d-block mb-2">
                                       <strong>T-Shirt Color *</strong>
                                    </label>
                                    <input type="color" 
                                           id="color"
                                           name="color" 
                                           value="{{ old('color', '#FFFFFF') }}"
                                           style="width: 100%; height: 45px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;"
                                           required>
                                    @error('color')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Design Upload Section -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                           <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">
                              <i class="fas fa-image"></i> Design Files
                           </h3>

                           <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                              Supported formats: PNG, JPG, PDF | Max file size: 10MB
                           </p>
                              <!-- Design Upload Section -->
                              <div class="col-md-12">
                                 <div class="section-title mb-30 mt-30">
                                    <h4><i class="fas fa-image"></i> Upload Your Design Files</h4>
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <label><strong>Front Design *</strong></label>
                                    <p class="text-muted mb-2"><small>Supported: PNG, JPG, PDF | Max: 10MB</small></p>
                                    <input type="file" 
                                           name="front_design_file" 
                                           accept=".png,.jpg,.jpeg,.pdf"
                                           required>
                                    @error('front_design_file')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="single-form-input mb-20">
                                    <label><strong>Back Design (Optional)</strong></label>
                                    <p class="text-muted mb-2"><small>Leave empty if only front design</small></p>
                                    <input type="file" 
                                           name="back_design_file" 
                                           accept=".png,.jpg,.jpeg,.pdf">
                                    @error('back_design_file')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <!-- Notes Section -->
                              <div class="col-md-12">
                                 <div class="section-title mb-30 mt-30">
                                    <h4><i class="fas fa-comment"></i> Additional Instructions</h4>
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="single-form-input mb-20">
                                    <label><strong>Notes & Special Requests</strong></label>
                                    <textarea name="notes" 
                                              rows="5"
                                              placeholder="Add any special printing instructions, color preferences, or other details..."></textarea>
                                    @error('notes')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              <!-- Important Information -->
                              <div class="col-md-12 mb-30">
                                 <div class="alert alert-warning alert-custom mb-0">
                                    <h5 class="mb-15"><strong>⚠️ Important Information</strong></h5>
                                    <ul class="list-unstyled">
                                       <li class="mb-8">
                                          <strong>Approval Required:</strong> Your design will be reviewed by our team before you can proceed to payment.
                                       </li>
                                       <li class="mb-8">
                                          <strong>Turnaround Time:</strong> Review and approval typically takes 24-48 hours.
                                       </li>
                                       <li class="mb-8">
                                          <strong>File Security:</strong> Your design files are securely stored and will only be used for your order.
                                       </li>
                                       <li class="mb-8">
                                          <strong>Quality Standards:</strong> We ensure your design meets printing quality standards.
                                       </li>
                                       <li>
                                          <strong>No Refund After Approval:</strong> Once approved and paid, custom designs cannot be refunded unless defective.
                                       </li>
                                    </ul>
                                 </div>
                              </div>

                              <!-- Error Messages -->
                              @if($errors->any())
                                 <div class="col-md-12 mb-30">
                                    <div class="alert alert-danger alert-custom mb-0">
                                       <h5 class="mb-15"><strong>Please fix the following errors:</strong></h5>
                                       <ul class="list-unstyled">
                                          @foreach($errors->all() as $error)
                                             <li><i class="fas fa-times-circle"></i> {{ $error }}</li>
                                          @endforeach
                                       </ul>
                                    </div>
                                 </div>
                              @endif

                              <!-- Form Buttons -->
                              <div class="col-md-12">
                                 <div class="custom-design-buttons" style="display: flex; gap: 15px;">
                                    <button type="submit" class="fill-btn">
                                       <i class="fas fa-cloud-upload-alt"></i> Submit for Review
                                    </button>
                                    <a href="{{ route('home') }}" class="border-btn">
                                       Cancel
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>

               <!-- Sidebar with Guidelines -->
               <div class="col-lg-4">
                  <div class="sidebar-widget-wrapper mb-60">
                     <!-- Design Guidelines -->
                     <div class="sidebar-widget">
                        <h4 class="sidebar-widget-title">
                           <i class="fas fa-lightbulb"></i> Design Guidelines
                        </h4>
                        <div class="sidebar-widget-content">
                           <div class="guideline-list">
                              <div class="guideline-item mb-20">
                                 <h6 class="mb-10">File Formats</h6>
                                 <p>We accept PNG, JPG, and PDF files. PNG is preferred with transparent backgrounds.</p>
                              </div>
                              <div class="guideline-item mb-20">
                                 <h6 class="mb-10">File Size</h6>
                                 <p>Maximum file size is 10MB. Smaller files upload faster.</p>
                              </div>
                              <div class="guideline-item mb-20">
                                 <h6 class="mb-10">Resolution</h6>
                                 <p>For best quality, use images with 300 DPI or higher.</p>
                              </div>
                              <div class="guideline-item mb-20">
                                 <h6 class="mb-10">Design Placement</h6>
                                 <p>Leave at least 0.5 inch margins from the edges of the T-shirt.</p>
                              </div>
                              <div class="guideline-item">
                                 <h6 class="mb-10">Color Accuracy</h6>
                                 <p>Colors may appear slightly different on the actual T-shirt depending on fabric and printing method.</p>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Pricing Info -->
                     <div class="sidebar-widget mt-40">
                        <h4 class="sidebar-widget-title">
                           <i class="fas fa-tag"></i> Pricing
                        </h4>
                        <div class="sidebar-widget-content">
                           <div class="pricing-info">
                              <p>Custom design pricing starts at <strong>₹499.00</strong> for a single shirt depending on:</p>
                              <ul class="list-unstyled mt-15">
                                 <li class="mb-8"><i class="fas fa-check text-success"></i> T-shirt size & fabric quality</li>
                                 <li class="mb-8"><i class="fas fa-check text-success"></i> Design complexity</li>
                                 <li class="mb-8"><i class="fas fa-check text-success"></i> Number of colors</li>
                                 <li><i class="fas fa-check text-success"></i> Quantity of shirts</li>
                              </ul>
                              <p class="mt-15"><small class="text-muted">Final price will be confirmed after design approval.</small></p>
                           </div>
                        </div>
                     </div>

                     <!-- FAQ -->
                     <div class="sidebar-widget mt-40">
                        <h4 class="sidebar-widget-title">
                           <i class="fas fa-question-circle"></i> FAQ
                        </h4>
                        <div class="sidebar-widget-content">
                           <div class="faq-list">
                              <div class="faq-item mb-15">
                                 <h6 class="mb-8"><strong>Q: How long does approval take?</strong></h6>
                                 <p class="mb-0"><small>A: Usually 24-48 hours. You'll be notified via email.</small></p>
                              </div>
                              <div class="faq-item mb-15">
                                 <h6 class="mb-8"><strong>Q: Can I modify my design?</strong></h6>
                                 <p class="mb-0"><small>A: Yes, if requested in our feedback, you can resubmit.</small></p>
                              </div>
                              <div class="faq-item">
                                 <h6 class="mb-8"><strong>Q: What's the minimum order?</strong></h6>
                                 <p class="mb-0"><small>A: You can order as little as 1 shirt from your design.</small></p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         @else
            <!-- Not Logged In Message -->
            <div class="row">
               <div class="col-lg-8 mx-auto">
                  <div class="login-required-card">
                     <div class="text-center mb-40">
                        <i class="fas fa-lock" style="font-size: 60px; color: #f4b400;"></i>
                        <h2 class="mt-30 mb-20">Sign In Required</h2>
                        <p class="text-muted">You must be logged in to submit a custom design. Please sign in to your account or create a new account to get started.</p>
                     </div>
                     <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="{{ route('login') }}" class="fill-btn">
                           <i class="fas fa-sign-in-alt"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="border-btn">
                           <i class="fas fa-user-plus"></i> Create Account
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endauth
      </div>
   </section>
   <!-- custom design form area end -->

</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   // File upload validation
   const frontDesignInput = document.querySelector('input[name="front_design_file"]');
   const backDesignInput = document.querySelector('input[name="back_design_file"]');

   [frontDesignInput, backDesignInput].forEach(input => {
      if (input) {
         input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
               const validFormats = ['image/png', 'image/jpeg', 'application/pdf'];
               const maxSize = 10 * 1024 * 1024; // 10MB

               if (!validFormats.includes(file.type)) {
                  alert('Please upload PNG, JPG, or PDF files only');
                  this.value = '';
                  return;
               }
               if (file.size > maxSize) {
                  alert('File size should not exceed 10MB');
                  this.value = '';
                  return;
               }
            }
         });
      }
   });
});
</script>
@endpush