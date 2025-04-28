<!-- Button trigger modal -->
<style>
    #form-preloader {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        align-items: center;
        justify-content: center;
        transform: translate(-50%, -50%);
        z-index: 9999;
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

<div class="modal fade" id="fund-guest-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="fund-guest-wallet-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund Guest Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo e(route('dashboard.hotel.fund-guest-wallet')); ?>" id="walletPaymentForm" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Amount Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="amount">How Much Do You Want To Fund?</label>
                                <input type="text" class="form-control" id="wallet-amount" name="amount" placeholder="Enter Amount" required>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="currency" class="form-label">Currency</label>
                                <select id="currency" name="currency" readonly required class="form-control <?php $__errorArgs = ['currency'];
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
                                    <option value="<?php echo e($currency->short_name); ?>" <?php echo e(old('currency', $currency->short_name ?? '') == $currency->short_name ? 'selected' : ''); ?>>
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

                    <!-- Stripe Card -->
                    <div id="wallet-stripe-card" class="mb-3">
                        <div id="wallet-card-element" class="form-control"></div>
                        <div id="wallet-card-errors" role="alert" class="text-danger mt-2"></div>
                    </div>

                    <!-- Comment Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Comment</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2" placeholder="Enter comment if any"></textarea>
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
                    <input type="hidden" name="stripeToken" id="stripe-wallet-token">
                    <input type="hidden" name="stripe_payment" id="stripe-payment-method" value="Stripe">
                    <input type="hidden" name="payment_method" id="payment-method" value="CARD">
                    <input type="hidden" name="hotel_id" value="<?php echo e(auth()->user()->id); ?>">
                    <input type="hidden" name="guest_id" value="<?php echo e(isset($guest) ? $guest->id : ''); ?>">
                    <input type="hidden" name="payable_id" value="<?php echo e(isset($guest) ? $guest->id : ''); ?>">
                    <input type="hidden" name="payable_type" value="<?php echo e(isset($guest) ? get_class($guest) : ''); ?>">

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

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const walletPaymentForm = document.getElementById('walletPaymentForm');
        const walletCardElementContainer = document.getElementById('wallet-card-element');
        const stripeTokenInputWallet = document.getElementById('stripe-wallet-token');
        const formPreloader = document.getElementById('form-preloader');
        const amountInputJQ = $('#wallet-amount');
        const amountInputJS = document.getElementById('wallet-amount');
        const paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;
        let stripe = null;
        let elements = null;
        let walletCard = null;

        if (!stripe && paymentPlatform && paymentPlatform.slug === 'stripe') {
            stripe = Stripe(paymentPlatform.public_key);
            elements = stripe.elements();
            walletCard = elements.create('card');
            walletCard.mount('#wallet-card-element');
        }
        amountInputJS.addEventListener('input', function () {
            let inputVal = this.value.replace(/[^0-9.]/g, '');
            const parts = inputVal.split('.');
            if (parts[0]) {
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            this.value = parts.join('.');
        });
        walletPaymentForm.addEventListener('submit', function (e) {
            e.preventDefault();
            formPreloader.style.display = 'flex';
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
            amountInputJS.value = amountInputJS.value.replace(/,/g, '');
            stripe.createToken(walletCard).then(function (result) {
                if (result.error) {
                    const errorElement = document.getElementById('wallet-card-errors');
                    errorElement.textContent = result.error.message;
                    formPreloader.style.display = 'none';
                } else {
                    stripeTokenInputWallet.value = result.token.id;
                    walletPaymentForm.submit();
                }
            });
        });
    });
</script>
<?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/hotel/guest/wallet/credit.blade.php ENDPATH**/ ?>