

<?php $__env->startSection('title', 'Custom Design - Tinnity'); ?>

<?php $__env->startSection('content'); ?>
<?php ($frontendAsset = asset('frontend/assets')); ?>

<style>
.custom-design-area {
    background: linear-gradient(180deg, #fffdf8 0%, #ffffff 55%, #fff8ef 100%);
}

.custom-panel {
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 14px;
    box-shadow: 0 16px 35px rgba(20, 20, 20, 0.06);
}

.custom-panel-header {
    padding: 28px 28px 16px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.custom-panel-body {
    padding: 24px 28px 28px;
}

.custom-kicker {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.05);
    color: var(--clr-common-heading);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
    margin-bottom: 14px;
}

.custom-panel-title {
    margin: 0;
    font-size: 28px;
    line-height: 1.25;
    color: var(--clr-common-heading);
}

.custom-panel-subtitle {
    margin: 10px 0 0;
    color: var(--clr-common-text);
}

.custom-section {
    margin-top: 24px;
}

.custom-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    color: var(--clr-common-heading);
    font-size: 18px;
    font-weight: 700;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.form-grid .span-2 {
    grid-column: span 2;
}

.input-wrap label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--clr-common-heading);
}

.input-wrap small {
    color: #787878;
}

.theme-input,
.theme-select,
.theme-textarea,
.theme-file,
.theme-color {
    width: 100%;
    border: 1px solid rgba(0, 0, 0, 0.14);
    border-radius: 10px;
    padding: 2px 14px;
    background: #fff;
    color: #262626;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
}

.theme-input:focus,
.theme-select:focus,
.theme-textarea:focus,
.theme-file:focus,
.theme-color:focus {
    border-color: var(--clr-common-heading);
    box-shadow: 0 0 0 3px rgba(212, 167, 98, 0.15);
    outline: none;
}

.theme-textarea {
    min-height: 130px;
    resize: vertical;
}

.theme-color {
    height: 48px;
    padding: 4px;
    cursor: pointer;
}

.file-drop {
    border: 1px dashed rgba(0, 0, 0, 0.22);
    border-radius: 12px;
    padding: 14px;
    background: #fffaf3;
}

.file-drop:hover {
    border-color: var(--clr-common-heading);
}

.file-note {
    margin-top: 8px;
    color: #6f6f6f;
    font-size: 12px;
}

.info-alert {
    border-radius: 12px;
    background: #fff7e6;
    border: 1px solid #f5deb2;
    padding: 18px;
}

.info-alert h5 {
    margin: 0 0 10px;
    color: #8c5a00;
    font-weight: 700;
}

.info-alert ul {
    margin: 0;
    padding-left: 18px;
}

.info-alert li {
    margin-bottom: 8px;
    color: #644300;
}

.info-alert li:last-child {
    margin-bottom: 0;
}

.form-actions {
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 4px;
}

.custom-btn {
    border: none;
    border-radius: 10px;
    padding: 12px 22px;
    font-weight: 700;
    transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.25s ease;
}

.custom-btn:hover {
    transform: translateY(-2px);
}

.custom-btn-primary {
    background: var(--clr-common-heading);
    color: #fff;
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
}

.custom-btn-outline {
    background: transparent;
    border: 2px solid var(--clr-common-heading);
    color: var(--clr-common-heading);
}

.right-card {
    border-radius: 14px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: #fff;
    padding: 22px;
    box-shadow: 0 12px 24px rgba(20, 20, 20, 0.05);
}

.right-card + .right-card {
    margin-top: 20px;
}

.right-card-title {
    margin: 0 0 16px;
    color: var(--clr-common-heading);
    font-size: 19px;
    font-weight: 700;
}

.right-card h6 {
    margin: 0 0 6px;
    font-size: 15px;
    font-weight: 700;
    color: #1f1f1f;
}

.right-card p,
.right-card li,
.right-card small {
    color: #646464;
}

.simple-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.simple-list li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 10px;
}

.simple-list li:last-child {
    margin-bottom: 0;
}

.simple-list li::before {
    content: "";
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    left: 0;
    top: 8px;
    background: var(--clr-common-heading);
}

.login-required-card {
    max-width: 760px;
    margin: 0 auto;
    padding: 38px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 16px 34px rgba(20, 20, 20, 0.08);
}

.history-panel {
    margin-top: 28px;
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 12px 30px rgba(20, 20, 20, 0.06);
    overflow: hidden;
}

.history-panel-header {
    padding: 18px 22px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.history-panel-title {
    margin: 0;
    color: var(--clr-common-heading);
    font-size: 22px;
}

.history-stats {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.history-pill {
    border-radius: 999px;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 700;
}

.history-pill.pending {
    background: #e7f3ff;
    color: #1b6db8;
}

.history-pill.approved {
    background: #e9f7ef;
    color: #18834f;
}

.history-pill.rejected {
    background: #feecee;
    color: #c33748;
}

.history-table-wrap {
    overflow-x: auto;
}

.history-table {
    width: 100%;
    border-collapse: collapse;
}

.history-table th,
.history-table td {
    padding: 14px 18px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    white-space: nowrap;
}

.history-table th {
    font-size: 13px;
    color: #636363;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.history-table td {
    color: #2b2b2b;
    font-size: 14px;
}

.status-badge {
    display: inline-block;
    border-radius: 999px;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 700;
    text-transform: capitalize;
}

.status-badge.pending {
    background: #e7f3ff;
    color: #1b6db8;
}

.status-badge.approved {
    background: #e9f7ef;
    color: #18834f;
}

.status-badge.rejected {
    background: #feecee;
    color: #c33748;
}

.status-badge.changes_requested {
    background: #fff4dd;
    color: #9f6300;
}

.table-view-link {
    color: var(--clr-common-heading);
    font-weight: 700;
    text-decoration: none;
}

.table-view-link:hover {
    text-decoration: underline;
}

@media (max-width: 991px) {
    .custom-panel-header,
    .custom-panel-body {
        padding-left: 20px;
        padding-right: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-grid .span-2 {
        grid-column: span 1;
    }
}
</style>

<main>
    <section class="page-title-area" data-background="<?php echo e($frontendAsset); ?>/img/banner/banner-1-1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-wrapper text-center">
                        <h1 class="page-title mb-10">Design Your T-Shirt</h1>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="<?php echo e(route('home')); ?>"><span>Home</span></a></li>
                                    <li class="trail-item trail-end"><span>Custom Design</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="custom-design-area pt-120 pb-120">
        <div class="container container-small">
            <?php if(auth()->guard()->check()): ?>
                <div class="row">
                    <div class="col-lg-8 mb-40">
                        <div class="custom-panel">
                            <div class="custom-panel-header">
                                <span class="custom-kicker">Custom Printing</span>
                                <h2 class="custom-panel-title">Upload Your Custom Design</h2>
                                <p class="custom-panel-subtitle">Share your design files and printing instructions. Our team reviews every submission before checkout.</p>
                            </div>

                            <div class="custom-panel-body">
                                <?php if($errors->any()): ?>
                                    <div class="alert alert-danger mb-25" role="alert">
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form action="<?php echo e(route('custom-design.store')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <div class="custom-section">
                                        <h4 class="custom-section-title"><i class="fal fa-user"></i> Contact Details</h4>
                                        <div class="form-grid">
                                            <div class="input-wrap">
                                                <label for="customer_name">Full Name *</label>
                                                <input id="customer_name" class="theme-input" type="text" name="customer_name" value="<?php echo e(old('customer_name', Auth::user()->name)); ?>" required>
                                                <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="input-wrap">
                                                <label for="email">Email Address *</label>
                                                <input id="email" class="theme-input" type="email" name="email" value="<?php echo e(old('email', Auth::user()->email)); ?>" required>
                                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="input-wrap">
                                                <label for="phone">Phone Number *</label>
                                                <input id="phone" class="theme-input" type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required>
                                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-section">
                                        <h4 class="custom-section-title"><i class="fal fa-tshirt"></i> T-Shirt Options</h4>
                                        <div class="form-grid">
                                            <div class="input-wrap">
                                                <label for="selected_size">T-Shirt Size *</label>
                                                <select id="selected_size" class="theme-select" name="selected_size" required>
                                                    <option value="">Select Size</option>
                                                    <option value="m" <?php echo e(old('selected_size') === 'm' ? 'selected' : ''); ?>>Medium (M)</option>
                                                    <option value="l" <?php echo e(old('selected_size') === 'l' ? 'selected' : ''); ?>>Large (L)</option>
                                                    <option value="xl" <?php echo e(old('selected_size') === 'xl' ? 'selected' : ''); ?>>Extra Large (XL)</option>
                                                </select>
                                                <?php $__errorArgs = ['selected_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="input-wrap">
                                                <label for="sleeve_type">Sleeve Type *</label>
                                                <select id="sleeve_type" class="theme-select" name="sleeve_type" required>
                                                    <option value="">Select Sleeve Type</option>
                                                    <option value="full" <?php echo e(old('sleeve_type') === 'full' ? 'selected' : ''); ?>>Full Sleeve</option>
                                                    <option value="half" <?php echo e(old('sleeve_type') === 'half' ? 'selected' : ''); ?>>Half Sleeve</option>
                                                </select>
                                                <?php $__errorArgs = ['sleeve_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="input-wrap span-2">
                                                <label for="color">T-Shirt Color *</label>
                                                <input id="color" class="theme-color" type="color" name="color" value="<?php echo e(old('color', '#FFFFFF')); ?>" required>
                                                <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-section">
                                        <h4 class="custom-section-title"><i class="fal fa-image"></i> Design Files</h4>
                                        <p class="mb-15">Supported formats: PNG, JPG, PDF | Max file size: 10MB</p>
                                        <div class="form-grid">
                                            <div class="input-wrap file-drop">
                                                <label for="front_design_file">Front Design *</label>
                                                <input id="front_design_file" class="theme-file" type="file" name="front_design_file" accept=".png,.jpg,.jpeg,.pdf" required>
                                                <p class="file-note">Supported: PNG, JPG, PDF | Max: 10MB</p>
                                                <?php $__errorArgs = ['front_design_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="input-wrap file-drop">
                                                <label for="back_design_file">Back Design (Optional)</label>
                                                <input id="back_design_file" class="theme-file" type="file" name="back_design_file" accept=".png,.jpg,.jpeg,.pdf">
                                                <p class="file-note">Leave empty if only front design.</p>
                                                <?php $__errorArgs = ['back_design_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-section">
                                        <h4 class="custom-section-title"><i class="fal fa-comment"></i> Additional Instructions</h4>
                                        <div class="form-grid">
                                            <div class="input-wrap span-2">
                                                <label for="notes">Notes and Special Requests</label>
                                                <textarea id="notes" class="theme-textarea" name="notes" placeholder="Add any special printing instructions, color preferences, or other details..."><?php echo e(old('notes')); ?></textarea>
                                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="text-danger"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-section">
                                        <div class="info-alert mb-20">
                                            <h5>Important Information</h5>
                                            <ul>
                                                <li><strong>Approval Required:</strong> Your design will be reviewed by our team before you can proceed to payment.</li>
                                                <li><strong>Turnaround Time:</strong> Review and approval typically takes 24-48 hours.</li>
                                                <li><strong>File Security:</strong> Your design files are securely stored and only used for your order.</li>
                                                <li><strong>Quality Standards:</strong> We verify every file meets printing quality standards.</li>
                                                <li><strong>No Refund After Approval:</strong> Once approved and paid, custom designs cannot be refunded unless defective.</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="custom-btn custom-btn-primary">
                                            <i class="fal fa-cloud-upload-alt"></i> Submit for Review
                                        </button>
                                        <a href="<?php echo e(route('home')); ?>" class="custom-btn custom-btn-outline">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="right-card">
                            <h4 class="right-card-title"><i class="fal fa-lightbulb"></i> Design Guidelines</h4>
                            <h6>File Formats</h6>
                            <p>We accept PNG, JPG, and PDF files. PNG is preferred with transparent backgrounds.</p>
                            <h6>File Size</h6>
                            <p>Maximum file size is 10MB. Smaller files upload faster.</p>
                            <h6>Resolution</h6>
                            <p>For best quality, use images with 300 DPI or higher.</p>
                            <h6>Design Placement</h6>
                            <p>Leave at least 0.5 inch margins from the T-shirt edges.</p>
                            <h6>Color Accuracy</h6>
                            <p>Colors may appear slightly different on fabric depending on printing method.</p>
                        </div>

                        <div class="right-card">
                            <h4 class="right-card-title"><i class="fal fa-tag"></i> Pricing</h4>
                            <p>Custom design pricing starts at <strong>INR 499.00</strong> for one shirt based on:</p>
                            <ul class="simple-list">
                                <li>T-shirt size and fabric quality</li>
                                <li>Design complexity</li>
                                <li>Number of print colors</li>
                                <li>Quantity of shirts</li>
                            </ul>
                            <p class="mt-10"><small>Final price is confirmed after design approval.</small></p>
                        </div>

                        <div class="right-card">
                            <h4 class="right-card-title"><i class="fal fa-question-circle"></i> FAQ</h4>
                            <h6>Q: How long does approval take?</h6>
                            <p>A: Usually 24-48 hours. You will be notified by email.</p>
                            <h6>Q: Can I modify my design?</h6>
                            <p>A: Yes, you can resubmit if our team requests changes.</p>
                            <h6>Q: What is the minimum order?</h6>
                            <p>A: You can order as little as one shirt from your approved design.</p>
                        </div>
                    </div>
                </div>

                <?php if($userDesigns && $userDesigns->count() > 0): ?>
                    <div class="history-panel">
                        <div class="history-panel-header">
                            <h3 class="history-panel-title">My Custom Design Requests</h3>
                            <div class="history-stats">
                                <span class="history-pill pending">Pending: <?php echo e($userDesigns->where('status', 'pending')->count()); ?></span>
                                <span class="history-pill approved">Approved: <?php echo e($userDesigns->where('status', 'approved')->count()); ?></span>
                                <span class="history-pill rejected">Rejected: <?php echo e($userDesigns->where('status', 'rejected')->count()); ?></span>
                            </div>
                        </div>

                        <div class="history-table-wrap">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Size</th>
                                        <th>Design</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $userDesigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>#<?php echo e($design->id); ?></td>
                                            <td><?php echo e(strtoupper($design->selected_size)); ?></td>
                                            <td>
                                                <span>Front: <?php echo e($design->front_label ?: 'F'); ?></span>
                                                <?php if($design->back_design_file): ?>
                                                    <span class="d-block">Back: <?php echo e($design->back_label ?: 'B'); ?></span>
                                                <?php else: ?>
                                                    <span class="d-block text-muted">Back: Not uploaded</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="status-badge <?php echo e($design->status); ?>"><?php echo e(str_replace('_', ' ', $design->status)); ?></span>
                                            </td>
                                            <td><?php echo e($design->created_at->format('M d, Y')); ?></td>
                                            <td>
                                                <a class="table-view-link" href="<?php echo e(route('custom-design.show', $design)); ?>">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="login-required-card text-center">
                            <i class="fal fa-lock" style="font-size: 58px; color: #f4b400;"></i>
                            <h2 class="mt-25 mb-15">Sign In Required</h2>
                            <p class="mb-30">You must be logged in to submit a custom design. Sign in to continue or create a new account.</p>
                            <div class="form-actions justify-content-center">
                                <a href="<?php echo e(route('login')); ?>" class="custom-btn custom-btn-primary"><i class="fal fa-sign-in-alt"></i> Sign In</a>
                                <a href="<?php echo e(route('register')); ?>" class="custom-btn custom-btn-outline"><i class="fal fa-user-plus"></i> Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const frontDesignInput = document.getElementById('front_design_file');
    const backDesignInput = document.getElementById('back_design_file');

    [frontDesignInput, backDesignInput].forEach(function (input) {
        if (!input) {
            return;
        }

        input.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const validFormats = ['image/png', 'image/jpeg', 'application/pdf'];
            const maxSize = 10 * 1024 * 1024;

            if (!validFormats.includes(file.type)) {
                alert('Please upload PNG, JPG, or PDF files only.');
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                alert('File size should not exceed 10MB.');
                this.value = '';
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Tinnity_ecom\resources\views/frontend/custom-design.blade.php ENDPATH**/ ?>