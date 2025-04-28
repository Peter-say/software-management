<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        const cardPaymentForm = document.getElementById('card-payment-form');
        const paymentSelect = document.getElementById('payment-option');
        const stripePayment = document.getElementById('stripe-payment');
        const paymentMethod = document.getElementById('payment-method');
        const stripeCardContainer = document.getElementById('stripe-card');
        const stripeTokenInput = document.getElementById('stripe-token');
        const paymentTitle = document.getElementById('payment-title');
        const form = document.getElementById('paymentInitiate');
        const amountInputJQ = $('#amount');
        const amountInputJS = document.getElementById('amount');
        const payableAmount = parseFloat(document.getElementById('payable-amount')?.value?.replace(/,/g, '') || 0);
        const paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;
        const requestedRoom = getUrlParameter('requested_payment_id');
        let stripe = null;
        let elements = null;
        let card = null;
    
     // ================================
        // Initialize Stripe (Only Once)
        // ================================
        function initializeStripe() {
    if (!stripe && paymentPlatform && paymentPlatform.slug === 'stripe') {
        stripe = Stripe(paymentPlatform.public_key);
        elements = stripe.elements();
    }

    if (!card && (document.getElementById('card-element') || walletCardElementContainer)) {
        card = elements.create('card', { hidePostalCode: true });
            card.mount('#card-element');
    }
}

        // Call the initialization function
        initializeStripe();

        // ================================
        // Update Payment UI Based on Method
        // ================================
        function updatePaymentDisplay(method) {
    paymentMethod.value = method;

    if (method === 'CARD') {
        paymentTitle.innerText = 'Card Payment';
        stripeCardContainer.style.display = 'block';
        card.unmount(); // unmount before remounting
        card.mount('#card-element');
    } else {
        paymentTitle.innerText = 'Cash Payment';
        stripeCardContainer.style.display = 'none';
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
            paymentMethod.value = paymentSelect.value;
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
            amountInputJS.value = amountInputJS.value.replace(/,/g, '');

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
                stripeTokenInput.value = '';
            }
        });

    });
</script><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views/dashboard/general/payment/payment-platform-script.blade.php ENDPATH**/ ?>