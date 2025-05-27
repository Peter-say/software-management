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
                        <h4 class="card-header">Select a Currency</h4>
                        <div class="card-body">
                            <p>
                                <strong class="text-warning">Caution:</strong>
                                <span class="text-info">
                                    The currency you select will be used across the app for transactions unless otherwise
                                    stated.
                                </span>
                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ensure that the selected currency is accurate. This currency will be used for all 
                                    transactions within the app. Future integration will allow users from other 
                                    countries to book using their local currency. This will be integrated when 
                                    the hotel plans to launch a web-based site. Please make sure to review the 
                                    currency settings periodically to accommodate any changes in the hotel's 
                                    operational regions.">
                                </i>
                            </p>
                            <form action="<?php echo e(route('dashboard.hotel.update-hotel-currency')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="currency" class="form-label">Currency</label>
                                        <?php
                                            $selectedCurrencyCode = getCountryCurrency(); // This returns something like 'USD'
                                            $selectedCurrency = collect(getModelItems('currencies'))->firstWhere(
                                                'short_name',
                                                $selectedCurrencyCode,
                                            );
                                        ?>

                                        <select id="currency" name="currency_id"
                                            class="form-control <?php $__errorArgs = ['currency_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Select Currency</option>
                                            <?php $__currentLoopData = getModelItems('currencies'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currency->id); ?>"
                                                    <?php echo e(old('currency_id', $selectedCurrency->id ?? null) == $currency->id ? 'selected' : ''); ?>>
                                                    <?php echo e($currency->short_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <?php $__errorArgs = ['currency_id'];
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

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/settings/hotel/edit-currency.blade.php ENDPATH**/ ?>