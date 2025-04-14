<script>
    var paymentPlatform = <?php echo json_encode($payment_platform, 15, 512) ?>;
    if (paymentPlatform) {
        if (paymentPlatform.slug === 'stripe') {
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInputJQ = $('#amount'); // jQuery version
        const amountInputJS = document.getElementById('amount'); // Plain JavaScript version
        const payableAmount = parseFloat($('#payable-amount').val());

        // Handle input event with jQuery
        amountInputJQ.on('input', function() {
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
    });
</script><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\general\payment\payment-platform-script.blade.php ENDPATH**/ ?>