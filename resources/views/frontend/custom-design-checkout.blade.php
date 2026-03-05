@extends('frontend.layout.app')

@section('title', 'Custom Design Checkout')

@section('content')
<main>
   <!-- Breadcrumb Start -->
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url({{ asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg') }});">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content">
                  <h3 class="breadcrumb__title">Custom Design Checkout</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{ route('home') }}">Home</a></span>
                     <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                     <span><a href="{{ route('custom-design.show', $design) }}">Design Details</a></span>
                     <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                     <span>Checkout</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Breadcrumb End -->

   <!-- Checkout Area Start -->
   <section class="pt-100 pb-100">
      <div class="container">
         @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               {{ session('error') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif

         <form action="{{ route('custom-design.payment.process', $design) }}" method="POST">
            @csrf
            <div class="row">
               <div class="col-lg-7">
                  <!-- Delivery Address -->
                  <div class="card shadow-sm mb-4">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Delivery Address</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12 mb-3">
                              <label for="shipping_address" class="form-label">Address (House No, Building, Street) <span class="text-danger">*</span></label>
                              <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                        id="shipping_address" name="shipping_address" 
                                        rows="2" required>{{ old('shipping_address') }}</textarea>
                              @error('shipping_address')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>

                           <div class="col-md-6 mb-3">
                              <label for="shipping_city" class="form-label">City <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" 
                                     id="shipping_city" name="shipping_city" 
                                     value="{{ old('shipping_city') }}" required>
                              @error('shipping_city')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>

                           <div class="col-md-6 mb-3">
                              <label for="shipping_state" class="form-label">State <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" 
                                     id="shipping_state" name="shipping_state" 
                                     value="{{ old('shipping_state') }}" required>
                              @error('shipping_state')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>

                           <div class="col-md-6 mb-3">
                              <label for="shipping_postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('shipping_postal_code') is-invalid @enderror" 
                                     id="shipping_postal_code" name="shipping_postal_code" 
                                     value="{{ old('shipping_postal_code') }}" required>
                              @error('shipping_postal_code')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>

                           <div class="col-md-6 mb-3">
                              <label for="shipping_country" class="form-label">Country <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('shipping_country') is-invalid @enderror" 
                                     id="shipping_country" name="shipping_country" 
                                     value="{{ old('shipping_country', 'India') }}" required>
                              @error('shipping_country')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Payment Method -->
                  <div class="card shadow-sm">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Payment Method</h5>
                     </div>
                     <div class="card-body">
                        <div class="form-check mb-3">
                           <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                           <label class="form-check-label" for="cod">
                              <strong>Cash on Delivery (COD)</strong>
                              <p class="text-muted mb-0 small">Pay when you receive the product</p>
                           </label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="payment_method" id="online" value="online">
                           <label class="form-check-label" for="online">
                              <strong>Online Payment</strong>
                              <p class="text-muted mb-0 small">Pay securely online (Coming Soon)</p>
                           </label>
                        </div>
                        @error('payment_method')
                           <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
               </div>

               <!-- Order Summary -->
               <div class="col-lg-5">
                  <div class="card shadow-sm sticky-top" style="top: 20px;">
                     <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                     </div>
                     <div class="card-body">
                        <!-- Design Details -->
                        <div class="mb-3 pb-3 border-bottom">
                           <h6 class="mb-3"><strong>Design #{{ $design->id }}</strong></h6>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Customer:</span>
                              <strong>{{ $design->customer_name }}</strong>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Size:</span>
                              <strong>{{ strtoupper($design->selected_size) }}</strong>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Sleeve:</span>
                              <strong>{{ ucfirst($design->sleeve_type) }}</strong>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Color:</span>
                              <div class="d-flex align-items-center">
                                 <div style="width: 20px; height: 20px; border-radius: 50%; border: 1px solid #dee2e6; background-color: {{ $design->color }}" class="me-2"></div>
                                 <span>{{ $design->color }}</span>
                              </div>
                           </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="mb-3">
                           <div class="d-flex justify-content-between mb-2">
                              <span>Custom Design T-Shirt</span>
                              <strong>₹{{ number_format($design->price, 2) }}</strong>
                           </div>
                           <div class="d-flex justify-content-between mb-2 text-muted">
                              <span>Quantity</span>
                              <span>1</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span>Shipping</span>
                              <strong class="text-success">FREE</strong>
                           </div>
                        </div>

                        <!-- Total -->
                        <div class="pt-3 border-top">
                           <div class="d-flex justify-content-between mb-3">
                              <h5 class="mb-0">Total Amount</h5>
                              <h5 class="mb-0 text-primary">₹{{ number_format($design->price, 2) }}</h5>
                           </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="fill-btn w-100">
                           <i class="fal fa-lock me-2"></i>
                           Place Order
                        </button>

                        <!-- Security Info -->
                        <div class="mt-3 text-center">
                           <small class="text-muted">
                              <i class="fal fa-shield-alt text-success"></i>
                              Your information is secure and protected
                           </small>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </section>
   <!-- Checkout Area End -->
</main>
@endsection
