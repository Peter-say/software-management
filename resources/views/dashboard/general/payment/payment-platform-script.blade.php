<script>
    var paymentPlatform = @json($payment_platform);
    if (paymentPlatform) {
        if (paymentPlatform.payment_platform.slug === 'stripe') {
            var stripe = Stripe(paymentPlatform.public_key);
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            document.getElementById('fund-guest-wallet-modal').addEventListener('submit', function(event) {
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