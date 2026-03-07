@extends('frontend.layout.app')

@section('title', 'Custom Design Details - Tinnity')

@section('content')
<main>
   <!-- breadcrumb area start  -->
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url({{ asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg') }});">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content">
                  <h3 class="breadcrumb__title">Design Details</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{ route('home') }}">Home</a></span>
                     <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                     <span>Design Details</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- breadcrumb area end  -->

   <!-- Design Details Section -->
   <section class="pt-100 pb-100">
      <div class="container">
         <div class="row">
            <div class="col-lg-8">
               <!-- Status Card -->
               <div class="card shadow-sm mb-4">
                  <div class="card-header bg-white">
                     <div class="d-flex justify-content-between align-items-center">
                        <div>
                           <h4 class="mb-1">Design Submission #{{ $design->id }}</h4>
                           <small class="text-muted">{{ $design->created_at->format('M d, Y') }}</small>
                        </div>
                        <span class="badge 
                           @if($design->status === 'approved') bg-success
                           @elseif($design->status === 'rejected') bg-danger
                           @elseif($design->status === 'changes_requested') bg-warning
                           @else bg-info
                           @endif" style="font-size: 14px;">
                           {{ ucwords(str_replace('_', ' ', $design->status)) }}
                        </span>
                     </div>
                  </div>
                  <div class="card-body">
                     <!-- Status Badge -->
                     <div class="mb-4">
                        @if($design->status === 'pending')
                           <div class="alert alert-info mb-0">
                              <div class="d-flex align-items-start">
                                 <i class="fal fa-hourglass-half me-3" style="font-size: 24px; margin-top: 2px;"></i>
                                 <div>
                                    <h6 class="mb-1"><strong>Pending Review</strong></h6>
                                    <p class="mb-0">Your design is being reviewed by our team. This usually takes 24-48 hours.</p>
                                 </div>
                              </div>
                           </div>
                        @elseif($design->status === 'approved')
                           <div class="alert alert-success mb-0">
                              <div class="d-flex align-items-start justify-content-between">
                                 <div class="d-flex align-items-start">
                                    <i class="fal fa-check-circle me-3" style="font-size: 24px; margin-top: 2px;"></i>
                                    <div>
                                       <h6 class="mb-1"><strong>Approved! 🎉</strong></h6>
                                       @if($design->price > 0)
                                          <p class="mb-0">Your design is ready for order. Payment is now unlocked.</p>
                                       @else
                                          <p class="mb-0">Your design has been approved! Pricing will be updated shortly.</p>
                                       @endif
                                    </div>
                                 </div>
                                 @if($design->price > 0)
                                 <div class="text-end ms-3">
                                    <small class="text-muted d-block">Price</small>
                                    <h4 class="mb-0 text-success">₹{{ number_format($design->price, 2) }}</h4>
                                 </div>
                                 @endif
                              </div>
                           </div>
                        @elseif($design->status === 'rejected')
                           <div class="alert alert-danger mb-0">
                              <div class="d-flex align-items-start">
                                 <i class="fal fa-times-circle me-3" style="font-size: 24px; margin-top: 2px;"></i>
                                 <div>
                                    <h6 class="mb-1"><strong>Design Rejected</strong></h6>
                                    <p class="mb-0">Unfortunately, this design does not meet our quality standards.</p>
                                 </div>
                              </div>
                           </div>
                        @elseif($design->status === 'changes_requested')
                           <div class="alert alert-warning mb-0">
                              <div class="d-flex align-items-start">
                                 <i class="fal fa-exclamation-circle me-3" style="font-size: 24px; margin-top: 2px;"></i>
                                 <div>
                                    <h6 class="mb-1"><strong>Revision Requested</strong></h6>
                                    <p class="mb-0">Please update your design based on the feedback below.</p>
                                 </div>
                              </div>
                           </div>
                        @endif
                     </div>

                     <!-- Design Information -->
                     <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6 mb-3">
                           <p class="text-muted mb-2"><strong>Size</strong></p>
                           <h5 class="mb-0">{{ strtoupper($design->selected_size) }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                           <p class="text-muted mb-2"><strong>Sleeve Type</strong></p>
                           <h5 class="mb-0">{{ ucfirst($design->sleeve_type) }} Sleeve</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                           <p class="text-muted mb-2"><strong>T-Shirt Color</strong></p>
                           <div class="d-flex align-items-center">
                              <div style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #dee2e6; background-color: {{ $design->color }}" class="me-3"></div>
                              <span>{{ $design->color }}</span>
                           </div>
                        </div>
                        <div class="col-md-6 mb-3">
                           <p class="text-muted mb-2"><strong>Payment Status</strong></p>
                           <h5 class="mb-0">
                              @if($design->payment_status === 'unpaid')
                                 <span class="badge bg-warning">Unpaid</span>
                              @elseif($design->payment_status === 'paid')
                                 <span class="badge bg-success">Paid</span>
                              @else
                                 <span class="badge bg-secondary">{{ ucfirst($design->payment_status) }}</span>
                              @endif
                           </h5>
                        </div>
                     </div>

                     <!-- Design Files -->
                     <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3">
                           <i class="fal fa-file-image"></i> Design Files
                        </h5>

                        <div class="row">
                           <!-- Front Design -->
                           <div class="col-md-6 mb-3">
                              <div class="p-3 bg-light rounded">
                                 <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Front Design</strong>
                                    <i class="fal fa-check-circle text-success"></i>
                                 </div>
                                 <p class="text-muted mb-3" style="font-size: 12px; word-break: break-all;">
                                    {{ basename($design->front_design_file) }}
                                 </p>
                                 <a href="{{ route('custom-design.download', [$design, 'front']) }}" 
                                    class="fill-btn btn-sm">
                                    <i class="fal fa-download me-1"></i>Download
                                 </a>
                              </div>
                           </div>

                           <!-- Back Design -->
                           <div class="col-md-6 mb-3">
                              <div class="p-3 bg-light rounded">
                                 <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Back Design</strong>
                                    @if($design->back_design_file)
                                       <i class="fal fa-check-circle text-success"></i>
                                    @else
                                       <i class="fal fa-minus-circle text-muted"></i>
                                    @endif
                                 </div>
                                 @if($design->back_design_file)
                                    <p class="text-muted mb-3" style="font-size: 12px; word-break: break-all;">
                                       {{ basename($design->back_design_file) }}
                                    </p>
                                    <a href="{{ route('custom-design.download', [$design, 'back']) }}" 
                                       class="fill-btn btn-sm">
                                       <i class="fal fa-download me-1"></i>Download
                                    </a>
                                 @else
                                    <p class="text-muted mb-0" style="font-size: 12px;">Not provided</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Notes -->
                     @if($design->notes)
                        <div class="mb-4 pb-4 border-bottom">
                           <h5 class="mb-3">
                              <i class="fal fa-sticky-note"></i> Your Notes
                           </h5>
                           <div class="p-3 bg-light rounded">
                              <p class="mb-0" style="white-space: pre-wrap;">{{ $design->notes }}</p>
                           </div>
                        </div>
                     @endif

                     <!-- Admin Remark -->
                     @if($design->admin_remark)
                        <div class="mb-4">
                           <div class="alert alert-warning">
                              <h5 class="mb-2">
                                 <i class="fal fa-comment-dots"></i> Admin Feedback
                              </h5>
                              <p class="mb-0" style="white-space: pre-wrap;">{{ $design->admin_remark }}</p>
                           </div>
                        </div>
                     @endif

                     <!-- Action Buttons -->
                     <div class="d-flex flex-column flex-sm-row gap-3">
                        @if($design->canPay())
                           <form method="GET" action="{{ route('custom-design.checkout', $design) }}" class="flex-fill">
                              <button type="submit" class="fill-btn w-100">
                                 <i class="fal fa-credit-card me-2"></i>
                                 Pay Now (₹{{ number_format($design->price, 2) }})
                              </button>
                           </form>
                        @elseif($design->status === 'approved' && (!$design->price || $design->price <= 0))
                           <div class="alert alert-info mb-0 flex-fill">
                              <i class="fal fa-info-circle me-2"></i>
                              Waiting for admin to set the price. Payment will be enabled once pricing is complete.
                           </div>
                        @endif

                        @if($design->requiresRevision())
                           <button type="button" 
                                   class="border-btn flex-fill"
                                   onclick="document.getElementById('revisionForm').classList.remove('d-none')">
                              <i class="fal fa-upload me-2"></i>
                              Resubmit Design
                           </button>
                        @endif

                        <a href="{{ route('home') }}" class="border-btn flex-fill text-center">
                           <i class="fa fa-arrow-left me-2"></i>Back to Home
                        </a>
                     </div>
                  </div>
               </div>

               <!-- Revision Form (Hidden by default) -->
               @if($design->requiresRevision())
                  <div id="revisionForm" class="card shadow-sm mb-4 d-none">
                     <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                           <i class="fal fa-redo"></i> Resubmit Your Design
                        </h5>
                     </div>
                     <div class="card-body">
                        <form action="{{ route('custom-design.update', $design) }}" method="POST" enctype="multipart/form-data">
                           @csrf

                           <div class="mb-3">
                              <label class="form-label"><strong>Update Front Design (Optional)</strong></label>
                              <input type="file" 
                                     name="front_design_file" 
                                     accept=".png,.jpg,.jpeg,.pdf"
                                     class="form-control">
                              <small class="form-text text-muted">Leave empty to keep current file</small>
                           </div>

                           <div class="mb-3">
                              <label class="form-label"><strong>Update Back Design (Optional)</strong></label>
                              <input type="file" 
                                     name="back_design_file" 
                                     accept=".png,.jpg,.jpeg,.pdf"
                                     class="form-control">
                              <small class="form-text text-muted">Leave empty to keep current file</small>
                           </div>

                           <div class="mb-3">
                              <label class="form-label"><strong>Additional Notes</strong></label>
                              <textarea name="notes" 
                                        rows="4"
                                        class="form-control"
                                        placeholder="Explain the changes you made..."></textarea>
                           </div>

                           <div class="d-flex gap-3">
                              <button type="submit" class="fill-btn flex-fill">
                                 <i class="fal fa-check me-2"></i>Resubmit
                              </button>
                              <button type="button" 
                                      onclick="document.getElementById('revisionForm').classList.add('d-none')"
                                      class="border-btn flex-fill">
                                 Cancel
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
               @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
               <!-- Design Guidelines -->
               <div class="card shadow-sm mb-4">
                  <div class="card-header bg-white">
                     <h5 class="mb-0">
                        <i class="fal fa-lightbulb text-warning"></i> Design Guidelines
                     </h5>
                  </div>
                  <div class="card-body">
                     <div class="mb-3">
                        <h6 class="mb-2"><strong>File Formats</strong></h6>
                        <p class="mb-0 text-muted">We accept PNG, JPG, and PDF files. PNG is preferred with transparent backgrounds.</p>
                     </div>
                     <hr>
                     <div class="mb-3">
                        <h6 class="mb-2"><strong>File Size</strong></h6>
                        <p class="mb-0 text-muted">Maximum file size is 10MB. Smaller files upload faster.</p>
                     </div>
                     <hr>
                     <div class="mb-3">
                        <h6 class="mb-2"><strong>Resolution</strong></h6>
                        <p class="mb-0 text-muted">For best quality, use images with 300 DPI or higher.</p>
                     </div>
                     <hr>
                     <div class="mb-3">
                        <h6 class="mb-2"><strong>Design Placement</strong></h6>
                        <p class="mb-0 text-muted">Leave at least 0.5 inch margins from the edges of the T-shirt.</p>
                     </div>
                     <hr>
                     <div>
                        <h6 class="mb-2"><strong>Color Accuracy</strong></h6>
                        <p class="mb-0 text-muted">Colors may appear slightly different on the actual T-shirt depending on fabric and printing method.</p>
                     </div>
                  </div>
               </div>

               <!-- Pricing Info -->
               <div class="card shadow-sm mb-4">
                  <div class="card-header bg-white">
                     <h5 class="mb-0">
                        <i class="fal fa-tag text-success"></i> Pricing
                     </h5>
                  </div>
                  <div class="card-body">
                     <p>Custom design pricing starts at <strong class="text-success">₹499.00</strong> for a single shirt depending on:</p>
                     <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="fal fa-check text-success me-2"></i>T-shirt size & fabric quality</li>
                        <li class="mb-2"><i class="fal fa-check text-success me-2"></i>Design complexity</li>
                        <li class="mb-2"><i class="fal fa-check text-success me-2"></i>Number of colors</li>
                        <li><i class="fal fa-check text-success me-2"></i>Quantity of shirts</li>
                     </ul>
                     <p class="mt-3 mb-0"><small class="text-muted">Final price will be confirmed after design approval.</small></p>
                  </div>
               </div>

               <!-- FAQ -->
               <div class="card shadow-sm">
                  <div class="card-header bg-white">
                     <h5 class="mb-0">
                        <i class="fal fa-question-circle text-info"></i> FAQ
                     </h5>
                  </div>
                  <div class="card-body">
                     <div class="mb-3">
                        <h6 class="mb-1"><strong>Q: How long does approval take?</strong></h6>
                        <p class="mb-0 text-muted" style="font-size: 14px;">A: Usually 24-48 hours. You'll be notified via email.</p>
                     </div>
                     <hr>
                     <div class="mb-3">
                        <h6 class="mb-1"><strong>Q: Can I modify my design?</strong></h6>
                        <p class="mb-0 text-muted" style="font-size: 14px;">A: Yes, if requested in our feedback, you can resubmit.</p>
                     </div>
                     <hr>
                     <div>
                        <h6 class="mb-1"><strong>Q: What's the minimum order?</strong></h6>
                        <p class="mb-0 text-muted" style="font-size: 14px;">A: You can order as little as 1 shirt from your design.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</main>
@endsection
