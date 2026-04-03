@extends('frontend.layout.app')

@section('title', 'Payment Successful - Order Confirmation')

@section('content')
<main>
   <!-- Breadcrumb Start -->
   <section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="page-title-wrapper text-center">
                  <h1 class="page-title mb-10">Payment Successful</h1>
                  <div class="breadcrumb-menu">
                     <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items">
                           <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                           <li class="trail-item trail-end"><span>Payment Successful</span></li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Breadcrumb End -->

   <!-- Success Message Area Start -->
   <section class="success-area pt-100 pb-100">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
               <div class="success-message-wrapper text-center">
                  <!-- Success Icon -->
                  <div class="success-icon mb-4">
                     <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                  </div>

                  <h2 class="mb-3" style="color: #333;">Payment Successful!</h2>
                  <p class="mb-4" style="font-size: 16px; color: #666;">
                     Thank you for your payment. Your order has been confirmed and will be processed shortly.
                  </p>

                  <!-- Order Details Card -->
                  <div class="order-details-card" style="background: #f8f9fa; border-radius: 8px; padding: 30px; margin-bottom: 30px; text-align: left;">
                     <h4 class="mb-4" style="color: #333; text-align: center;">Order Details</h4>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Order Number:</span>
                        <strong style="color: #333;">{{ $order->order_number }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Order Date:</span>
                        <strong style="color: #333;">{{ $order->placed_at->format('M d, Y - h:i A') }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Total Amount:</span>
                        <strong style="color: #28a745; font-size: 18px;">₹{{ number_format($order->total_amount, 2) }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Payment Status:</span>
                        <span class="badge bg-success">Completed</span>
                     </div>

                     <div class="detail-row" style="display: flex; justify-content: space-between; padding-bottom: 10px;">
                        <span style="color: #666;">Delivery Address:</span>
                        <strong style="color: #333; text-align: right; max-width: 50%;">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_country }}</strong>
                     </div>
                  </div>

                  <div class="order-details-card" style="background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 30px; margin-bottom: 30px; text-align: left;">
                     <h4 class="mb-4" style="color: #333; text-align: center;">Shipping Details</h4>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Shipping Partner:</span>
                        <strong style="color: #333;">{{ $order->shipping_partner ?? 'Shiprocket' }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Shipping Method:</span>
                        <strong style="color: #333;">{{ $order->shipping_method ?? 'Shiprocket Standard' }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Tracking Number:</span>
                        <strong style="color: #333;">{{ $order->tracking_number ?? 'Pending' }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Shipping Weight (g):</span>
                        <strong style="color: #333;">{{ $order->shipping_weight_grams !== null ? $order->shipping_weight_grams : 'Pending' }}</strong>
                     </div>

                     <div class="detail-row mb-3" style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span style="color: #666;">Shipping Cost (₹):</span>
                        <strong style="color: #333;">{{ $order->shipping_cost !== null ? number_format($order->shipping_cost, 2) : '0.00' }}</strong>
                     </div>

                     <div class="detail-row" style="display: flex; justify-content: space-between; padding-bottom: 10px;">
                        <span style="color: #666;">Delivery Status:</span>
                        <span class="badge bg-secondary">{{ ucwords(str_replace('_', ' ', $order->delivery_status ?? 'pending')) }}</span>
                     </div>
                  </div>

                  <!-- What's Next Section -->
                  <div class="whats-next-section mb-4">
                     <h5 style="color: #333; margin-bottom: 15px;">What's Next?</h5>
                     <ul style="list-style: none; padding: 0; text-align: left;">
                        <li style="margin-bottom: 10px;">
                           <i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>
                           <span>Your order has been confirmed and payment received</span>
                        </li>
                        <li style="margin-bottom: 10px;">
                           <i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>
                           <span>You will receive an order confirmation email shortly</span>
                        </li>
                        <li style="margin-bottom: 10px;">
                           <i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>
                           <span>Your order will be packed and dispatched within 2-3 business days</span>
                        </li>
                        <li style="margin-bottom: 10px;">
                           <i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>
                           <span>You can track your shipment from your account</span>
                        </li>
                     </ul>
                  </div>

                  <!-- Action Buttons -->
                  <div class="action-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                     <a href="{{ route('orders') }}" class="fill-btn" style="text-decoration: none; display: inline-block;">
                        <i class="fal fa-receipt me-2"></i> View My Orders
                     </a>
                     <a href="{{ route('shop') }}" class="border-btn" style="text-decoration: none; display: inline-block;">
                        <i class="fal fa-shopping-bag me-2"></i> Continue Shopping
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Success Message Area End -->

   <style>
      .success-message-wrapper {
         background: white;
         border-radius: 12px;
         padding: 40px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      }

      .order-details-card {
         box-shadow: 0 1px 8px rgba(0,0,0,0.05);
      }

      @media (max-width: 768px) {
         .success-message-wrapper {
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
