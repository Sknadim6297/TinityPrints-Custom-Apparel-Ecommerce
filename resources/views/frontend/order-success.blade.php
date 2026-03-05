@extends('frontend.layout.app')

@section('title', 'Order Placed Successfully')

@section('content')
<main>
   <!-- Breadcrumb Start -->
   <section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpg') }}">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="page-title-wrapper text-center">
                  <h1 class="page-title mb-10">Order Success</h1>
                  <div class="breadcrumb-menu">
                     <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items">
                           <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                           <li class="trail-item trail-end"><span>Order Success</span></li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Breadcrumb End -->

   <!-- Order Success Area Start -->
   <section class="order-success-area pt-100 pb-100">
      <div class="container">
         <div class="row">
            <div class="col-lg-10 offset-lg-1">
               <!-- Success Header -->
               <div class="success-header text-center mb-40">
                  <div class="success-icon mb-30">
                     <i class="fal fa-check-circle"></i>
                  </div>
                  <h2 class="success-title mb-15">Thank You!</h2>
                  <p class="success-subtitle">Your order has been placed successfully</p>
               </div>

               <!-- Order Number Badge -->
               <div class="order-number-badge mb-40">
                  <div class="order-badge-label">Order Number</div>
                  <div class="order-badge-number">{{ $order->order_number }}</div>
               </div>

               <!-- Order Summary Cards -->
               <div class="row mb-40">
                  <div class="col-md-6 mb-20">
                     <div class="info-card">
                        <div class="info-card-icon">
                           <i class="fal fa-rupee-sign"></i>
                        </div>
                        <div class="info-card-content">
                           <div class="info-card-label">Total Amount</div>
                           <div class="info-card-value">₹{{ number_format($order->total_amount, 2) }}</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 mb-20">
                     <div class="info-card">
                        <div class="info-card-icon">
                           <i class="fal fa-wallet"></i>
                        </div>
                        <div class="info-card-content">
                           <div class="info-card-label">Payment Method</div>
                           <div class="info-card-value">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Order Details Section -->
               <div class="order-details-section mb-40">
                  <h4 class="section-title mb-30">Order Details</h4>
                  
                  <div class="row">
                     <!-- Shipping Address -->
                     <div class="col-md-6 mb-30">
                        <div class="detail-box">
                           <div class="detail-box-header">
                              <i class="fal fa-shipping-fast"></i>
                              <h6>Shipping Address</h6>
                           </div>
                           <div class="detail-box-content">
                              <p class="customer-name mb-2">{{ $order->customer_name }}</p>
                              <p class="mb-2">{{ $order->shipping_address }}</p>
                              <p class="mb-2">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                              <p class="mb-0">{{ $order->shipping_country }}</p>
                           </div>
                        </div>
                     </div>

                     <!-- Contact Information -->
                     <div class="col-md-6 mb-30">
                        <div class="detail-box">
                           <div class="detail-box-header">
                              <i class="fal fa-address-book"></i>
                              <h6>Contact Information</h6>
                           </div>
                           <div class="detail-box-content">
                              <p class="mb-2">
                                 <i class="fal fa-phone-alt text-muted me-2"></i>
                                 <strong>Phone:</strong> {{ $order->phone }}
                              </p>
                              <p class="mb-0">
                                 <i class="fal fa-envelope text-muted me-2"></i>
                                 <strong>Email:</strong> {{ $order->email }}
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Items Ordered -->
               <div class="order-items-section mb-40">
                  <h4 class="section-title mb-30">Items Ordered</h4>
                  <div class="order-items-table-wrap">
                     <table class="order-items-table">
                        <thead>
                           <tr>
                              <th>Product</th>
                              <th>Details</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($order->items as $item)
                              <tr>
                                 <td>
                                    <div class="product-info-cell">
                                       @if($order->design_request_id && $order->designRequest && $order->designRequest->front_design_file)
                                          {{-- Custom Design Order - Show uploaded design --}}
                                          <img src="{{ \Illuminate\Support\Facades\Storage::url($order->designRequest->front_design_file) }}" 
                                               alt="{{ $item->product_name }}" style="object-fit: contain;">
                                       @elseif($item->product && $item->product->images && $item->product->images->first())
                                          {{-- Regular Shop Order - Show product image --}}
                                          <img src="{{ \Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_path) }}" 
                                               alt="{{ $item->product_name }}">
                                       @else
                                          {{-- Fallback placeholder --}}
                                          <img src="{{ asset('frontend/assets/img/product/product-img1.jpg') }}" 
                                               alt="{{ $item->product_name }}">
                                       @endif
                                       <span>{{ $item->product_name }}</span>
                                    </div>
                                 </td>
                                 <td>
                                    @if($item->color_name)
                                       <span class="detail-badge">{{ $item->color_name }}</span>
                                    @endif
                                    @if($item->size)
                                       <span class="detail-badge">{{ $item->size }}</span>
                                    @endif
                                 </td>
                                 <td>₹{{ number_format($item->price, 2) }}</td>
                                 <td>{{ $item->quantity }}</td>
                                 <td><strong>₹{{ number_format($item->total, 2) }}</strong></td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr class="subtotal-row">
                              <td colspan="4">Subtotal:</td>
                              <td><strong>₹{{ number_format($order->subtotal, 2) }}</strong></td>
                           </tr>
                           @if($order->discount_amount > 0)
                              <tr class="discount-row">
                                 <td colspan="4">Discount:</td>
                                 <td><strong>-₹{{ number_format($order->discount_amount, 2) }}</strong></td>
                              </tr>
                           @endif
                           <tr class="total-row">
                              <td colspan="4">Total:</td>
                              <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>

               <!-- Email Confirmation Notice -->
               <div class="confirmation-notice mb-40">
                  <i class="fal fa-info-circle"></i>
                  <p>You will receive an email confirmation at <strong>{{ $order->email }}</strong> shortly. You can track your order status in your profile.</p>
               </div>

               <!-- Action Buttons -->
               <div class="order-actions text-center">
                  <a href="{{ route('orders') }}" class="fill-btn me-3">
                     <i class="fal fa-list me-2"></i> View My Orders
                  </a>
                  <a href="{{ route('shop') }}" class="border-btn">
                     <i class="fal fa-shopping-bag me-2"></i> Continue Shopping
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Order Success Area End -->

   <style>
      /* Success Header */
      .success-header {
         background: #fff;
         padding: 40px;
         border-radius: 10px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      }
      .success-icon {
         display: inline-block;
         width: 100px;
         height: 100px;
         line-height: 100px;
         text-align: center;
         background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
         border-radius: 50%;
         color: #fff;
         font-size: 50px;
         box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
         animation: scaleIn 0.5s ease-out;
      }
      @keyframes scaleIn {
         from {
            transform: scale(0);
            opacity: 0;
         }
         to {
            transform: scale(1);
            opacity: 1;
         }
      }
      .success-title {
         font-size: 36px;
         font-weight: 700;
         color: #333;
      }
      .success-subtitle {
         font-size: 18px;
         color: #666;
         margin: 0;
      }

      /* Order Number Badge */
      .order-number-badge {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         text-align: center;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      }
      .order-badge-label {
         font-size: 14px;
         color: #666;
         margin-bottom: 8px;
         text-transform: uppercase;
         letter-spacing: 1px;
      }
      .order-badge-number {
         font-size: 24px;
         font-weight: 700;
         color: #ffc107;
      }

      /* Info Cards */
      .info-card {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         display: flex;
         align-items: center;
         gap: 20px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
         transition: transform 0.3s ease;
         height: 100%;
      }
      .info-card:hover {
         transform: translateY(-5px);
      }
      .info-card-icon {
         width: 60px;
         height: 60px;
         line-height: 60px;
         text-align: center;
         background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
         border-radius: 10px;
         color: #fff;
         font-size: 24px;
         flex-shrink: 0;
      }
      .info-card-content {
         flex: 1;
      }
      .info-card-label {
         font-size: 14px;
         color: #666;
         margin-bottom: 5px;
      }
      .info-card-value {
         font-size: 22px;
         font-weight: 700;
         color: #333;
      }

      /* Section Titles */
      .section-title {
         font-size: 22px;
         font-weight: 600;
         color: #333;
         padding-bottom: 15px;
         border-bottom: 2px solid #ffc107;
         display: inline-block;
         margin-bottom: 25px;
      }

      /* Detail Boxes */
      .detail-box {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
         height: 100%;
      }
      .detail-box-header {
         display: flex;
         align-items: center;
         gap: 10px;
         margin-bottom: 20px;
         padding-bottom: 15px;
         border-bottom: 1px solid #e5e5e5;
      }
      .detail-box-header i {
         font-size: 20px;
         color: #ffc107;
      }
      .detail-box-header h6 {
         margin: 0;
         font-size: 16px;
         font-weight: 600;
         color: #333;
      }
      .detail-box-content {
         font-size: 14px;
         color: #666;
         line-height: 1.8;
      }
      .detail-box-content .customer-name {
         font-size: 16px;
         font-weight: 600;
         color: #333;
      }

      /* Order Items Table */
      .order-items-table-wrap {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         box-shadow: 0 2px 15px rgba(0,0,0,0.08);
         overflow-x: auto;
      }
      .order-items-table {
         width: 100%;
         border-collapse: collapse;
      }
      .order-items-table thead {
         background: #f8f9fa;
      }
      .order-items-table th {
         padding: 15px;
         text-align: left;
         font-size: 14px;
         font-weight: 600;
         color: #333;
         border-bottom: 2px solid #e5e5e5;
      }
      .order-items-table tbody td {
         padding: 15px;
         border-bottom: 1px solid #e5e5e5;
         font-size: 14px;
         color: #666;
      }
      .order-items-table tbody tr:last-child td {
         border-bottom: none;
      }
      .product-info-cell {
         display: flex;
         align-items: center;
         gap: 12px;
      }
      .product-info-cell img {
         width: 60px;
         height: 60px;
         object-fit: cover;
         border-radius: 8px;
      }
      .product-info-cell span {
         color: #333;
         font-weight: 500;
      }
      .detail-badge {
         display: inline-block;
         padding: 4px 10px;
         background: #f8f9fa;
         border-radius: 20px;
         font-size: 12px;
         margin-right: 5px;
         color: #666;
      }
      .order-items-table tfoot td {
         padding: 12px 15px;
         font-size: 15px;
         text-align: right;
      }
      .subtotal-row td {
         border-top: 2px solid #e5e5e5;
         padding-top: 15px;
      }
      .discount-row td {
         color: #28a745;
      }
      .total-row td {
         font-size: 18px;
         border-top: 2px solid #e5e5e5;
         padding-top: 15px;
         color: #ffc107;
      }

      /* Confirmation Notice */
      .confirmation-notice {
         background: #e8f4fd;
         border-left: 4px solid #2196F3;
         padding: 20px 25px;
         border-radius: 8px;
         display: flex;
         align-items: center;
         gap: 15px;
      }
      .confirmation-notice i {
         font-size: 24px;
         color: #2196F3;
         flex-shrink: 0;
      }
      .confirmation-notice p {
         margin: 0;
         color: #333;
         font-size: 15px;
         line-height: 1.6;
      }

      /* Responsive */
      @media (max-width: 768px) {
         .success-icon {
            width: 80px;
            height: 80px;
            line-height: 80px;
            font-size: 40px;
         }
         .success-title {
            font-size: 28px;
         }
         .order-badge-number {
            font-size: 18px;
         }
         .info-card {
            flex-direction: column;
            text-align: center;
         }
         .order-items-table {
            font-size: 12px;
         }
         .product-info-cell {
            flex-direction: column;
         }
      }
   </style>
</main>
@endsection
