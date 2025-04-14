<!-- Payment Modal -->
<div class="modal fade" id="payment-modal-<?php echo e($payableModel->id); ?>" tabindex="-1" role="dialog"
    aria-labelledby="payment-modal-<?php echo e($payableModel->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title me-2" id="payment-title">Card Payment</h5>

                <div class="col-6">
                    <select class="form-select" id="payment-option" name="payment-option">
                        <option value="CASH">CASH</option>
                        <option value="CARD" selected>CARD</option>
                    </select>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('dashboard.payments.initiate')); ?>" id="payWithCard" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
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
                                </p>
                            </div>
            </div>
                    <!-- Amount Input -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">How Much Do You Want To Pay?</label>
                        <input type="text" class="form-control" id="amount" name="amount"
                            placeholder="Enter Amount" required>
                    </div>

                    <!-- Currency Selection -->
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
                            <option value="<?php echo e($currency->short_name); ?>"
                                <?php echo e(old('currency', $currency->short_name) == $currency->short_name ? 'selected' : ''); ?>>
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

                    <!-- Stripe Card Element -->
                    <div class="mb-3" id="stripe-card">
                        <label for="card-element" class="form-label">Credit or Debit Card</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                    </div>
                    <!-- Comment Section -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Comment</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                            placeholder="Enter comment if any"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                     <!-- Hidden Fields -->
                     <input type="hidden" name="stripeToken" id="stripe-token">
                    <input type="hidden" name="stripe_payment" value="Stripe">
                    <input type="hidden" name="payment_method" id="payment-method" value="">
                    <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                    <?php echo $__env->make('dashboard.general.payment.payable-details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <input type="hidden" name="amount_due"
                            value="<?php echo e($reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount')); ?>">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('dashboard.general.payment.payment-platform-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInput = document.getElementById('amount');

        // Format amount input
        amountInput.addEventListener('input', function () {
            let inputVal = this.value.replace(/[^0-9.]/g, '');
            const parts = inputVal.split('.');
            if (parts[0]) parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            this.value = parts.join('.');
        });

        // Remove commas before submission
        document.getElementById('payWithCard').addEventListener('submit', function () {
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.getElementById('payment-option');
        const paymentMethod = document.getElementById('payment-method');
        const stripeField = document.getElementById('stripe-card');
        const stripeTokenInput = document.getElementById('stripe-token');
        const walletBalance = document.getElementById('wallet-balance');
        const paymentTitle = document.getElementById('payment-title');
        const fundWallet = document.getElementById('fund-wallet');

        function updatePaymentMethodDisplay(method) {
            paymentSelect.value = method;
console.log( paymentSelect.value);

            switch (method) {
                case 'WALLET':
                    paymentTitle.innerText = 'Wallet Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'block';
                    fundWallet.style.display = 'block';
                    paymentMethod.value = 'WALLET';
                    stripeTokenInput.value = '';
                    break;

                case 'CASH':
                    paymentTitle.innerText = 'Cash Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'none';
                    fundWallet.style.display = 'none';
                    paymentMethod.value = 'CASH';
                    stripeTokenInput.value = '';
                    break;

                case 'CARD':
                    paymentTitle.innerText = 'Card Payment';
                    stripeField.style.display = 'block';
                    walletBalance.style.display = 'none';
                    fundWallet.style.display = 'none';
                    paymentMethod.value = 'CARD';
                    stripeTokenInput.value = 'step-token';
                    break;

                default:
                    paymentTitle.innerText = 'Wallet Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'block';
                    stripeTokenInput.value = '';
                    break;
            }
        }

        updatePaymentMethodDisplay(paymentSelect.value);

        paymentSelect.addEventListener('change', function () {
            updatePaymentMethodDisplay(this.value);
        });
    });
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\general\payment\modal.blade.php ENDPATH**/ ?>