<!-- Button trigger modal -->

<!-- Payment Modal -->

<div class="modal fade" id="payment-modal-{{ $payableModel->id }}" tabindex="-1" role="dialog"
    aria-labelledby="payment-modal-{{ $payableModel->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pay with Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('dashboard.payments.pay-with-card') }}" id="payWithCard" method="post">
                @csrf
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
                            class="form-control @error('currency') is-invalid @enderror">
                            @php
                            $currency = getHotelCurrency();
                        @endphp
                            <option value="">Select Currency</option>
                                <option value="{{ $currency->short_name }}"
                                    {{ old('currency', $currency->short_name ?? '') == $currency->short_name ? 'selected' : '' }}>
                                    {{ $currency->short_name }}
                                </option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <input type="hidden" name="payable_id" value="{{ $payableModel->id }}">
                    <input type="hidden" name="payable_type" value="{{ $payableType }}">
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
    var paymentPlatform = @json($payment_platform);
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
        console.error('No payment platform found');
    }
</script>
