<!-- Button trigger modal -->

<!-- Payment Modal -->

<div class="modal fade" id="payment-modal-<?php echo e($payableModel->id); ?>" tabindex="-1" role="dialog"
    aria-labelledby="payment-modal-<?php echo e($payableModel->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pay with Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo e(route('dashboard.payments.pay-with-card')); ?>" id="payWithCard" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Amount Input -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">How Much Do You Want To Fund?</label>
                        <input type="text" class="form-control" id="amount" name="amount"
                            placeholder="Enter Amount" required>
                    </div>

                    <!-- Currency Selection -->
                    <div class="mb-3">
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
                            <?php
                            $currency = getHotelCurrency();
                        ?>
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

                    <!-- Comment Section -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Comment</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter comment if any"></textarea>
                    </div>

                    <!-- Stripe Card Element -->
                    <div class="mb-3">
                        <label for="card-element" class="form-label">Credit or Debit Card</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="stripeToken" id="stripe-token">
                    <input type="hidden" name="stripe_payment" id="fund-wallet-method" value="Stripe">
                    <input type="hidden" name="payment_method" id="fund-wallet-method" value="CARD">
                    <input type="hidden" name="payable_id" value="<?php echo e($payableModel->id); ?>">
                    <input type="hidden" name="payable_type" value="<?php echo e($payableType); ?>">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        });

        // Ensure proper format before form submission
        document.getElementById('payWithCard').addEventListener('submit', function() {
            // Remove commas before submitting the form
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;
    console.log(paymentPlatform);
    
    if (paymentPlatform) {
        if (paymentPlatform.payment_platform.slug === 'stripe') {
            var stripe = Stripe(paymentPlatform.public_key);
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            document.getElementById('payWithCard').addEventListener('submit', function(event) {
                event.preventDefault();
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Show error in payment form
                        console.error(result.error.message);
                        Toastify({
                            text: result.error.message,
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    } else {
                        // Send token to your server
                        document.getElementById('stripe-token').value = result.token.id;
                        event.target.submit();
                    }
                });
            });
        } else if (paymentPlatform.name === 'flutterwave') {
            // Initialize Flutterwave payment logic
            console.log('Flutterwave selected');
        } else if (paymentPlatform.name === 'paystack') {
            // Initialize Paystack payment logic
            console.log('Paystack selected');
        } else {
            console.warn('No valid payment platform selected');
        }
    } else {
        Toastify({
            text: 'No payment platform found. You have to set up a payment platform to use this feature. go to settings and set up a payment platform',
             duration: 5000,
             gravity: 'top',
             position: 'right',
             backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
             }).showToast();
    }
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/general/payment/modal.blade.php ENDPATH**/ ?>