@extends('frontend.layout.app')

@section('title', 'Payment Failed')

@section('content')
<main>
   <!-- Breadcrumb Start -->
   <section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="page-title-wrapper text-center">
                  <h1 class="page-title mb-10">Payment Failed</h1>
                  <div class="breadcrumb-menu">
                     <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items">
                           <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                           <li class="trail-item trail-end"><span>Payment Failed</span></li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Breadcrumb End -->

   <!-- Failure Message Area Start -->
   <section class="failure-area pt-100 pb-100">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
               <div class="failure-message-wrapper text-center">
                  <!-- Failure Icon -->
                  <div class="failure-icon mb-4">
                     <i class="fas fa-times-circle" style="font-size: 80px; color: #dc3545;"></i>
                  </div>

                  <h2 class="mb-3" style="color: #333;">Payment Failed</h2>
                  <p class="mb-4" style="font-size: 16px; color: #666;">
                     Unfortunately, your payment could not be processed. Please try again with a different payment method or card.
                  </p>

                  <!-- Order Details Card -->
                  <div class="order-details-card" style="background: #f8f9fa; border-radius: 8px; padding: 30px; margin-bottom: 30px; text-align: left;">
                     <h4 class="mb-4" style="color: #333; text-align: center;">Order Details</h4>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Order Number:</span>
                        <strong style="color: #333;">{{ $order->order_number }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Total Amount:</span>
                        <strong style="color: #333; font-size: 18px;">₹{{ number_format($order->total_amount, 2) }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Payment Status:</span>
                        <span class="badge bg-danger">Failed</span>
                     </div>

                     <div class="detail-row" style="display: flex; justify-content: space-between; padding-bottom: 10px;">
                        <span style="color: #666;">Attempted At:</span>
                        <strong style="color: #333;">{{ $order->placed_at->format('M d, Y - h:i A') }}</strong>
                     </div>
                  </div>

                  <!-- Troubleshooting Section -->
                  <div class="troubleshooting-section mb-4" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 4px; text-align: left;">
                     <h5 style="color: #856404; margin-bottom: 10px;">What You Can Try:</h5>
                     <ul style="list-style: none; padding: 0; color: #856404;">
                        <li style="margin-bottom: 8px;">
                           <i class="fas fa-chevron-right" style="margin-right: 10px;"></i>
                           Try using a different payment method (Card, UPI, or Wallet)
                        </li>
                        <li style="margin-bottom: 8px;">
                           <i class="fas fa-chevron-right" style="margin-right: 10px;"></i>
                           Check if you have sufficient funds in your account
                        </li>
                        <li style="margin-bottom: 8px;">
                           <i class="fas fa-chevron-right" style="margin-right: 10px;"></i>
                           Ensure your card/UPI details are correct
                        </li>
                        <li style="margin-bottom: 8px;">
                           <i class="fas fa-chevron-right" style="margin-right: 10px;"></i>
                           Try refreshing and attempting the payment again
                        </li>
                        <li>
                           <i class="fas fa-chevron-right" style="margin-right: 10px;"></i>
                           Contact your bank if the issue persists
                        </li>
                     </ul>
                  </div>

                  <!-- Action Buttons -->
                  <div class="action-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                     <a href="{{ route('checkout') }}" class="fill-btn" style="text-decoration: none; padding: 12px 30px; display: inline-block;">
                        <i class="fal fa-redo me-2"></i> Try Again
                     </a>
                     <a href="{{ route('orders') }}" class="border-btn" style="text-decoration: none; padding: 12px 30px; display: inline-block;">
                        <i class="fal fa-receipt me-2"></i> View Orders
                     </a>
                  </div>

                  <!-- Support Section -->
                  <div class="support-section mt-5" style="padding-top: 30px; border-top: 1px solid #e5e5e5;">
                     <p style="color: #666; margin-bottom: 10px;">Need Help?</p>
                     <a href="{{ route('contact') }}" style="color: #ffc107; text-decoration: none; font-weight: 600;">
                        <i class="fal fa-envelope me-2"></i> Contact Our Support Team
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Failure Message Area End -->

   <style>
      .failure-message-wrapper {
         background: white;
         border-radius: 12px;
         padding: 40px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      }

      .order-details-card {
         box-shadow: 0 1px 8px rgba(0,0,0,0.05);
      }

      @media (max-width: 768px) {
         .failure-message-wrapper {
            padding: 20px;
         }

         .order-details-card {
            padding: 15px;
         }

         .action-buttons {
            flex-direction: column;
         }

         .action-buttons a {
            width: 100%;
            text-align: center;
         }
      }
   </style>
</main>
@endsection
