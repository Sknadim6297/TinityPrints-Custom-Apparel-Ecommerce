@extends('frontend.layout.app')

@section('title', 'My Orders')

@section('content')
   <main>
      <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url({{ asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg') }});">
         <div class="container container-small">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content">
                     <h3 class="breadcrumb__title">My Orders</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>My Orders</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="pt-100 pb-100">
         <div class="container container-small">
            @if(session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
            @endif

            @if($errors->has('refund') || $errors->has('reason_code') || $errors->has('description') || $errors->has('evidence'))
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $errors->first('refund') ?: $errors->first('reason_code') ?: $errors->first('description') ?: $errors->first('evidence') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
            @endif

            <div class="row">
               <div class="col-12">
                  <h3 class="mb-4">My Orders</h3>

                  @if($orders->isEmpty())
                     <div class="card">
                        <div class="card-body text-center py-5">
                           <i class="fa fa-shopping-bag text-muted mb-3" style="font-size: 60px;"></i>
                           <h4 class="text-muted">No orders yet</h4>
                           <p class="text-muted mb-4">Start shopping to create your first order!</p>
                           <a href="{{ route('shop') }}" class="fill-btn">Start Shopping</a>
                        </div>
                     </div>
                  @else
                     @foreach($orders as $order)
                        <div class="card mb-4 shadow-sm">
                           <div class="card-header bg-white">
                              <div class="row align-items-center">
                                 <div class="col-md-6">
                                    <h5 class="mb-1">
                                       Order #{{ $order->order_number }}
                                    </h5>
                                    <small class="text-muted">
                                       <i class="fa fa-calendar me-1"></i>
                                            Placed on {{ $order->created_at->format('M d, Y') }}
                                    </small>
                                 </div>
                                 <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                    <h4 class="mb-2 text-primary">₹{{ number_format($order->total_amount, 2) }}</h4>
                                    
                                    <!-- Order Status Badge -->
                                    @php
                                       $statusConfig = [
                                          'delivered' => ['badge' => 'success', 'icon' => 'fa-check-circle', 'text' => 'Delivered'],
                                          'shipped' => ['badge' => 'info', 'icon' => 'fa-truck', 'text' => 'Shipped'],
                                          'packed' => ['badge' => 'primary', 'icon' => 'fa-box', 'text' => 'Packed'],
                                          'printing' => ['badge' => 'primary', 'icon' => 'fa-cogs', 'text' => 'Printing'],
                                          'paid' => ['badge' => 'success', 'icon' => 'fa-check', 'text' => 'Confirmed'],
                                          'payment_pending' => ['badge' => 'warning', 'icon' => 'fa-clock', 'text' => 'Pending Payment'],
                                          'under_review' => ['badge' => 'primary', 'icon' => 'fa-search', 'text' => 'Under Review'],
                                          'refund_approved' => ['badge' => 'success', 'icon' => 'fa-thumbs-up', 'text' => 'Refund Approved'],
                                          'refund_rejected' => ['badge' => 'danger', 'icon' => 'fa-times-circle', 'text' => 'Refund Rejected'],
                                          'return_in_process' => ['badge' => 'info', 'icon' => 'fa-reply', 'text' => 'Return In Process'],
                                          'product_received' => ['badge' => 'secondary', 'icon' => 'fa-inbox', 'text' => 'Product Received'],
                                          'refund_completed' => ['badge' => 'danger', 'icon' => 'fa-undo', 'text' => 'Refund Completed'],
                                          'refunded' => ['badge' => 'danger', 'icon' => 'fa-undo', 'text' => 'Refund Completed'],
                                          'refund_requested' => ['badge' => 'warning', 'icon' => 'fa-exclamation', 'text' => 'Refund Requested'],
                                       ];
                                       $config = $statusConfig[$order->order_status] ?? ['badge' => 'secondary', 'icon' => 'fa-circle', 'text' => ucwords(str_replace('_', ' ', $order->order_status))];
                                    @endphp
                                    <span class="badge bg-{{ $config['badge'] }}">
                                       <i class="fa {{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                    </span>

                                    @if($order->tracking_number)
                                       <div class="mt-1">
                                          <small class="text-muted">
                                             <i class="fa fa-barcode"></i> {{ $order->tracking_number }}
                                          </small>
                                       </div>
                                    @endif
                                 </div>
                              </div>

                              <!-- Quick Order Progress -->
                              @php
                                 $progressSteps = [
                                    'payment_pending' => 20,
                                    'paid' => 40,
                                    'printing' => 60,
                                    'packed' => 70,
                                    'shipped' => 85,
                                    'delivered' => 100,
                                    'refund_requested' => 20,
                                    'under_review' => 35,
                                    'refund_approved' => 55,
                                    'refund_rejected' => 100,
                                    'return_in_process' => 70,
                                    'product_received' => 85,
                                    'refund_completed' => 100,
                                    'refunded' => 100,
                                 ];
                                 $progress = $progressSteps[$order->order_status] ?? 10;
                              @endphp
                              <div class="mt-3">
                                 <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Order Progress</small>
                                    <small class="text-muted fw-bold">{{ $progress }}%</small>
                                 </div>
                                 <div class="progress" style="height: 6px;">
                                    <div class="progress-bar 
                                       @if($order->order_status == 'delivered') bg-success
                                       @elseif($order->order_status == 'refunded') bg-danger
                                       @else bg-primary
                                       @endif" 
                                       role="progressbar" 
                                       style="width: {{ $progress }}%;" 
                                       aria-valuenow="{{ $progress }}" 
                                       aria-valuemin="0" 
                                       aria-valuemax="100">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-8">
                                    <h6 class="mb-3">Order Items</h6>
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
                                               style="width: 80px; height: 80px; object-fit: cover;" 
                                               class="rounded">
                                          <div class="ms-3 flex-grow-1">
                                             <h6 class="mb-1">{{ $item->product_name }}</h6>
                                             <p class="text-muted small mb-1">
                                                @if($item->color_name)
                                                   Color: {{ $item->color_name }} |
                                                @endif
                                                @if($item->size)
                                                   Size: {{ $item->size }} |
                                                @endif
                                                Quantity: {{ $item->quantity }}
                                             </p>
                                             <p class="mb-0"><strong>₹{{ number_format($item->price, 2) }}</strong> x {{ $item->quantity }} = <strong>₹{{ number_format($item->total, 2) }}</strong></p>
                                          </div>
                                       </div>
                                    @endforeach
                                 </div>
                                 <div class="col-md-4">
                                    <h6 class="mb-3">Order Information</h6>
                                    <div class="mb-3">
                                       <strong>Payment Method:</strong><br>
                                       <span class="text-capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                    </div>
                                    <div class="mb-3">
                                       <strong>Payment Status:</strong><br>
                                       <span class="badge 
                                          @if($order->payment_status == 'paid') bg-success
                                          @elseif($order->payment_status == 'refunded') bg-danger
                                          @else bg-warning
                                          @endif">
                                          {{ ucfirst($order->payment_status) }}
                                       </span>
                                    </div>
                                    <div class="mb-3">
                                       <strong>Shipping Address:</strong><br>
                                       <small>{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</small>
                                    </div>
                                    @if($order->tracking_number)
                                       <div class="mb-3">
                                          <strong>Tracking Number:</strong><br>
                                          <span class="text-primary">{{ $order->tracking_number }}</span>
                                       </div>
                                    @endif
                                    @if($order->discount_amount > 0)
                                       <div class="mb-3">
                                          <strong>Discount Applied:</strong><br>
                                          <span class="text-success">-₹{{ number_format($order->discount_amount, 2) }}</span>
                                          @if($order->coupon_code)
                                             <br><small>({{ $order->coupon_code }})</small>
                                          @endif
                                       </div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="card-footer bg-white">
                              <div class="d-flex justify-content-between align-items-center">
                                 <div>
                                    <strong>Total:</strong> <span class="text-primary fs-5">₹{{ number_format($order->total_amount, 2) }}</span>
                                 </div>
                                 <div>
                                    @if($order->refundRequest)
                                       <div class="text-end mb-2">
                                          <small class="text-muted d-block">Refund Ticket: <strong>{{ $order->refundRequest->ticket_id ?? ('#' . $order->refundRequest->id) }}</strong></small>
                                          <small class="text-muted d-block">Refund Status: <strong>{{ ucwords(str_replace('_', ' ', $order->refundRequest->status)) }}</strong></small>
                                       </div>
                                    @endif
                                    <a href="{{ route('order.details', $order->id) }}" class="fill-btn btn-sm">
                                       <i class="fa fa-eye me-1"></i> View Details
                                    </a>
                                 </div>
                              </div>

                              @php
                                 $hasActiveRefund = $order->refundRequest && $order->refundRequest->status !== 'refund_rejected';
                                 $canRequestRefund = !$hasActiveRefund && in_array($order->order_status, ['delivered', 'printing', 'packed', 'shipped', 'paid', 'payment_pending']);
                              @endphp

                              @if($canRequestRefund)
                                 <hr>
                                 <h6 class="mb-3"><i class="fa fa-undo me-1"></i> Request Refund</h6>
                                 <form action="{{ route('orders.refund.request', $order->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-4">
                                       <label class="form-label">Select Reason</label>
                                       <select name="reason_code" class="form-select" required>
                                          <option value="">Choose reason</option>
                                          <option value="defect">Product Defect</option>
                                          <option value="damaged">Damaged on Delivery</option>
                                          <option value="wrong_item">Wrong Item Delivered</option>
                                          <option value="quality_issue">Quality Issue</option>
                                          <option value="size_issue">Size/Fit Issue</option>
                                          <option value="changed_mind">Changed Mind</option>
                                          <option value="other">Other</option>
                                       </select>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="form-label">Upload Image / Video</label>
                                       <input type="file" name="evidence" class="form-control" accept="image/*,video/*" required>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="form-label">Short Description</label>
                                       <input type="text" name="description" class="form-control" maxlength="1500" required placeholder="Describe the issue briefly">
                                    </div>
                                    <div class="col-12 text-end">
                                       <button type="submit" class="fill-btn btn-sm">
                                          <i class="fa fa-paper-plane me-1"></i> Submit Refund Request
                                       </button>
                                    </div>
                                 </form>
                              @endif
                           </div>
                        </div>
                     @endforeach

                     <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </section>
   </main>
@endsection
