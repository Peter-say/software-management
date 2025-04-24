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
        const paymentPlatform = @json($payment_platform);
        const requestedRoom = getUrlParameter('requested_payment_id');
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
                if (stripeTokenInput) {
        stripeTokenInput.disabled = true; // Disable it to avoid submission
        stripeTokenInput.removeAttribute('name'); // Ensure it's not submitted
        stripePayment.removeAttribute('name');
        stripeTokenInput.value = '';
    }
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
