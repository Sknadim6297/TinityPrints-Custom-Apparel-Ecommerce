

<?php $__env->startSection('title', 'Order Placed Successfully'); ?>

<?php $__env->startSection('content'); ?>
<style>
.order-success-area {
    background: linear-gradient(180deg, #fffdf8 0%, #ffffff 50%, #fff7ee 100%);
}

.success-shell {
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: #ffffff;
    box-shadow: 0 16px 35px rgba(18, 18, 18, 0.07);
    overflow: hidden;
}

.success-hero {
    padding: 38px 30px 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.07);
    position: relative;
    background: radial-gradient(circle at top right, rgba(212, 167, 98, 0.22) 0, rgba(212, 167, 98, 0) 52%);
}

.success-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    color: var(--clr-common-heading);
    background: rgba(0, 0, 0, 0.05);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 14px;
}

.success-title-row {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.success-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #1d9c5e;
    color: #ffffff;
    font-size: 34px;
    box-shadow: 0 10px 20px rgba(29, 156, 94, 0.26);
    animation: popIn 0.45s ease;
}

@keyframes popIn {
    from {
        transform: scale(0.6);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.success-title {
    margin: 0;
    color: var(--clr-common-heading);
    font-size: 34px;
    line-height: 1.2;
}

.success-subtitle {
    margin: 8px 0 0;
    color: #5f5f5f;
    font-size: 16px;
}

.hero-stats {
    margin-top: 22px;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.hero-stat {
    border: 1px solid rgba(0, 0, 0, 0.07);
    border-radius: 12px;
    padding: 14px;
    background: #fff;
}

.hero-stat-label {
    color: #747474;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 5px;
}

.hero-stat-value {
    color: #1f1f1f;
    font-size: 22px;
    font-weight: 700;
    line-height: 1.3;
    word-break: break-word;
}

.success-main {
    padding: 26px 30px 30px;
}

.content-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 22px;
}

.order-block {
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 14px;
    background: #ffffff;
    overflow: hidden;
}

.order-block + .order-block {
    margin-top: 18px;
}

.order-block-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 15px 18px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.07);
    background: #fffcf6;
}

.order-block-title {
    margin: 0;
    font-size: 18px;
    color: var(--clr-common-heading);
}

.order-block-body {
    padding: 18px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.info-card {
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    background: #ffffff;
    padding: 14px;
}

.info-label {
    color: #767676;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 5px;
}

.info-value {
    color: #1f1f1f;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.55;
    word-break: break-word;
}

.detail-line {
    margin-bottom: 6px;
}

.detail-line:last-child {
    margin-bottom: 0;
}

.items-table-wrap {
    overflow-x: auto;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
}

.items-table th,
.items-table td {
    padding: 13px 12px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    text-align: left;
    vertical-align: middle;
    white-space: nowrap;
}

.items-table th {
    color: #686868;
    font-size: 12px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    font-weight: 700;
}

.items-table td {
    color: #2e2e2e;
    font-size: 14px;
}

.items-table tfoot td {
    font-weight: 600;
    text-align: right;
    white-space: normal;
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 220px;
}

.product-cell img {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid rgba(0, 0, 0, 0.08);
    flex-shrink: 0;
}

.product-name {
    color: #1f1f1f;
    font-weight: 600;
    line-height: 1.35;
}

.meta-badge {
    display: inline-block;
    border-radius: 999px;
    background: #f4f6f8;
    color: #4f4f4f;
    border: 1px solid #e8eaed;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 600;
    margin-right: 6px;
    margin-bottom: 4px;
}

.payment-chip {
    display: inline-block;
    border-radius: 999px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 700;
    background: #fff2d2;
    color: #8b6100;
}

.notice-card {
    border-radius: 12px;
    border: 1px solid #d6e7ff;
    background: #edf5ff;
    color: #2b4f7c;
    padding: 14px 15px;
    line-height: 1.5;
}

.sidebar-card {
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 12px 24px rgba(20, 20, 20, 0.05);
    padding: 18px;
}

.sidebar-card + .sidebar-card {
    margin-top: 16px;
}

.sidebar-title {
    margin: 0 0 14px;
    color: var(--clr-common-heading);
    font-size: 18px;
}

.sidebar-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-list li {
    position: relative;
    padding-left: 16px;
    color: #666;
    margin-bottom: 10px;
    line-height: 1.5;
}

.sidebar-list li:last-child {
    margin-bottom: 0;
}

.sidebar-list li::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--clr-common-heading);
    position: absolute;
    left: 0;
    top: 8px;
}

.actions-row {
    margin-top: 20px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.action-btn {
    border-radius: 10px;
    padding: 11px 18px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.action-btn-primary {
    background: var(--clr-common-heading);
    color: #ffffff;
}

.action-btn-secondary {
    border: 2px solid var(--clr-common-heading);
    color: var(--clr-common-heading);
    background: transparent;
}

.action-btn:hover {
    transform: translateY(-2px);
    text-decoration: none;
}

@media (max-width: 1199px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .success-hero,
    .success-main {
        padding-left: 18px;
        padding-right: 18px;
    }

    .success-title {
        font-size: 28px;
    }

    .hero-stats {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .product-cell {
        min-width: 170px;
    }
}
</style>

<main>
    <section class="page-title-area" data-background="<?php echo e(asset('frontend/assets/img/banner/banner-1-1.jpg')); ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">Order Success</h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
                                    <li class="trail-item trail-end"><span>Order Success</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="order-success-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="success-shell">
                        <div class="success-hero">
                            <span class="success-badge">Order Confirmed</span>
                            <div class="success-title-row">
                                <div class="success-icon"><i class="fal fa-check"></i></div>
                                <div>
                                    <h2 class="success-title">Thank You!</h2>
                                    <p class="success-subtitle">Your order has been placed successfully.</p>
                                </div>
                            </div>

                            <div class="hero-stats">
                                <div class="hero-stat">
                                    <div class="hero-stat-label">Order Number</div>
                                    <div class="hero-stat-value"><?php echo e($order->order_number); ?></div>
                                </div>
                                <div class="hero-stat">
                                    <div class="hero-stat-label">Total Amount</div>
                                    <div class="hero-stat-value">INR <?php echo e(number_format($order->total_amount, 2)); ?></div>
                                </div>
                                <div class="hero-stat">
                                    <div class="hero-stat-label">Payment Method</div>
                                    <div class="hero-stat-value">
                                        <span class="payment-chip"><?php echo e(strtoupper(str_replace('_', ' ', $order->payment_method))); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="success-main">
                            <div class="content-grid">
                                <div>
                                    <div class="order-block">
                                        <div class="order-block-head">
                                            <h4 class="order-block-title">Order Details</h4>
                                        </div>
                                        <div class="order-block-body">
                                            <div class="info-grid">
                                                <div class="info-card">
                                                    <div class="info-label">Shipping Address</div>
                                                    <div class="info-value">
                                                        <div class="detail-line"><?php echo e($order->customer_name); ?></div>
                                                        <div class="detail-line"><?php echo e($order->shipping_address); ?></div>
                                                        <div class="detail-line"><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?></div>
                                                        <div class="detail-line"><?php echo e($order->shipping_country); ?></div>
                                                    </div>
                                                </div>

                                                <div class="info-card">
                                                    <div class="info-label">Contact Information</div>
                                                    <div class="info-value">
                                                        <div class="detail-line"><strong>Phone:</strong> <?php echo e($order->phone); ?></div>
                                                        <div class="detail-line"><strong>Email:</strong> <?php echo e($order->email); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-block">
                                        <div class="order-block-head">
                                            <h4 class="order-block-title">Items Ordered</h4>
                                        </div>
                                        <div class="order-block-body">
                                            <div class="items-table-wrap">
                                                <table class="items-table">
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
                                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="product-cell">
                                                                        <?php if($order->design_request_id && $order->designRequest && $order->designRequest->front_design_file): ?>
                                                                            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($order->designRequest->front_design_file)); ?>" alt="<?php echo e($item->product_name); ?>" style="object-fit: contain;">
                                                                        <?php elseif($item->product && $item->product->images && $item->product->images->first()): ?>
                                                                            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_path)); ?>" alt="<?php echo e($item->product_name); ?>">
                                                                        <?php else: ?>
                                                                            <img src="<?php echo e(asset('frontend/assets/img/product/product-img1.jpg')); ?>" alt="<?php echo e($item->product_name); ?>">
                                                                        <?php endif; ?>
                                                                        <span class="product-name"><?php echo e($item->product_name); ?></span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php if($item->color_name): ?>
                                                                        <span class="meta-badge"><?php echo e($item->color_name); ?></span>
                                                                    <?php endif; ?>
                                                                    <?php if($item->size): ?>
                                                                        <span class="meta-badge"><?php echo e($item->size); ?></span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>INR <?php echo e(number_format($item->price, 2)); ?></td>
                                                                <td><?php echo e($item->quantity); ?></td>
                                                                <td><strong>INR <?php echo e(number_format($item->total, 2)); ?></strong></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4">Subtotal:</td>
                                                            <td><strong>INR <?php echo e(number_format($order->subtotal, 2)); ?></strong></td>
                                                        </tr>
                                                        <?php if($order->discount_amount > 0): ?>
                                                            <tr>
                                                                <td colspan="4">Discount:</td>
                                                                <td><strong>-INR <?php echo e(number_format($order->discount_amount, 2)); ?></strong></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <tr>
                                                            <td colspan="4">Total:</td>
                                                            <td><strong>INR <?php echo e(number_format($order->total_amount, 2)); ?></strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notice-card">
                                        You will receive an email confirmation at <strong><?php echo e($order->email); ?></strong> shortly. You can track your order status in your profile.
                                    </div>

                                    <div class="actions-row">
                                        <a href="<?php echo e(route('orders')); ?>" class="action-btn action-btn-primary">
                                            <i class="fal fa-list"></i>
                                            View My Orders
                                        </a>
                                        <a href="<?php echo e(route('shop')); ?>" class="action-btn action-btn-secondary">
                                            <i class="fal fa-shopping-bag"></i>
                                            Continue Shopping
                                        </a>
                                    </div>
                                </div>

                                <aside>
                                    <div class="sidebar-card">
                                        <h5 class="sidebar-title">What Happens Next</h5>
                                        <ul class="sidebar-list">
                                            <li>Order confirmation is sent to your email and account.</li>
                                            <li>Our team verifies stock and prepares your package.</li>
                                            <li>You can monitor updates in your order history page.</li>
                                        </ul>
                                    </div>

                                    <div class="sidebar-card">
                                        <h5 class="sidebar-title">Need Help</h5>
                                        <ul class="sidebar-list">
                                            <li>Support email: <?php echo e($order->email); ?></li>
                                            <li>Keep your order number ready: <?php echo e($order->order_number); ?></li>
                                            <li>For design orders, approval and fulfillment updates appear in your account.</li>
                                        </ul>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views\frontend\order-success.blade.php ENDPATH**/ ?>