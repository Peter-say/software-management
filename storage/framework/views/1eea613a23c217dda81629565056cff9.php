<style>
    .management-choice-container {
        text-align: center;
        padding: 40px;
        background-color: #f9f9f9;
    }

    .title {
        font-size: 2rem;
        margin-bottom: 30px;
        color: #333;
    }

    .choice-cards {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .choice-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 280px;
        text-align: center;
        transition: transform 0.3s ease, border 0.3s ease;
        border: 2px solid transparent;
        /* Default border */
    }

    .choice-card:hover {
        transform: translateY(-10px);
    }

    .choice-button {
        background-color: #e23428;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .choice-card.selected {
        border-color: #e23428;
        /* Highlight color */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Optional: stronger shadow */
    }

    .choice-card:hover {
        transform: translateY(-10px);
    }

    .choice-icon {
        width: 60px;
        height: 60px;
        color: #e23428;
        margin-bottom: 15px;
    }

    .choice-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #333;
    }

    .choice-description {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .choice-button {
        background-color: #e23428;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .choice-button:hover {
        background-color: #e23428;
    }
</style>

<?php $__env->startSection('contents'); ?>
    <div class="content-body ">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Components</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">App Set-up</h4>

                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                        <form action="<?php echo e(route('onboarding.save-setup-app')); ?>" enctype="multipart/form-data"
                            method="post">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" id="selected_management_type" name="software_type">

                                <div id="smartwizard" class="form-wizard order-create">
                                    <ul class="nav nav-wizard">
                                        <li><a class="nav-link" href="#software_type">
                                                <span>1</span>
                                            </a></li>
                                        <li><a class="nav-link" href="#software_info">
                                                <span>2</span>
                                            </a></li>
                                        <li><a class="nav-link" href="#hotel_Details">
                                                <span>3</span>
                                            </a></li>
                                        <li><a class="nav-link" href="#submit_details">
                                                <span>4</span>
                                            </a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="software_type" class="tab-pane" role="tabpanel">
                                            <div class="management-choice-container">
                                                <h1 class="title">Choose Your Management Type</h1>
                                                <div class="choice-cards">
                                                    <div class="choice-card" id="hotel-choice" data-choice="hotel">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="choice-icon">
                                                            <path
                                                                d="M4 22H20c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 8h16v12H4V8zm2 11h2v-2H6v2zm0-4h2v-2H6v2zm4 4h2v-2h-2v2zm0-4h2v-2h-2v2zm4 4h2v-2h-2v2zm0-4h2v-2h-2v2z" />
                                                        </svg>
                                                        <h2 class="choice-title">Hotel Management</h2>
                                                        <p class="choice-description">Manage hotel bookings, rooms, and
                                                            guest
                                                            services.</p>
                                                        <button class="choice-button" data-choice="hotel">Select
                                                            Hotel</button>
                                                    </div>
                                                    <div class="choice-card" id="hospital-choice" data-choice="hospital">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="choice-icon">
                                                            <path
                                                                d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h4v-6h2v6h8v-6h2v6h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM6 18v-4h4v4H6zm8 0v-4h4v4h-4zm6-4h-2v-2h-2v2h-2v2h2v2h2v-2h2v-2z" />
                                                        </svg>
                                                        <h2 class="choice-title">Hospital Management</h2>
                                                        <p class="choice-description">Manage patient records, appointments,
                                                            and
                                                            hospital services.</p>
                                                        <button class="choice-button" data-choice="hospital">Select
                                                            Hospital</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="software_info" class="tab-pane" role="tabpanel ">

                                            <div class="row justify-content-center">
                                                <!-- Software Description Field -->
                                                <div class="col-lg-6 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="description" class="text-label form-label">Software
                                                            Purpose</label>
                                                        <textarea id="description" name="description" required class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Type here ..."><?php echo e(old('description')); ?></textarea>
                                                        <?php $__errorArgs = ['description'];
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
                                            </div>

                                        </div>

                                        <div id="hotel_Details" class="tab-pane" role="tabpanel">
                                            <!-- Hotel Details -->
                                            <div class="row ">
                                                <div class="col-lg-6 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="hotel_name" class="text-label form-label">Hotel
                                                            Name*</label>
                                                        <input type="text" id="hotel_name" name="hotel_name"
                                                            class="form-control <?php $__errorArgs = ['hotel_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Hotel Name" value="<?php echo e(old('hotel_name')); ?>"
                                                            required>
                                                        <?php $__errorArgs = ['hotel_name'];
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
                                                        <label for="address" class="text-label form-label">Address*</label>
                                                        <input type="text" id="address" name="address"
                                                            class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Hotel Address" value="<?php echo e(old('address')); ?>"
                                                            required>
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
                                                            placeholder="Phone Number" value="<?php echo e(old('phone')); ?>"
                                                            required>
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
                                                                    <?php echo e(old('country_id', $country_id ?? '') == $country->id ? 'selected' : ''); ?>>
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
                                                        <label for="website"class="text-label form-label">Website</label>
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
                                            </div>



                                        </div>

                                        <div id="submit_details" class="tab-pane" role="tabpanel">
                                            <div class="row ">

                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="skip-email text-center">
                                                        <div>
                                                            <h5>All Set. Submit Now!</5>
                                                        </div>
                                                        <button class="btn btn-primary" type="submit">Submit
                                                            Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.choice-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove the selected class from all cards
                document.querySelectorAll('.choice-card').forEach(card => card.classList.remove(
                    'selected'));

                // Add the selected class to the clicked card
                const card = this.closest('.choice-card');
                card.classList.add('selected');

                // Get the selected choice
                const choice = this.getAttribute('data-choice');

                // Update the hidden input with the selected choice
                document.getElementById('selected_management_type').value = choice;

                // Optionally, log the choice to the console
                console.log('Selected choice:', choice);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stateId = '<?php echo e(old('state_id')); ?>';

            $('#country_id').on('change', function() {
                var countryId = $(this).val();
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
                            stateDropdown.append(
                            '<option value="">Select State</option>'); // Add placeholder
                            $.each(response.states, function(key, state) {
                                var selected = (state.id == stateId) ? 'selected' : '';
                                stateDropdown.append('<option value="' + state.id +
                                    '" ' + selected + '>' + state.name + '</option>'
                                    );
                            });
                        },
                        error: function() {
                            alert('Error fetching states');
                        }
                    });
                } else {
                    stateDropdown.append('<option value="">Select State</option>');
                }
            });

            // Trigger change event on page load to populate states if country is pre-selected
            $('#country_id').trigger('change');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\onbaording\onboarding.blade.php ENDPATH**/ ?>