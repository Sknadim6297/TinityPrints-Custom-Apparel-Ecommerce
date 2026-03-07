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
                              <strong>Placed on:</strong> {{ $order->created_at->format('M d, Y') }}
                              </small>
                              @if($order->delivered_date)
                                 <br>
                                 <small class="text-success">
                                    <strong>Delivered on:</strong> {{ $order->delivered_date->format('M d, Y') }}
                                 </small>
                              @endif
                           </div>
                           <span class="badge 
                              @if($order->order_status == 'delivered') bg-success
                              @elseif($order->order_status == 'shipped') bg-info
                              @elseif($order->order_status == 'paid' || $order->order_status == 'printing' || $order->order_status == 'packed') bg-primary
                              @elseif(in_array($order->order_status, ['refund_completed', 'refunded', 'refund_rejected'])) bg-danger
                              @else bg-warning
                              @endif" style="font-size: 14px;">
                              {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                           </span>
                        </div>
                     </div>
                     <div class="card-body">
                        <h5 class="mb-3">Order Items</h5>
                        @foreach($order->items as $item)
                           @php
                              $productImage = optional(optional($item->product)->images)->first();
                              $designImagePath = optional($order->designRequest)->front_design_file;
                              $itemImageUrl = $productImage
                                 ? \Illuminate\Support\Facades\Storage::url($productImage->image_path)
                                 : ($designImagePath
                                    ? \Illuminate\Support\Facades\Storage::url($designImagePath)
                                    : asset('frontend/assets/img/product/default.jpg'));
                           @endphp
                           <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                              <img src="{{ $itemImageUrl }}" 
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
                           // Order statuses for normal order tracking
                           $orderStatusFlow = [
                              'payment_pending' => ['label' => 'Order Placed', 'icon' => 'fa-shopping-cart'],
                              'paid' => ['label' => 'Payment Confirmed', 'icon' => 'fa-check-circle'],
                              'printing' => ['label' => 'Processing', 'icon' => 'fa-cogs'],
                              'packed' => ['label' => 'Packed', 'icon' => 'fa-box'],
                              'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck'],
                              'delivered' => ['label' => 'Delivered', 'icon' => 'fa-home']
                           ];
                           
                           // Refund statuses for refund tracking  
                           $refundStatusFlow = [
                              'refund_requested' => ['label' => 'Refund Requested', 'icon' => 'fa-exclamation-circle'], 
                              'under_review' => ['label' => 'Under Review', 'icon' => 'fa-search'],
                              'refund_approved' => ['label' => 'Refund Approved', 'icon' => 'fa-thumbs-up'],
                              'refund_rejected' => ['label' => 'Refund Rejected', 'icon' => 'fa-times-circle'],
                              'return_in_process' => ['label' => 'Return In Process', 'icon' => 'fa-reply'],
                              'product_received' => ['label' => 'Product Received', 'icon' => 'fa-inbox'],
                              'refund_completed' => ['label' => 'Refund Completed', 'icon' => 'fa-undo']
                           ];
                           
                           $currentOrderStatus = $order->order_status;
                           $hasActiveRefund = $order->refundRequest && !in_array($order->refundRequest->status, ['refund_rejected', 'refund_completed']);
                           
                           // Determine which tracking flow to show
                           if ($hasActiveRefund || in_array($currentOrderStatus, array_keys($refundStatusFlow))) {
                              // Show refund tracking if there's an active refund
                              $displayStatusFlow = $refundStatusFlow;
                              $currentDisplayStatus = $order->refundRequest ? $order->refundRequest->status : $currentOrderStatus;
                           } else {
                              // Show normal order tracking
                              $displayStatusFlow = $orderStatusFlow;
                              $currentDisplayStatus = $currentOrderStatus;
                           }
                           
                           $statusKeys = array_keys($displayStatusFlow);
                           $currentIndex = array_search($currentDisplayStatus, $statusKeys);
                           if ($currentIndex === false) $currentIndex = -1;
                        @endphp

                        <!-- Order Status Section -->
                        @if(!$hasActiveRefund && !in_array($currentOrderStatus, array_keys($refundStatusFlow)))
                           <div class="order-tracking">
                              @foreach($displayStatusFlow as $status => $info)
                                 @php
                                    $stepIndex = array_search($status, $statusKeys);
                                    $isActive = $stepIndex <= $currentIndex;
                                    $isCurrent = $status === $currentDisplayStatus;
                                    
                                    // Map status to timestamp field
                                    $timestampMap = [
                                       'payment_pending' => $order->placed_at,
                                       'paid' => $order->paid_at,
                                       'printing' => $order->printing_at,
                                       'packed' => $order->packed_at,
                                       'shipped' => $order->shipped_at,
                                       'delivered' => $order->delivered_at,
                                    ];
                                    $timestamp = $timestampMap[$status] ?? null;
                                 @endphp
                                 <div class="tracking-step {{ $isActive ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                    <div class="tracking-icon">
                                       <i class="fa {{ $info['icon'] }}"></i>
                                    </div>
                                    <div class="tracking-content">
                                       <h6 class="mb-0">{{ $info['label'] }}</h6>
                                       @if($timestamp)
                                          <small class="text-muted d-block">{{ $timestamp->format('M d, Y') }}</small>
                                          <small class="text-muted">{{ $timestamp->format('h:i A') }}</small>
                                       @elseif($isCurrent)
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
                        @endif

                        <!-- Refund Status Section -->
                        @if($hasActiveRefund || in_array($currentOrderStatus, array_keys($refundStatusFlow)))
                           <div class="mb-3">
                              <h6 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Refund In Progress</h6>
                           </div>
                           <div class="order-tracking">
                              @foreach($displayStatusFlow as $status => $info)
                                 @php
                                    $stepIndex = array_search($status, $statusKeys);
                                    $isActive = $stepIndex <= $currentIndex;
                                    $isCurrent = $status === $currentDisplayStatus;
                                    
                                    // Map refund status to timestamp field
                                    $timestampMap = [
                                       'cancelled' => $order->cancelled_at,
                                       'refunded' => $order->refunded_at,
                                       'refund_completed' => $order->refunded_at,
                                    ];
                                    $timestamp = $timestampMap[$status] ?? null;
                                 @endphp
                                 <div class="tracking-step {{ $isActive ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                    <div class="tracking-icon">
                                       <i class="fa {{ $info['icon'] }}"></i>
                                    </div>
                                    <div class="tracking-content">
                                       <h6 class="mb-0">{{ $info['label'] }}</h6>
                                       @if($timestamp)
                                          <small class="text-muted">{{ $timestamp->format('M d, Y') }}</small>
                                       @elseif($isCurrent)
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
                        @endif

                        @if($order->refundRequest)
                           <div class="mt-3 p-3 bg-light rounded">
                              <strong class="d-block mb-2">Refund Ticket: {{ $order->refundRequest->ticket_id ?? ('#' . $order->refundRequest->id) }}</strong>
                              <small class="d-block"><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $order->refundRequest->status)) }}</small>
                              @if($order->refundRequest->admin_note)
                                 <small class="d-block mt-1"><strong>Admin Note:</strong> {{ $order->refundRequest->admin_note }}</small>
                              @endif
                           </div>
                        @endif

                        @if($order->refundRequest && $order->refundRequest->status === 'pending_customer_response')
                           <form action="{{ route('orders.refund.respond', $order->refundRequest->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                              @csrf
                              @method('PATCH')
                              <div class="mb-2">
                                 <label class="form-label">Additional Details Requested by Admin</label>
                                 <textarea name="customer_response" class="form-control" rows="3" required></textarea>
                              </div>
                              <div class="mb-2">
                                 <label class="form-label">Upload Additional Evidence (optional)</label>
                                 <input type="file" name="evidence" class="form-control" accept="image/*,video/*">
                              </div>
                              <button type="submit" class="fill-btn btn-sm w-100">Submit Response</button>
                           </form>
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
