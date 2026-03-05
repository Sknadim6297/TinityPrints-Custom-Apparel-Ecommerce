

<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
   <main>
      <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height d-flex align-items-center p-relative" style="background-image:url(<?php echo e(asset('frontend/assets/img/breadcurmb/breadcrumb-1.jpg')); ?>);">
         <div class="container container-small">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content">
                     <h3 class="breadcrumb__title">Checkout</h3>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo e(route('home')); ?>">Home</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>Checkout</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="pt-100 pb-100">
         <div class="container container-small">
            <div class="row">
               <div class="col-12 text-center">
                  <h2 class="mb-20">Checkout</h2>
                  <p class="text-muted">This is a placeholder checkout page. Implement payment/checkout flow here.</p>
                  <a href="<?php echo e(route('shop')); ?>" class="fill-btn mt-3">Continue Shopping</a>
               </div>
            </div>
         </div>
      </section>
   </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/frontend/checkout.blade.php ENDPATH**/ ?>