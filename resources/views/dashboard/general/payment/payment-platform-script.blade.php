<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ======================
        // DOM References
        // ======================
        const form = document.getElementById('paymentInitiate');
        const paymentSelect = document.getElementById('payment-option'); // <-- must match HTML
        const paymentMethodInput = document.getElementById('main-payment-method');
        const stripeTokenInput = document.getElementById('stripe-token');
        const stripeCardContainer = document.getElementById('stripe-card');
        const cardErrors = document.getElementById('card-errors');
        const amountInputJQ = $('#main-amount');
        const amountInputJS = document.getElementById('main-amount');
        const payableAmount = parseFloat(document.getElementById('main-payable-amount')?.value?.replace(/,/g,
            '') || 0);
        const paymentTitle = document.getElementById('payment-title');
        const formPreloader = document.getElementById('form-preloader');
        const paymentPlatform = @json($payment_platform);

        let stripe = null;
        let elements = null;
        let card = null;

        // ======================
        // Initialize Stripe
        // ======================
        function initializeStripe() {
            if (paymentPlatform?.slug === 'stripe') {
                stripe = Stripe(paymentPlatform.public_key);
                elements = stripe.elements();
                card = elements.create('card', {
                    hidePostalCode: true
                });
                card.mount('#card-element');
            }
        }

        // ======================
        // Update UI Based on Method
        // ======================
        function updatePaymentDisplay(method) {
            paymentMethodInput.value = method; // Update hidden field

            if (method === 'CARD') {
                paymentTitle.innerText = 'Card Payment';
                stripeCardContainer.style.display = 'block';
                if (card) card.unmount();
                if (!stripe || !elements || !card) initializeStripe();
                card.mount('#card-element');
            } else {
                paymentTitle.innerText = 'Cash Payment';
                stripeCardContainer.style.display = 'none';
            }
        }

        // ======================
        // Format Amount Input
        // ======================
        amountInputJQ.on('input', function() {
            let rawValue = this.value.replace(/,/g, '');
            let enteredAmount = parseFloat(rawValue || 0);

            if (enteredAmount > payableAmount) {
                Toastify({
                    text: `You cannot pay more than ₦${payableAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}.`,
                    duration: 5000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                }).showToast();

                // ✅ Ensure correct formatting with 2 decimal places
                this.value = payableAmount
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
            } else {
                // ✅ Format entered amount with 2 decimals always
                this.value = (isNaN(enteredAmount) ? '' : enteredAmount
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
            }
        });


        // ======================
        // Form Submission
        // ======================
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Clean the amounts
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
            amountInputJS.value = amountInputJS.value.replace(/,/g, '');

            const selectedMethod = paymentSelect?.value || 'CARD';
            paymentMethodInput.value = selectedMethod;

            const formData = new FormData(form);

            if (selectedMethod === 'CARD' && paymentPlatform?.slug === 'stripe') {
                formPreloader?.style?.setProperty('display', 'flex');

                const result = await stripe.createToken(card);
                if (result.error) {
                    formPreloader?.style?.setProperty('display', 'none');
                    cardErrors.textContent = result.error.message;
                    return;
                }

                formData.append('stripeToken', result.token.id);
            }

            try {
                const response = await fetch(`{{ route('dashboard.payments.initiate') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                            .value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const json = await response.json();

                if (!response.ok) {
                    throw new Error(json.message || 'Payment failed');
                }

                Toastify({
                    text: json?.message || "Payment successful",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    duration: 5000,
                }).showToast();

                form.reset();
                formPreloader?.style?.setProperty('display', 'none');

            } catch (error) {
                Toastify({
                    text: error.message,
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    duration: 6000,
                }).showToast();
                formPreloader?.style?.setProperty('display', 'none');
            }
        });

        // ======================
        // Init
        // ======================
        updatePaymentDisplay(paymentSelect?.value || 'CARD');

        paymentSelect?.addEventListener('change', function() {
            updatePaymentDisplay(this.value);
        });
    });
</script>
