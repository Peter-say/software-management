<!-- Payment Modal -->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog"
    aria-labelledby="payment-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title me-2" id="payment-title">Card Payment</h5>

                <div class="col-6">
                    <select class="form-select" id="payment-option" name="payment_option">
                        <option value="CARD">CARD</option>
                        <option value="CASH">CASH</option>
                    </select>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('dashboard.payments.initiate')); ?>" id="paymentInitiate" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Payment Due</p>
                            
                        </div>
                    </div>
                    <!-- Amount Input -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">How Much Do You Want To Pay?</label>
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount"
                            required>
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
                    <div class="mb-3">
                        <div id="stripe-card">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>
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
                    <input type="hidden" name="payment_method" id="payment-method">
                    <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                    
                    <button type="submit" class="btn btn-primary" id="pay-now">Pay Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.getElementById('payment-option');
        const paymentMethod = document.getElementById('payment-method');
        const stripeCardContainer = document.getElementById('stripe-card');
        const stripeTokenInput = document.getElementById('stripe-token');
        const paymentTitle = document.getElementById('payment-title');
        const form = document.getElementById('paymentInitiate');
        const amountInputJQ = $('#amount');
        const amountInputJS = document.getElementById('amount');
        const payableAmount = parseFloat(document.getElementById('payable-amount')?.value?.replace(/,/g, '') || 0);
        const paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;

        let stripe = null;
        let elements = null;
        let card = null;

        // ================================
        // Initialize Stripe (Only Once)
        // ================================
        function initializeStripe() {
            if (stripe || !paymentPlatform || paymentPlatform.slug !== 'stripe') return;

            stripe = Stripe(paymentPlatform.public_key);
            elements = stripe.elements();
            card = elements.create('card');
            card.mount('#card-element');
        }

        // ================================
        // Update Payment UI Based on Method
        // ================================
        function updatePaymentDisplay(method) {
            paymentMethod.value = method;

            if (method === 'CARD') {
                paymentTitle.innerText = 'Card Payment';
                stripeCardContainer.style.display = 'block';
                stripeTokenInput.value = 'step-token';
                initializeStripe();
            } else {
                paymentTitle.innerText = 'Cash Payment';
                stripeCardContainer.style.display = 'none';
                stripeTokenInput.value = '';
            }
        }

        // Initial Load
        updatePaymentDisplay(paymentSelect.value);

        // On Payment Option Change
        paymentSelect.addEventListener('change', function () {
            updatePaymentDisplay(this.value);
        });

        // ================================
        // Amount Input Formatting
        // ================================
        amountInputJQ.on('input', function () {
            let enteredAmount = parseFloat(this.value.replace(/,/g, '') || 0);
            if (enteredAmount > payableAmount) {
                Toastify({
                    text: `You cannot pay more than ₦${payableAmount.toLocaleString()}.`,
                    duration: 5000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                }).showToast();
                this.value = payableAmount.toLocaleString();
            } else {
                this.value = enteredAmount.toLocaleString();
            }
        });

        amountInputJS.addEventListener('input', function () {
            let inputVal = this.value.replace(/[^0-9.]/g, '');
            const parts = inputVal.split('.');
            if (parts[0]) {
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            this.value = parts.join('.');
        });

        // ================================
        // Stripe + Form Submit
        // ================================
        form.addEventListener('submit', function (e) {
            // Set payment method to selected option
            paymentMethod.value = paymentSelect.value;
console.log(paymentSelect.value);
            // Clean amount input
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
            amountInputJS.value = amountInputJS.value.replace(/,/g, '');

            // Check if platform is Stripe
            if (paymentSelect.value === 'CARD' && paymentPlatform.slug === 'stripe') {
                e.preventDefault();
                document.getElementById('form-preloader')?.style?.setProperty('display', 'flex');

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        document.getElementById('form-preloader')?.style?.setProperty('display', 'none');
                        document.getElementById('card-errors').textContent = result.error.message;
                    } else {
                        stripeTokenInput.value = result.token.id;
                        form.submit();
                    }
                });
            } else {
                // If not Stripe, allow form to submit normally
                stripeTokenInput.value = '';
            }
        });
    });
</script>

<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\general\payment\modal.blade.php ENDPATH**/ ?>