@extends('frontend.layout.app')

@section('title', 'Order Details')

@section('content')
   <main>
      <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url({{ asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg') }});">
         <div class="container container-small">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content">
                     <h3 class="breadcrumb__title">Order Details</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span><a href="{{ route('orders') }}">My Orders</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>Order Details</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="pt-100 pb-100">
         <div class="container container-small">
            <div class="row">
               <div class="col-lg-8">
                  <div class="card shadow-sm mb-4">
                     <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                           <div>
                              <h4 class="mb-1">Order #{{ $order->order_number }}</h4>
                              <small class="text-muted">
                                 Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                              </small>
                           </div>
                           <span class="badge 
                              @if($order->order_status == 'delivered') bg-success
                              @elseif($order->order_status == 'shipped') bg-info
                              @elseif($order->order_status == 'paid' || $order->order_status == 'printing' || $order->order_status == 'packed') bg-primary
                              @elseif($order->order_status == 'refunded') bg-danger
                              @else bg-warning
                              @endif" style="font-size: 14px;">
                              {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                           </span>
                        </div>
                     </div>
                     <div class="card-body">
                        <h5 class="mb-3">Order Items</h5>
                        @foreach($order->items as $item)
                           <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                              <img src="{{ $item->product->images->first() ? \Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_path) : asset('frontend/assets/img/product/default.jpg') }}" 
                                   alt="{{ $item->product_name }}" 
                                   style="width: 100px; height: 100px; object-fit: cover;" 
                                   class="rounded">
                              <div class="ms-3 flex-grow-1">
                                 <h6 class="mb-2">{{ $item->product_name }}</h6>
                                 <p class="text-muted mb-1">
                                    @if($item->color_name)
                                       <strong>Color:</strong> {{ $item->color_name }}<br>
                                    @endif
                                    @if($item->size)
                                       <strong>Size:</strong> {{ $item->size }}<br>
                                    @endif
                                    <strong>Quantity:</strong> {{ $item->quantity }}
                                 </p>
                                 <p class="mb-0">
                                    <strong>Price:</strong> ₹{{ number_format($item->price, 2) }} x {{ $item->quantity }} = 
                                    <strong class="text-primary">₹{{ number_format($item->total, 2) }}</strong>
                                 </p>
                              </div>
                           </div>
                        @endforeach
                     </div>
                  </div>

                  <div class="card shadow-sm">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Shipping Address</h5>
                     </div>
                     <div class="card-body">
                        <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                        <p class="mb-1">{{ $order->shipping_address }}</p>
                        <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p class="mb-3">{{ $order->shipping_country }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $order->email }}</p>
                     </div>
                  </div>
               </div>

               <div class="col-lg-4">
                  <!-- Order Tracking Timeline -->
                  <div class="card shadow-sm mb-4">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Order Tracking</h5>
                     </div>
                     <div class="card-body">
                        @php
                           $statusFlow = [
                              'payment_pending' => ['label' => 'Order Placed', 'icon' => 'fa-shopping-cart'],
                              'paid' => ['label' => 'Payment Confirmed', 'icon' => 'fa-check-circle'],
                              'printing' => ['label' => 'Processing', 'icon' => 'fa-cogs'],
                              'packed' => ['label' => 'Packed', 'icon' => 'fa-box'],
                              'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck'],
                              'delivered' => ['label' => 'Delivered', 'icon' => 'fa-home']
                           ];
                           $currentStatus = $order->order_status;
                           $statusKeys = array_keys($statusFlow);
                           $currentIndex = array_search($currentStatus, $statusKeys);
                           if ($currentIndex === false) $currentIndex = -1;
                        @endphp

                        <div class="order-tracking">
                           @foreach($statusFlow as $status => $info)
                              @php
                                 $stepIndex = array_search($status, $statusKeys);
                                 $isActive = $stepIndex <= $currentIndex;
                                 $isCurrent = $status === $currentStatus;
                              @endphp
                              <div class="tracking-step {{ $isActive ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                 <div class="tracking-icon">
                                    <i class="fa {{ $info['icon'] }}"></i>
                                 </div>
                                 <div class="tracking-content">
                                    <h6 class="mb-0">{{ $info['label'] }}</h6>
                                    @if($isCurrent)
                                       <small class="text-muted">Current Status</small>
                                    @elseif($isActive)
                                       <small class="text-success">Completed</small>
                                    @else
                                       <small class="text-muted">Pending</small>
                                    @endif
                                 </div>
                              </div>
                           @endforeach
                        </div>

                        @if($order->order_status == 'refunded')
                           <div class="alert alert-danger mt-3 mb-0">
                              <i class="fa fa-exclamation-circle"></i> This order has been refunded
                           </div>
                        @elseif($order->order_status == 'refund_requested')
                           <div class="alert alert-warning mt-3 mb-0">
                              <i class="fa fa-clock"></i> Refund requested
                           </div>
                        @endif

                        @if($order->tracking_number)
                           <div class="mt-3 p-3 bg-light rounded">
                              <strong class="d-block mb-2"><i class="fa fa-barcode text-primary"></i> Tracking Number:</strong>
                              <code class="text-primary">{{ $order->tracking_number }}</code>
                              @if($order->shipping_partner)
                                 <div class="mt-2">
                                    <strong>Courier:</strong> {{ $order->shipping_partner }}
                                 </div>
                              @endif
                           </div>
                        @endif
                     </div>
                  </div>

                  <div class="card shadow-sm mb-4">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Order Summary</h5>
                     </div>
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                           <span>Subtotal:</span>
                           <strong>₹{{ number_format($order->subtotal, 2) }}</strong>
                        </div>
                        @if($order->discount_amount > 0)
                           <div class="d-flex justify-content-between mb-2 text-success">
                              <span>Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif:</span>
                              <strong>-₹{{ number_format($order->discount_amount, 2) }}</strong>
                           </div>
                        @endif
                        @if($order->shipping_cost)
                           <div class="d-flex justify-content-between mb-2">
                              <span>Shipping:</span>
                              <strong>₹{{ number_format($order->shipping_cost, 2) }}</strong>
                           </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                           <h5 class="mb-0">Total:</h5>
                           <h5 class="mb-0 text-primary">₹{{ number_format($order->total_amount + ($order->shipping_cost ?? 0), 2) }}</h5>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                           <div class="mb-2">
                              <strong>Payment Method:</strong><br>
                              <span class="badge bg-secondary">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                           </div>
                           <div>
                              <strong>Payment Status:</strong><br>
                              <span class="badge 
                                 @if($order->payment_status == 'paid') bg-success
                                 @elseif($order->payment_status == 'refunded') bg-danger
                                 @else bg-warning
                                 @endif">
                                 {{ ucfirst($order->payment_status) }}
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>

                  <a href="{{ route('orders') }}" class="fill-btn w-100">
                     <i class="fa fa-arrow-left me-2"></i> Back to Orders
                  </a>
               </div>
            </div>
         </div>
      </section>
   </main>

   <style>
      .order-tracking {
         position: relative;
         padding-left: 0;
      }
      .tracking-step {
         position: relative;
         display: flex;
         align-items: flex-start;
         padding: 15px 0;
         padding-left: 50px;
      }
      .tracking-step:not(:last-child):before {
         content: '';
         position: absolute;
         left: 18px;
         top: 40px;
         width: 2px;
         height: calc(100% - 10px);
         background: #e0e0e0;
      }
      .tracking-step.active:not(:last-child):before {
         background: #28a745;
      }
      .tracking-icon {
         position: absolute;
         left: 0;
         width: 36px;
         height: 36px;
         background: #e0e0e0;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 16px;
         color: #fff;
         z-index: 1;
      }
      .tracking-step.active .tracking-icon {
         background: #28a745;
      }
      .tracking-step.current .tracking-icon {
         background: #ffc107;
         animation: pulse 2s infinite;
      }
      @keyframes pulse {
         0%, 100% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
         }
         50% {
            box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
         }
      }
      .tracking-content h6 {
         font-size: 14px;
         font-weight: 600;
         color: #333;
      }
      .tracking-content small {
         font-size: 12px;
      }
   </style>
@endsection
