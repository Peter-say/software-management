<!-- Button trigger modal -->
<style>
    #form-preloader {
        display: none;
        /* Hidden by default */
        position: fixed;
        top: 50%;
        left: 50%;
        align-items: center;
        justify-content: center;
        transform: translate(-50%, -50%);
        z-index: 9999;
        /* background: rgba(255, 255, 255, 0.8); */
        /* Optional: semi-transparent background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #form-preloader .lds-ripple {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }

    #form-preloader .form-lds-ripple div {
        position: absolute;
        border: 4px solid var(--primary);
        opacity: 1;
        border-radius: 50%;
        animation: form-lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    #form-preloader .form-lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes form-lds-ripple {
        0% {
            top: 28px;
            left: 28px;
            width: 0;
            height: 0;
            opacity: 1;
        }

        100% {
            top: 0;
            left: 0;
            width: 56px;
            height: 56px;
            opacity: 0;
        }
    }
</style>

<div class="modal fade" id="fund-guest-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="fund-guest-wallet-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund Guest Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo e(route('dashboard.hotel.fund-guest-wallet')); ?>" id="fundGuestWallet" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Amount Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="amount">How Much Do You Want To Fund?</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" required>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="currency" class="form-label">Currency</label>
                                <select id="currency" name="currency" readonly required
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
                        </div>
                    </div>
                    <!-- Stripe Card Element -->
                    <div class="mb-3">
                        <div id="stripe-card">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>
                    </div>
                    <!-- Comment Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Comment</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2"
                                    placeholder="Enter comment if any"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Preloader -->
                    <div id="form-preloader" class="row mb-3 text-center">
                        <div class="col-12">
                            <div class="form-lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="stripeToken" id="stripe-token">
                    <input type="hidden" name="stripe_payment" id="fund-wallet-method" value="Stripe">
                    <input type="hidden" name="payment_method" id="fund-wallet-method" value="CARD">
                    <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                    <input type="hidden" name="guest_id" value="<?php echo e($guest->id); ?>">
                    <input type="hidden" name="payable_id" value="<?php echo e($guest->id); ?>">
                    <input type="hidden" name="payable_type" value="<?php echo e(get_class($guest)); ?>">

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Fund Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php echo $__env->make('dashboard.general.form-preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;
    if (paymentPlatform) {
        if (paymentPlatform.slug === 'stripe') {
            var stripe = Stripe(paymentPlatform.public_key);
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            document.getElementById('paymentInitiate').addEventListener('submit', function(event) {
                event.preventDefault();
                document.getElementById('form-preloader').style.display = 'flex';

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        console.error(result.error.message);
                        document.getElementById('form-preloader').style.display = 'none';
                    } else {
                        document.getElementById('stripe-token').value = result.token.id;
                        event.target.submit();
                    }
                });
            });
        } else if (paymentPlatform.slug === 'flutterwave') {
            // Initialize Flutterwave payment logic
            console.log('Flutterwave selected');
        } else if (paymentPlatform.slug === 'paystack') {
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInputJQ = $('#amount'); // jQuery version
        const amountInputJS = document.getElementById('amount'); // Plain JavaScript version
        const payableAmount = parseFloat($('#payable-amount').val());

        // Handle input event with jQuery
        amountInputJQ.on('input', function() {
            let enteredAmount = parseFloat(this.value.replace(/,/g, '') || 0);
            alert(enteredAmount)
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

        // Handle input formatting with plain JavaScript
        amountInputJS.addEventListener('input', function() {
            let inputVal = this.value.replace(/[^0-9.]/g, '');
            const parts = inputVal.split('.');
            if (parts[0]) {
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            this.value = parts.join('.');
        });

        // Ensure proper format before form submission
        document.getElementById('payWithWallet').addEventListener('submit', function() {
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
        });
        document.getElementById('paymentInitiate').addEventListener('submit', function() {
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
        });
        document.getElementById('fundGuestWallet').addEventListener('submit', function() {
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });
</script><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/hotel/guest/wallet/credit.blade.php ENDPATH**/ ?>