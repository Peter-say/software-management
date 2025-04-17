<!-- Payment Modal -->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog"
    aria-labelledby="payment-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title me-2" id="payment-title">Card Payment</h5>

                <div class="col-6">
                    <select class="form-select" id="payment-option" name="payment-option">
                        <option value="CARD">CARD</option>
                        <option value="CASH">CASH</option>
                    </select>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.payments.initiate') }}" id="paymentInitiate" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Payment Due</p>
                            <p>
                                <b>{{currencySymbol()}}{{ number_format(
                                        $reservation->total_amount +
                                            $reservation->guest->calculateOrderNetTotal() -
                                            (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()),
                                        2,
                                    ) }}
                                </b>
                                <input type="hidden" id="payable-amount" name="payable-amount"
                                    value="{{ $reservation->total_amount +
                                            $reservation->guest->calculateOrderNetTotal() -
                                            (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()) }}">
                            </p>
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
                            class="form-control @error('currency') is-invalid @enderror">
                            @php $currency = getHotelCurrency(); @endphp
                            <option value="{{ $currency->short_name }}"
                                {{ old('currency', $currency->short_name) == $currency->short_name ? 'selected' : '' }}>
                                {{ $currency->short_name }}
                            </option>
                        </select>
                        @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <input type="hidden" name="payment_method" id="payment-method" value="">
                    <input type="hidden" name="hotel_id" value="{{ auth()->user()->id }}">
                    @include('dashboard.general.payment.payable-details')
                    <input type="hidden" name="amount_due"
                        value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
                    <button type="submit" class="btn btn-primary" id="pay-now">Pay Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.general.payment.payment-platform-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentSelect = document.getElementById('payment-option');
        const paymentMethod = document.getElementById('payment-method');
        const stripeField = document.getElementById('stripe-card');
        const stripeTokenInput = document.getElementById('stripe-token');
        const walletBalance = document.getElementById('wallet-balance');
        const paymentTitle = document.getElementById('payment-title');
        const form = document.getElementById('paymentInitiate');

        function updatePaymentMethodDisplay(method) {
            paymentSelect.value = method;
            console.log('Submitting form with method:', paymentMethod.value);
            switch (method) {
                case 'CARD':
                    paymentTitle.innerText = 'Card Payment';
                    stripeField.style.display = 'block';
                    paymentMethod.value = 'CARD';
                    stripeTokenInput.value = 'step-token';
                    break;
                case 'CASH':
                    paymentTitle.innerText = 'Cash Payment';
                    stripeField.style.display = 'none';
                    paymentMethod.value = 'CASH';
                    stripeTokenInput.value = '';
                    break;
            }
        }

        updatePaymentMethodDisplay(paymentSelect.value);

        paymentSelect.addEventListener('change', function() {
            updatePaymentMethodDisplay(this.value);
        });

        form.addEventListener('submit', function() {
            console.log("Setting payment_method value to:", paymentSelect
                .value);
            paymentMethod.value = paymentSelect.value; 
        });

    });
</script>