<!-- Button trigger modal -->
@include('notifications.flash-messages')

<div class="modal fade" id="fund-guest-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="fund-guest-wallet-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund Guest Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('dashboard.hotel.fund-guest-wallet') }}" id="fundGuestWallet" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="amount">How Much Do You Want To Fund?</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                        </div>
                    </div>
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="description">Comment</label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="2" placeholder="Enter comment if any"></textarea>
                        </div>
                    </div>

                    <!-- Stripe Card Element -->
                    <div class="col-12 m-3">
                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <!-- Hidden field to store Stripe token -->
                    <input type="hidden" name="stripeToken" id="stripe-token">

                    <div class="modal-footer">
                        <input type="hidden" name="payment_method" id="fund-wallet-method" value="WALLET">
                        <input type="hidden" name="hotel_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                        <input type="hidden" name="payable_type" value="{{ get_class($guest) }}">

                        <button type="submit" class="btn btn-primary">Fund Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
        document.getElementById('fundGuestWallet').addEventListener('submit', function() {
            // Remove commas before submitting the form
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });a
</script>
{{-- <script src="https://js.stripe.com/v3/"></script> --}}
<script>
    var stripe = Stripe('{{config('app.stripe_key')}}');
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element'); // Create a div with this id in your modal

    document.getElementById('fund-guest-wallet-modal').addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Show error in payment form
                console.error(result.error.message);
            } else {
                // Send token to your server
                document.getElementById('stripe-token').value = result.token.id;
                event.target.submit();
            }
        });
    });
</script>