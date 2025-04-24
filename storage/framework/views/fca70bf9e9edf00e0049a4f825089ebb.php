

<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles d-flex justify-content-between align-items-center">
                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-0 col-auto">
                    <li class="breadcrumb-item active">
                        <a href="<?php echo e(route('dashboard.home')); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Payment</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Pay</a>
                    </li>
                </ol>
        
                <!-- Go Back Button -->
                <div class="col-auto">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">Go Back</a>
                </div>
            </div>
        </div>
        
        <div class="container">
            <!-- Title and Payment Option Row -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 id="payment-title" class="mb-0">Card Payment</h5>
                        <select class="form-select w-auto ms-3" id="payment-option" name="payment_option">
                            <option value="CARD">CARD</option>
                            <option value="CASH">CASH</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="<?php echo e(route('dashboard.payments.initiate')); ?>" id="paymentInitiate" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p>Payment Due</p>
                                <p>
                                    <b><?php echo e(currencySymbol()); ?><?php echo e(number_format(
                                            $reservation->total_amount +
                                                $reservation->guest->calculateOrderNetTotal() -
                                                (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()),
                                            2,
                                        )); ?>

                                    </b>
                                    <input type="hidden" id="payable-amount" name="payable-amount"
                                        value="<?php echo e($reservation->total_amount +
                                                $reservation->guest->calculateOrderNetTotal() -
                                                (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders())); ?>">
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">How Much Do You Want To Pay?</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select id="currency" name="currency" class="form-control <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php $currency = getHotelCurrency(); ?>
                                <option value="<?php echo e($currency->short_name); ?>" <?php echo e(old('currency', $currency->short_name) == $currency->short_name ? 'selected' : ''); ?>>
                                    <?php echo e($currency->short_name); ?>

                                </option>
                            </select>
                            <?php $__errorArgs = ['currency'];
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

                        <div id="stripe-card" class="mb-3">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Comment</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter comment if any"></textarea>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="stripeToken" id="stripe-token">
                        <input type="hidden" name="stripe_payment" id="stripe-payment" value="Stripe">
                        <input type="hidden" name="payment_method" id="payment-method">
                        <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                        <?php echo $__env->make('dashboard.general.payment.payable-details', ['reservation' => $reservation], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <input type="hidden" name="amount_due"
                            value="<?php echo e($reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount')); ?>">
                        <button type="submit" class="btn btn-primary" id="pay-now">Pay Now</button>
                        <button type="reset" class="btn btn-secondary">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 <?php $__env->stopSection(); ?>


<?php echo $__env->make('dashboard.general.payment.payment-platform-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\general\payment\create.blade.php ENDPATH**/ ?>