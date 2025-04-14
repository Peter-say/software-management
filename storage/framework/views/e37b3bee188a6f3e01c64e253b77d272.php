<div class="modal fade" id="Pay-with-wallet-modal<?php echo e($order->id); ?>" tabindex="-1" role="dialog"
    aria-labelledby="Pay-with-wallet-modal<?php echo e($order->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Pay-with-wallet-modal">Wallet Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo e(route('dashboard.hotel.pay-with-guest-wallet')); ?>" id="payWithWallet" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="modal-body text-dark">
                        <div class="d-flex justify-content-between">
                            <div>

                                <p>Current balance</p>
                                <p>
                                    <?php if($order->guest && $order->guest->wallet): ?>
                                        <span><b><?php echo e(currencySymbol()); ?><?php echo e(number_format($order->guest->wallet->balance, 2, '.', ',')); ?></b></span>
                                    <?php else: ?>
                                        <span><b><?php echo e(currencySymbol()); ?>0.00</b></span>
                                    <?php endif; ?>
                                </p>
                            </div>

                            <div>
                                <p>Payment Due</p>
                                <p>
                                    
                                    <?php
                                        $totalDue = $order->total_amount - $order->payments->sum('amount');
                                    ?>
                                    <b><?php echo e(currencySymbol()); ?><?php echo e(number_format($totalDue, 2, '.', ',')); ?></b>
                                </p>
                            </div>
                        </div>

                        <div class="col-12 m-3">
                            <label for="amount">How Much Do You Want To Pay?</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="amount" name="amount" placeholder="Enter Amount">
                            <?php $__errorArgs = ['amount'];
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
                        <div class="col-12 mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select id="currency" name="currency"
                                class="form-control <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Currency</option>
                                <?php
                                $currency = getHotelCurrency();
                            ?>
                            <option value="">Select Currency</option>
                                <option value="<?php echo e($currency->short_name); ?>"
                                    <?php echo e(old('currency', $currency->short_name ?? '') == $currency->short_name ? 'selected' : ''); ?>>
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
                        <div class="col-12 m-3">
                            <label for="description">Comment</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description" cols="5"
                                rows="2" placeholder="Enter payment comment if any"><?php echo e(old('description')); ?></textarea>
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

                    <div class="modal-footer">
                        <input type="hidden" name="payment_method" value="WALLET">
                        <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                        <input type="hidden" name="payable_id" value="<?php echo e($order->id); ?>">
                        <input type="hidden" name="payable_type" value="<?php echo e(get_class($order)); ?>">
                        <button type="submit" class="btn btn-primary">Pay now</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal"
                            class="btn btn-primary">Fund your wallet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('dashboard.hotel.guest.wallet.credit', ['guest' => optional($order->guest)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');

        amountInput.addEventListener('input', function() {
            let inputVal = this.value;

            // Remove all non-numeric characters except the decimal point
            inputVal = inputVal.replace(/[^0-9.]/g, '');

            // Split the value at the decimal point, if it exists
            const parts = inputVal.split('.');

            // Format the integer part with commas
            if (parts[0]) {
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            // Join the integer and decimal parts, if present
            this.value = parts.join('.');
            // this.value.replace(/,/g, '');
            // console.log(inputVal);

        });

        // Ensure proper format before form submission
        document.getElementById('payWithWallet').addEventListener('submit', function() {
            // Remove commas before submitting the form
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\restaurant-item\order\guest-wallet-modal.blade.php ENDPATH**/ ?>