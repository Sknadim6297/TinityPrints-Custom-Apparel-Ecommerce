<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>
   <main>
      <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url(<?php echo e(asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg')); ?>);">
         <div class="container container-small">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content">
                     <h3 class="breadcrumb__title">Order Details</h3>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo e(route('home')); ?>">Home</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span><a href="<?php echo e(route('orders')); ?>">My Orders</a></span>
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
                              <h4 class="mb-1">Order #<?php echo e($order->order_number); ?></h4>
                              <small class="text-muted">
                                 <strong>Placed on:</strong> <?php echo e($order->created_at->format('M d, Y \a\t h:i A')); ?>

                              </small>
                              <?php if($order->delivered_date): ?>
                                 <br>
                                 <small class="text-success">
                                    <strong>Delivered on:</strong> <?php echo e($order->delivered_date->format('M d, Y \a\t h:i A')); ?>

                                 </small>
                              <?php endif; ?>
                           </div>
                           <span class="badge 
                              <?php if($order->order_status == 'delivered'): ?> bg-success
                              <?php elseif($order->order_status == 'shipped'): ?> bg-info
                              <?php elseif($order->order_status == 'paid' || $order->order_status == 'printing' || $order->order_status == 'packed'): ?> bg-primary
                              <?php elseif(in_array($order->order_status, ['refund_completed', 'refunded', 'refund_rejected'])): ?> bg-danger
                              <?php else: ?> bg-warning
                              <?php endif; ?>" style="font-size: 14px;">
                              <?php echo e(ucwords(str_replace('_', ' ', $order->order_status))); ?>

                           </span>
                        </div>
                     </div>
                     <div class="card-body">
                        <h5 class="mb-3">Order Items</h5>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php
                              $productImage = optional(optional($item->product)->images)->first();
                              $designImagePath = optional($order->designRequest)->front_design_file;
                              $itemImageUrl = $productImage
                                 ? \Illuminate\Support\Facades\Storage::url($productImage->image_path)
                                 : ($designImagePath
                                    ? \Illuminate\Support\Facades\Storage::url($designImagePath)
                                    : asset('frontend/assets/img/product/default.jpg'));
                           ?>
                           <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                              <img src="<?php echo e($itemImageUrl); ?>" 
                                   alt="<?php echo e($item->product_name); ?>" 
                                   style="width: 100px; height: 100px; object-fit: cover;" 
                                   class="rounded">
                              <div class="ms-3 flex-grow-1">
                                 <h6 class="mb-2"><?php echo e($item->product_name); ?></h6>
                                 <p class="text-muted mb-1">
                                    <?php if($item->color_name): ?>
                                       <strong>Color:</strong> <?php echo e($item->color_name); ?><br>
                                    <?php endif; ?>
                                    <?php if($item->size): ?>
                                       <strong>Size:</strong> <?php echo e($item->size); ?><br>
                                    <?php endif; ?>
                                    <strong>Quantity:</strong> <?php echo e($item->quantity); ?>

                                 </p>
                                 <p class="mb-0">
                                    <strong>Price:</strong> ₹<?php echo e(number_format($item->price, 2)); ?> x <?php echo e($item->quantity); ?> = 
                                    <strong class="text-primary">₹<?php echo e(number_format($item->total, 2)); ?></strong>
                                 </p>
                              </div>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>

                  <div class="card shadow-sm">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Shipping Address</h5>
                     </div>
                     <div class="card-body">
                        <p class="mb-1"><strong><?php echo e($order->customer_name); ?></strong></p>
                        <p class="mb-1"><?php echo e($order->shipping_address); ?></p>
                        <p class="mb-1"><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?></p>
                        <p class="mb-3"><?php echo e($order->shipping_country); ?></p>
                        <p class="mb-1"><strong>Phone:</strong> <?php echo e($order->phone); ?></p>
                        <p class="mb-0"><strong>Email:</strong> <?php echo e($order->email); ?></p>
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
                        <?php
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
                        ?>

                        <!-- Order Status Section -->
                        <?php if(!$hasActiveRefund && !in_array($currentOrderStatus, array_keys($refundStatusFlow))): ?>
                           <div class="order-tracking">
                              <?php $__currentLoopData = $displayStatusFlow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php
                                    $stepIndex = array_search($status, $statusKeys);
                                    $isActive = $stepIndex <= $currentIndex;
                                    $isCurrent = $status === $currentDisplayStatus;
                                 ?>
                                 <div class="tracking-step <?php echo e($isActive ? 'active' : ''); ?> <?php echo e($isCurrent ? 'current' : ''); ?>">
                                    <div class="tracking-icon">
                                       <i class="fa <?php echo e($info['icon']); ?>"></i>
                                    </div>
                                    <div class="tracking-content">
                                       <h6 class="mb-0"><?php echo e($info['label']); ?></h6>
                                       <?php if($isCurrent): ?>
                                          <small class="text-muted">Current Status</small>
                                       <?php elseif($isActive): ?>
                                          <small class="text-success">Completed</small>
                                       <?php else: ?>
                                          <small class="text-muted">Pending</small>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                        <?php endif; ?>

                        <!-- Refund Status Section -->
                        <?php if($hasActiveRefund || in_array($currentOrderStatus, array_keys($refundStatusFlow))): ?>
                           <div class="mb-3">
                              <h6 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Refund In Progress</h6>
                           </div>
                           <div class="order-tracking">
                              <?php $__currentLoopData = $displayStatusFlow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php
                                    $stepIndex = array_search($status, $statusKeys);
                                    $isActive = $stepIndex <= $currentIndex;
                                    $isCurrent = $status === $currentDisplayStatus;
                                 ?>
                                 <div class="tracking-step <?php echo e($isActive ? 'active' : ''); ?> <?php echo e($isCurrent ? 'current' : ''); ?>">
                                    <div class="tracking-icon">
                                       <i class="fa <?php echo e($info['icon']); ?>"></i>
                                    </div>
                                    <div class="tracking-content">
                                       <h6 class="mb-0"><?php echo e($info['label']); ?></h6>
                                       <?php if($isCurrent): ?>
                                          <small class="text-muted">Current Status</small>
                                       <?php elseif($isActive): ?>
                                          <small class="text-success">Completed</small>
                                       <?php else: ?>
                                          <small class="text-muted">Pending</small>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                        <?php endif; ?>

                        <?php if($order->refundRequest): ?>
                           <div class="mt-3 p-3 bg-light rounded">
                              <strong class="d-block mb-2">Refund Ticket: <?php echo e($order->refundRequest->ticket_id ?? ('#' . $order->refundRequest->id)); ?></strong>
                              <small class="d-block"><strong>Status:</strong> <?php echo e(ucwords(str_replace('_', ' ', $order->refundRequest->status))); ?></small>
                              <?php if($order->refundRequest->admin_note): ?>
                                 <small class="d-block mt-1"><strong>Admin Note:</strong> <?php echo e($order->refundRequest->admin_note); ?></small>
                              <?php endif; ?>
                           </div>
                        <?php endif; ?>

                        <?php if($order->refundRequest && $order->refundRequest->status === 'pending_customer_response'): ?>
                           <form action="<?php echo e(route('orders.refund.respond', $order->refundRequest->id)); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                              <?php echo csrf_field(); ?>
                              <?php echo method_field('PATCH'); ?>
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
                        <?php endif; ?>

                        <?php if($order->tracking_number): ?>
                           <div class="mt-3 p-3 bg-light rounded">
                              <strong class="d-block mb-2"><i class="fa fa-barcode text-primary"></i> Tracking Number:</strong>
                              <code class="text-primary"><?php echo e($order->tracking_number); ?></code>
                              <?php if($order->shipping_partner): ?>
                                 <div class="mt-2">
                                    <strong>Courier:</strong> <?php echo e($order->shipping_partner); ?>

                                 </div>
                              <?php endif; ?>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>

                  <div class="card shadow-sm mb-4">
                     <div class="card-header bg-white">
                        <h5 class="mb-0">Order Summary</h5>
                     </div>
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                           <span>Subtotal:</span>
                           <strong>₹<?php echo e(number_format($order->subtotal, 2)); ?></strong>
                        </div>
                        <?php if($order->discount_amount > 0): ?>
                           <div class="d-flex justify-content-between mb-2 text-success">
                              <span>Discount <?php if($order->coupon_code): ?>(<?php echo e($order->coupon_code); ?>)<?php endif; ?>:</span>
                              <strong>-₹<?php echo e(number_format($order->discount_amount, 2)); ?></strong>
                           </div>
                        <?php endif; ?>
                        <?php if($order->shipping_cost): ?>
                           <div class="d-flex justify-content-between mb-2">
                              <span>Shipping:</span>
                              <strong>₹<?php echo e(number_format($order->shipping_cost, 2)); ?></strong>
                           </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                           <h5 class="mb-0">Total:</h5>
                           <h5 class="mb-0 text-primary">₹<?php echo e(number_format($order->total_amount + ($order->shipping_cost ?? 0), 2)); ?></h5>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                           <div class="mb-2">
                              <strong>Payment Method:</strong><br>
                              <span class="badge bg-secondary"><?php echo e(strtoupper(str_replace('_', ' ', $order->payment_method))); ?></span>
                           </div>
                           <div>
                              <strong>Payment Status:</strong><br>
                              <span class="badge 
                                 <?php if($order->payment_status == 'paid'): ?> bg-success
                                 <?php elseif($order->payment_status == 'refunded'): ?> bg-danger
                                 <?php else: ?> bg-warning
                                 <?php endif; ?>">
                                 <?php echo e(ucfirst($order->payment_status)); ?>

                              </span>
                           </div>
                        </div>
                     </div>
                  </div>

                  <a href="<?php echo e(route('orders')); ?>" class="fill-btn w-100">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\order-details.blade.php ENDPATH**/ ?>