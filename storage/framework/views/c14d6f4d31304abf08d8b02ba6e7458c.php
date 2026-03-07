<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<main>
   <!-- Breadcrumb Start -->
   <section class="page-title-area" data-background="<?php echo e(asset('frontend/assets/img/banner/banner-1-1.jpg')); ?>">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="page-title-wrapper text-center">
                  <h1 class="page-title mb-10">Checkout</h1>
                  <div class="breadcrumb-menu">
                     <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items">
                           <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
                           <li class="trail-item trail-end"><span>Checkout</span></li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Breadcrumb End -->

   <!-- Breadcrumb End -->

   <!-- Checkout Area Start -->
   <section class="checkout-area pt-100 pb-100">
      <div class="container">
         <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <?php echo e(session('error')); ?>

               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         <?php endif; ?>

         <form action="<?php echo e(route('checkout.store')); ?>" method="POST" id="checkoutForm">
            <?php echo csrf_field(); ?>
            <div class="row">
               <div class="col-lg-7">
                  <!-- Saved Addresses Section -->
                  <?php if($savedAddresses->count() > 0): ?>
                     <div class="checkout-billing-details-wrap mb-30">
                        <h5 class="checkout-title">Select Delivery Address</h5>
                        <div class="saved-addresses-list">
                           <?php $__currentLoopData = $savedAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="address-card mb-3 <?php if($address->is_default): ?> border-primary <?php endif; ?>">
                                 <div class="form-check">
                                    <input class="form-check-input saved-address-radio" type="radio" 
                                           name="address_id" id="address_<?php echo e($address->id); ?>" 
                                           value="<?php echo e($address->id); ?>" 
                                           data-name="<?php echo e($address->full_name); ?>"
                                           data-phone="<?php echo e($address->phone); ?>"
                                           data-email="<?php echo e(auth()->user()->email); ?>"
                                           data-address="<?php echo e($address->address); ?>"
                                           data-landmark="<?php echo e($address->landmark); ?>"
                                           data-city="<?php echo e($address->city); ?>"
                                           data-state="<?php echo e($address->state); ?>"
                                           data-postal="<?php echo e($address->postal_code); ?>"
                                           data-country="<?php echo e($address->country); ?>"
                                           <?php if($address->is_default): ?> checked <?php endif; ?>>
                                    <label class="form-check-label w-100" for="address_<?php echo e($address->id); ?>">
                                       <div class="d-flex justify-content-between align-items-start">
                                          <div>
                                             <strong><?php echo e($address->full_name); ?></strong>
                                             <?php if($address->label): ?>
                                                <span class="badge bg-secondary ms-2"><?php echo e($address->label); ?></span>
                                             <?php endif; ?>
                                             <?php if($address->is_default): ?>
                                                <span class="badge bg-success ms-1">Default</span>
                                             <?php endif; ?>
                                             <p class="mb-1 mt-2"><?php echo e($address->address); ?></p>
                                             <?php if($address->landmark): ?>
                                                <p class="mb-1 text-muted small"><i class="fal fa-map-marker-alt"></i> Landmark: <?php echo e($address->landmark); ?></p>
                                             <?php endif; ?>
                                             <p class="mb-1"><?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->postal_code); ?></p>
                                             <p class="mb-0"><?php echo e($address->country); ?></p>
                                             <p class="mb-0 text-muted small"><i class="fal fa-phone"></i> <?php echo e($address->phone); ?></p>
                                          </div>
                                       </div>
                                    </label>
                                 </div>
                              </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button type="button" class="border-btn mt-3" data-bs-toggle="collapse" data-bs-target="#newAddressForm">
                           <i class="fal fa-plus"></i> Add New Address
                        </button>
                     </div>
                  <?php endif; ?>

                  <!-- New Address Form -->
                  <div class="checkout-billing-details-wrap <?php if($savedAddresses->count() > 0): ?> collapse <?php endif; ?>" id="newAddressForm">
                     <h5 class="checkout-title">
                        <?php if($savedAddresses->count() > 0): ?>
                           Add New Delivery Address
                        <?php else: ?>
                           Delivery Address
                        <?php endif; ?>
                     </h5>
                     <div class="billing-form-wrap">
                        <div class="row">
                           <div class="col-md-12 mb-20">
                              <label for="customer_name">Full Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="customer_name" name="customer_name" 
                                     value="<?php echo e(old('customer_name', auth()->user()->name)); ?>" required>
                              <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="phone">Phone Number <span class="text-danger">*</span></label>
                              <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="phone" name="phone" 
                                     value="<?php echo e(old('phone', auth()->user()->phone)); ?>" required>
                              <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="email">Email Address <span class="text-danger">*</span></label>
                              <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="email" name="email" 
                                     value="<?php echo e(old('email', auth()->user()->email)); ?>" required>
                              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-12 mb-20">
                              <label for="shipping_address">Address (House No, Building, Street) <span class="text-danger">*</span></label>
                              <textarea class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="shipping_address" name="shipping_address" 
                                        rows="2" required><?php echo e(old('shipping_address')); ?></textarea>
                              <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-12 mb-20">
                              <label for="landmark">Landmark (Optional)</label>
                              <input type="text" class="form-control <?php $__errorArgs = ['landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="landmark" name="landmark" 
                                     placeholder="E.g., Near City Mall, Behind XYZ School"
                                     value="<?php echo e(old('landmark')); ?>">
                              <?php $__errorArgs = ['landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="shipping_city">City / District <span class="text-danger">*</span></label>
                              <input type="text" class="form-control <?php $__errorArgs = ['shipping_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="shipping_city" name="shipping_city" 
                                     value="<?php echo e(old('shipping_city')); ?>" required>
                              <?php $__errorArgs = ['shipping_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="shipping_state">State / Province</label>
                              <input type="text" class="form-control <?php $__errorArgs = ['shipping_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="shipping_state" name="shipping_state" 
                                     value="<?php echo e(old('shipping_state')); ?>">
                              <?php $__errorArgs = ['shipping_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="shipping_postal_code">Postal / Zip Code</label>
                              <input type="text" class="form-control <?php $__errorArgs = ['shipping_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="shipping_postal_code" name="shipping_postal_code" 
                                     value="<?php echo e(old('shipping_postal_code')); ?>">
                              <?php $__errorArgs = ['shipping_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <div class="col-md-6 mb-20">
                              <label for="shipping_country">Country <span class="text-danger">*</span></label>
                              <input type="text" class="form-control <?php $__errorArgs = ['shipping_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                     id="shipping_country" name="shipping_country" 
                                     value="<?php echo e(old('shipping_country', 'India')); ?>" required>
                              <?php $__errorArgs = ['shipping_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                 <div class="invalid-feedback"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>

                           <!-- Save Address Options -->
                           <div class="col-md-12 mb-20">
                              <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="save_address" name="save_address" value="1">
                                 <label class="form-check-label" for="save_address">
                                    Save this address for future orders
                                 </label>
                              </div>
                           </div>

                           <div class="col-md-12 mb-20" id="address_options" style="display: none;">
                              <div class="row">
                                 <div class="col-md-6 mb-10">
                                    <label for="address_label">Label this address as</label>
                                    <select class="form-control" id="address_label" name="address_label">
                                       <option value="Home">Home</option>
                                       <option value="Office">Office</option>
                                       <option value="Other">Other</option>
                                    </select>
                                 </div>
                                 <div class="col-md-6 mb-10">
                                    <div class="form-check mt-4">
                                       <input class="form-check-input" type="checkbox" id="set_default" name="set_default" value="1">
                                       <label class="form-check-label" for="set_default">
                                          Set as default address
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Payment Method -->
                  <div class="checkout-payment-method mt-30">
                     <h5 class="checkout-title">Payment Method</h5>
                     <div class="payment-method-wrapper">
                        <!-- Cash on Delivery -->
                        <div class="payment-option-card">
                           <input type="radio" class="payment-radio" id="cod" name="payment_method" value="cod" 
                                  <?php echo e(old('payment_method', 'cod') == 'cod' ? 'checked' : ''); ?> required>
                           <label for="cod" class="payment-option-label">
                              <div class="payment-icon">
                                 <i class="fal fa-money-bill-wave"></i>
                              </div>
                              <div class="payment-content">
                                 <span class="payment-title">Cash on Delivery</span>
                                 <span class="payment-subtitle">Pay when you receive your order</span>
                              </div>
                              <div class="payment-check">
                                 <i class="fal fa-check-circle"></i>
                              </div>
                           </label>
                        </div>

                        <!-- Online Payment -->
                        <div class="payment-option-card">
                           <input type="radio" class="payment-radio" id="online" name="payment_method" value="online"
                                  <?php echo e(old('payment_method') == 'online' ? 'checked' : ''); ?>>
                           <label for="online" class="payment-option-label">
                              <div class="payment-icon">
                                 <i class="fal fa-credit-card"></i>
                              </div>
                              <div class="payment-content">
                                 <span class="payment-title">Online Payment</span>
                                 <span class="payment-subtitle">Pay via Card/UPI/Wallet</span>
                              </div>
                              <div class="payment-check">
                                 <i class="fal fa-check-circle"></i>
                              </div>
                           </label>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="payment-option-card">
                           <input type="radio" class="payment-radio" id="bank_transfer" name="payment_method" value="bank_transfer"
                                  <?php echo e(old('payment_method') == 'bank_transfer' ? 'checked' : ''); ?>>
                           <label for="bank_transfer" class="payment-option-label">
                              <div class="payment-icon">
                                 <i class="fal fa-university"></i>
                              </div>
                              <div class="payment-content">
                                 <span class="payment-title">Bank Transfer</span>
                                 <span class="payment-subtitle">Direct bank transfer</span>
                              </div>
                              <div class="payment-check">
                                 <i class="fal fa-check-circle"></i>
                              </div>
                           </label>
                        </div>

                        <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                           <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                  </div>
               </div>

               <!-- Order Summary Sidebar -->
               <div class="col-lg-5">
                  <div class="checkout-order-summary-wrap">
                     <h5 class="checkout-title">Order Summary</h5>
                     <div class="checkout-product-list">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="checkout-product-item">
                              <div class="product-thumbnail">
                                 <?php if($item->product->images->first()): ?>
                                    <img src="<?php echo e(Storage::url($item->product->images->first()->image_path)); ?>" 
                                         alt="<?php echo e($item->product->name); ?>">
                                 <?php else: ?>
                                    <img src="<?php echo e(asset('frontend/assets/img/product/product-img1.jpg')); ?>" 
                                         alt="<?php echo e($item->product->name); ?>">
                                 <?php endif; ?>
                              </div>
                              <div class="product-info">
                                 <h6><?php echo e($item->product->name); ?></h6>
                                 <p class="product-variant">
                                    <?php if($item->color): ?>
                                       Color: <?php echo e($item->color->color_name); ?>

                                    <?php endif; ?>
                                    <?php if($item->size): ?>
                                       <?php if($item->color): ?> | <?php endif; ?> Size: <?php echo e($item->size); ?>

                                    <?php endif; ?>
                                 </p>
                                 <p class="product-quantity">Qty: <?php echo e($item->quantity); ?></p>
                              </div>
                              <div class="product-price">
                                 <strong>₹<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?></strong>
                              </div>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>

                     <div class="order-total-wrap">
                        <div class="order-total-item">
                           <span>Subtotal:</span>
                           <strong>₹<?php echo e(number_format($subtotal, 2)); ?></strong>
                        </div>

                        <?php if($discountAmount > 0): ?>
                           <div class="order-total-item discount">
                              <span>Discount (<?php echo e($couponCode); ?>):</span>
                              <strong>-₹<?php echo e(number_format(abs($discountAmount), 2)); ?></strong>
                           </div>
                        <?php endif; ?>

                        <div class="order-total-item total">
                           <span>Total:</span>
                           <strong class="total-amount">₹<?php echo e(number_format($total, 2)); ?></strong>
                        </div>
                     </div>

                     <button type="submit" class="fill-btn w-100 mt-4">
                        <i class="fal fa-lock me-2"></i> Place Order
                     </button>

                     <p class="text-center text-muted small mt-3 mb-0">
                        <i class="fal fa-shield-alt me-1"></i> Your information is secure with us
                     </p>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </section>
   <!-- Checkout Area End -->

   <style>
      .address-card {
         border: 2px solid #e5e5e5;
         border-radius: 8px;
         padding: 15px;
         transition: all 0.3s ease;
      }
      .address-card:hover {
         border-color: #ffc107;
         box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      .address-card.border-primary {
         border-color: #ffc107;
         background-color: #fffbf0;
      }
      .saved-address-radio:checked ~ label {
         color: #333;
      }
      .payment-option-card {
         position: relative;
         margin-bottom: 15px;
      }
      .payment-radio {
         position: absolute;
         opacity: 0;
         cursor: pointer;
      }
      .payment-option-label {
         display: flex;
         align-items: center;
         gap: 15px;
         padding: 20px;
         border: 2px solid #e5e5e5;
         border-radius: 12px;
         cursor: pointer;
         transition: all 0.3s ease;
         background: #fff;
         position: relative;
      }
      .payment-radio:checked + .payment-option-label {
         border-color: #ffc107;
         background: linear-gradient(135deg, #fffbf0 0%, #fff 100%);
         box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
      }
      .payment-option-label:hover {
         border-color: #ffc107;
         box-shadow: 0 2px 10px rgba(255, 193, 7, 0.1);
      }
      .payment-icon {
         width: 60px;
         height: 60px;
         display: flex;
         align-items: center;
         justify-content: center;
         background: linear-gradient(135deg, #ffc107, #ffb300);
         border-radius: 10px;
         color: white;
         font-size: 28px;
         flex-shrink: 0;
      }
      .payment-radio:checked + .payment-option-label .payment-icon {
         box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
      }
      .payment-content {
         flex: 1;
      }
      .payment-title {
         display: block;
         font-weight: 700;
         font-size: 16px;
         color: #333;
         margin-bottom: 4px;
      }
      .payment-subtitle {
         display: block;
         font-size: 13px;
         color: #999;
      }
      .payment-radio:checked + .payment-option-label .payment-subtitle {
         color: #666;
      }
      .payment-check {
         width: 28px;
         height: 28px;
         border-radius: 50%;
         background: #e5e5e5;
         display: flex;
         align-items: center;
         justify-content: center;
         color: transparent;
         transition: all 0.3s ease;
         flex-shrink: 0;
      }
      .payment-radio:checked + .payment-option-label .payment-check {
         background: #ffc107;
         color: white;
      }
      .checkout-product-item {
         display: flex;
         gap: 15px;
         padding: 15px 0;
         border-bottom: 1px solid #e5e5e5;
      }
      .checkout-product-item:last-child {
         border-bottom: none;
      }
      .checkout-product-item .product-thumbnail img {
         width: 70px;
         height: 70px;
         object-fit: cover;
         border-radius: 5px;
      }
      .checkout-product-item .product-info {
         flex: 1;
      }
      .checkout-product-item .product-info h6 {
         font-size: 14px;
         margin-bottom: 5px;
      }
      .checkout-product-item .product-variant,
      .checkout-product-item .product-quantity {
         font-size: 12px;
         color: #666;
         margin-bottom: 3px;
      }
      .order-total-wrap {
         border-top: 2px solid #e5e5e5;
         margin-top: 20px;
         padding-top: 20px;
      }
      .order-total-item {
         display: flex;
         justify-content: space-between;
         margin-bottom: 15px;
         font-size: 15px;
      }
      .order-total-item.discount {
         color: #28a745;
      }
      .order-total-item.total {
         font-size: 18px;
         font-weight: 600;
         padding-top: 15px;
         border-top: 1px solid #e5e5e5;
      }
      .order-total-item.total .total-amount {
         color: #ffc107;
      }
      .checkout-order-summary-wrap {
         background: #f8f9fa;
         padding: 25px;
         border-radius: 10px;
         position: sticky;
         top: 100px;
      }
      .checkout-billing-details-wrap,
      .checkout-payment-method {
         background: #fff;
         padding: 25px;
         border-radius: 10px;
         box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      }
      .checkout-title {
         font-size: 20px;
         font-weight: 600;
         margin-bottom: 20px;
         padding-bottom: 15px;
         border-bottom: 2px solid #e5e5e5;
      }
   </style>

   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Handle save address checkbox
         const saveAddressCheckbox = document.getElementById('save_address');
         const addressOptions = document.getElementById('address_options');
         
         if (saveAddressCheckbox) {
            saveAddressCheckbox.addEventListener('change', function() {
               addressOptions.style.display = this.checked ? 'block' : 'none';
            });
         }

         // Handle saved address selection
         const savedAddressRadios = document.querySelectorAll('.saved-address-radio');
         savedAddressRadios.forEach(radio => {
            radio.addEventListener('change', function() {
               if (this.checked) {
                  // Fill form fields with selected address data
                  document.getElementById('customer_name').value = this.dataset.name;
                  document.getElementById('phone').value = this.dataset.phone;
                  document.getElementById('email').value = this.dataset.email;
                  document.getElementById('shipping_address').value = this.dataset.address;
                  document.getElementById('landmark').value = this.dataset.landmark || '';
                  document.getElementById('shipping_city').value = this.dataset.city;
                  document.getElementById('shipping_state').value = this.dataset.state || '';
                  document.getElementById('shipping_postal_code').value = this.dataset.postal || '';
                  document.getElementById('shipping_country').value = this.dataset.country;

                  // Collapse new address form if expanded
                  const newAddressForm = document.getElementById('newAddressForm');
                  if (newAddressForm && newAddressForm.classList.contains('show')) {
                     const bsCollapse = new bootstrap.Collapse(newAddressForm, { toggle: true });
                  }
               }
            });
         });

         // Trigger change on default selected address
         const defaultAddress = document.querySelector('.saved-address-radio:checked');
         if (defaultAddress) {
            defaultAddress.dispatchEvent(new Event('change'));
         }
      });
   </script>

   </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\checkout.blade.php ENDPATH**/ ?>