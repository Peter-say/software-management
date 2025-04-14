<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.settings.')); ?>">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Hotel</a></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <h4 class="card-header">Select a Payment Platform</h4>
                        <div class="card-body">
                            <p>
                                <strong class="text-warning">Caution:</strong>
                                <span class="text-danger">
                                    Please ensure that you enter the correct details for your payment platform to avoid
                                    transaction issues.
                                </span>
                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ensure that the provided credentials, such as Public Key and Secret Key, are accurate and match your payment provider's settings.">
                                </i>
                            </p>
                            <?php $__currentLoopData = $payment_platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="d-flex align-items-center p-3 shadow-sm rounded mb-2" style="cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#paymentModal<?php echo e($platform->id); ?>">

                                    <?php
                                        $logoPath = 'storage/' . $platform->logo;
                                        $selected_platform = $platform->hotelPaymentPlatforms
                                            ->where('hotel_id', \App\Models\User::getAuthenticatedUser()->hotel->id)
                                            ->first();
                                        // dd($selected_platform)
                                    ?>
                                    <?php if($platform->logo && Storage::exists($platform->logo)): ?>
                                        <img src="<?php echo e(asset($logoPath)); ?>" alt="<?php echo e($platform->name); ?>" class="me-3"
                                            style="width: 50px;">
                                    <?php else: ?>
                                        <img src="<?php echo e(getStorageUrl('dashboard/icons/payment-icon-vector.jpg')); ?>"
                                            alt="<?php echo e($platform->name); ?>" class="me-3" style="width: 50px;">
                                    <?php endif; ?>

                                    <h6 class="mb-0 flex-grow-1"><?php echo e($platform->name); ?></h6>
                                    <input type="radio" name="selected_platform" value="<?php echo e($platform->id); ?>"
                                        class="platform-radio" <?php if(optional($selected_platform)->payment_platform_id == $platform->id): echo 'checked'; endif; ?>>

                                </label>
                                <!-- Payment Platform Modal (inside loop) -->
                                <div class="modal fade" id="paymentModal<?php echo e($platform->id); ?>" tabindex="-1"
                                    aria-labelledby="paymentModalLabel<?php echo e($platform->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentModalLabel<?php echo e($platform->id); ?>">Enter
                                                    <?php echo e($platform->name); ?> Payment Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="<?php echo e(isset($selected_platform) ? route('dashboard.hotel.update-payment-platform', optional($selected_platform)->id) : route('dashboard.hotel.store-payment-platform')); ?>"
                                                method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php if(isset($selected_platform)): ?>
                                                    <?php echo method_field('PUT'); ?>
                                                <?php endif; ?>

                                                <div class="modal-body">
                                                    <input type="hidden" name="selected_platform"
                                                        value="<?php echo e($platform->id); ?>">

                                                    <div class="mb-3">
                                                        <label for="public_key_<?php echo e($platform->id); ?>"
                                                            class="form-label">Public Key</label>
                                                        <input type="text" name="public_key"
                                                            id="public_key_<?php echo e($platform->paymentPlatform->id ?? ''); ?>"
                                                            class="form-control <?php $__errorArgs = ['public_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            value="<?php echo e(old('public_key', $selected_platform->public_key ?? '')); ?>"
                                                            required>
                                                        <?php $__errorArgs = ['public_key'];
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

                                                    <div class="mb-3">
                                                        <label for="secret_key_<?php echo e($platform->id); ?>"
                                                            class="form-label">Secret Key</label>
                                                        <input type="text" name="secret_key"
                                                            id="secret_key_<?php echo e($platform->id); ?>"
                                                            class="form-control <?php $__errorArgs = ['secret_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            value="<?php echo e(old('secret_key', $selected_platform->secret_key ?? '')); ?>"
                                                            required>
                                                        <?php $__errorArgs = ['secret_key'];
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
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function openModal(platformId, platformName) {
            document.getElementById('selectedPlatformId').value = platformId;
            document.getElementById('paymentModalLabel').textContent = "Enter " + platformName + " Payment Details";

            var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var paymentModal = document.getElementById('paymentModal');

            paymentModal.addEventListener('hidden.bs.modal', function() {
                // Remove all remaining modal-backdrop elements
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                // Ensure modal-open class is removed from body
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''; // Fixes possible body padding issue
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/settings/hotel/payment-platform.blade.php ENDPATH**/ ?>