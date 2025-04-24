

<?php $__env->startSection('contents'); ?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.hotel.settings.')); ?>">Settings</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Hotel Info</a></li>
            </ol>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Hotel Info</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('dashboard.hotel.settings.hotel-info.update')); ?>"
                        enctype="multipart/form-data" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="hotel_name" class="text-label form-label">Name*</label>
                                    <input type="text" id="hotel_name" name="hotel_name"
                                        class="form-control <?php $__errorArgs = ['hotel_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Name"
                                        value="<?php echo e(old('name', $hotel->hotel_name ?? '')); ?>" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="phone" class="text-label form-label">Phone*</label>
                                    <input type="text" id="phone" name="phone"
                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Phone Number" value="<?php echo e(old('phone', $hotel->phone ?? '')); ?>" required>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="address" class="text-label form-label">Address</label>
                                    <input type="text" id="address" name="address"
                                        class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Address" value="<?php echo e(old('address', $hotel->address ?? '')); ?>">
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Country Field -->
                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="country_id" class="form-label">Country</label>
                                    <select id="country_id" name="country_id"
                                        class="form-control <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select Country</option>
                                        <?php $__currentLoopData = getModelItems('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->id); ?>"
                                            <?php echo e(old('country_id', $hotel->country_id ?? '') == $country->id ? 'selected' : ''); ?>>
                                            <?php echo e($country->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['country_id'];
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

                            <!-- State Field -->
                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="state_id" class="form-label">State</label>
                                    <select id="state_id" name="state_id"
                                        class="form-control <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select State</option>
                                    </select>
                                    <?php $__errorArgs = ['state_id'];
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
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="logo" class="text-label form-label">Logo</label>
                                    <input type="file" id="logo" name="logo"
                                        class="form-control w-100 <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="website" class="text-label form-label">Website</label>
                                    <input type="text" id="website" name="website"
                                        class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Website URL" value="<?php echo e(old('website')); ?>">
                                    <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <?php if(isset($hotel->logo)): ?>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#fileModal">
                                    View Existing Logo
                                </button>
                            </div>
                            <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="fileModalLabel">Uploaded File</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe src="<?php echo e(getStorageUrl('hotel/logos/' . $hotel->logo)); ?>"
                                                width="100%" height="500px"></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo e('Submit'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stateId = '<?php echo e(old('
        state_id ', $hotel->state_id ?? '
        ')); ?>';
        var countryId = '<?php echo e(old('
        country_id ', $hotel->country_id ?? '
        ')); ?>';

        function loadStates(countryId, selectedStateId = null) {
            var stateDropdown = $('#state_id');
            stateDropdown.empty();

            if (countryId) {
                $.ajax({
                    url: '<?php echo e(route('get-states-by-country')); ?>',
                    type: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(response) {
                        stateDropdown.append('<option value="">Select State</option>');
                        $.each(response.states, function(key, state) {
                            var selected = (state.id == selectedStateId) ? 'selected' : '';
                            stateDropdown.append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching states');
                    }
                });
            } else {
                stateDropdown.append('<option value="">Select State</option>');
            }
        }

        // Trigger on country change
        $('#country_id').on('change', function() {
            var selectedCountryId = $(this).val();
            loadStates(selectedCountryId);
        });

        // Load states on page load if country is pre-selected
        if (countryId) {
            loadStates(countryId, stateId);
        }
    });
</script>
<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\settings\hotel\edit-info.blade.php ENDPATH**/ ?>