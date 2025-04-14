<!-- Button trigger modal -->
@php
    $date = Date('d/m/y');
@endphp
<div class="modal fade" id="Pay-with-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="Pay-with-wallet-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mr-2" id="payment-title"></h5>
                <div class="col-6">
    <select class="form-select" id="payment-option" name="payment-option">
        <option value="WALLET" selected>WALLET</option>
        <option value="CASH">CASH</option>
        <option value="CARD">CARD</option>
    </select>
     </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.hotel.pay-with-guest-wallet') }}" id="payWithWallet" method="post">
                @csrf
                <div class="modal-body">
                    <div class="modal-body text-dark">
                        <div class="d-flex justify-content-between">
                            <div id="wallet-balance">
                                <p>Current balance</p>
                                <p>
                                    <span><b>{{currencySymbol()}}{{ number_format($reservation->guest->wallet->balance, 2) }}</b></span>
                                </p>
                            </div>
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

                        <div class="col-12 m-3">
                            <div class="form-group">
                                <label for="amount">How Much Do You Want To Pay?</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" placeholder="Enter Amount" required>
                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                         <!-- Stripe Card Element -->
                    <div class="col-12 m-3">
                        <div class="form-group" id="stripe-card">
                            <label for="card-element">Credit or Debit Card</label>
                            <div id="card-element"  class="form-control"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                        <div class="col-12 m-3">
                            <div class="form-group">
                                <label id="description" for="">Comment</label>
                                <textarea class="form-control @error('description') @enderror" name="description" id="" cols="5"
                                    rows="2" placeholder="Enter payment comment if any">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name="stripeToken" id="stripe-token">
                    <input type="hidden" name="stripe_payment" id="fund-wallet-method" value="Stripe">
                        <input type="hidden" name="payment_method" id="payment-method" value="">
                        <input type="hidden" name="hotel_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        @if ($reservation->total_amount > ($reservation->payments() ?? collect())->sum('amount'))
                            <input type="hidden" name="payables[0][payable_id]" value="{{ $reservation->id }}">
                            <input type="hidden" name="payables[0][payable_type]"
                                value="{{ get_class($reservation) }}">
                            <input type="hidden" name="payables[0][payable_amount]"
                                value="{{ $reservation->total_amount }}">
                        @endif

                        @if ($reservation->guest->restaurantOrders || $reservation->guest->barOrders)
                            @php $index = 1; @endphp
                            @foreach ($reservation->guest->restaurantOrders->where('status', 'Open') as $restaurant_order)
                                @if ($restaurant_order->paymentStatus('pending'))
                                    <input type="hidden" name="payables[{{ $index }}][payable_id]"
                                        value="{{ $restaurant_order->id }}">
                                    <input type="hidden" name="payables[{{ $index }}][payable_type]"
                                        value="{{ get_class($restaurant_order) }}">
                                    <input type="hidden" name="payables[{{ $index }}][payable_amount]"
                                        value="{{ $restaurant_order->total_amount }}">
                                    @php $index++; @endphp
                                @endif
                            @endforeach
                            @foreach ($reservation->guest->barOrders->where('status', 'Open') as $bar_order)
                                @if ($bar_order->paymentStatus('pending'))
                                    <input type="hidden" name="payables[{{ $index }}][payable_id]"
                                        value="{{ $bar_order->id }}">
                                    <input type="hidden" name="payables[{{ $index }}][payable_type]"
                                        value="{{ get_class($bar_order) }}">
                                    <input type="hidden" name="payables[{{ $index }}][payable_amount]"
                                        value="{{ $bar_order->total_amount }}">
                                    @php $index++; @endphp
                                @endif
                            @endforeach
                        @endif
                        <input type="hidden" name="amount_due"
                            value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
                        <button type="submit" class="btn btn-primary">Pay now</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal"
                            class="btn btn-primary" id="fund-wallet">Fund your wallet</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@include('dashboard.general.payment.payment-platform-script')
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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.getElementById('payment-option');
        const paymentMethod = document.getElementById('payment-method');
        const stripeField = document.getElementById('stripe-card');
        const stripeTokenInput = document.getElementById('stripe-token');
        const fundWalletMethodInput = document.getElementById('fund-wallet-method');
        const walletBalance = document.getElementById('wallet-balance');
        const paymentTitle = document.getElementById('payment-title');
        const fundWallet = document.getElementById('fund-wallet');

        function updatePaymentMethodDisplay(method) {
            paymentSelect.value = method;
             console.log(paymentSelect, 'hello');
             
            switch (method) {
                case 'WALLET':
                    paymentTitle.innerText = 'Wallet Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'block';
                      fundWallet.style.display = 'block'
                      paymentMethod.value = 'WALLET'
                    stripeTokenInput.value = '';
                    break;

                case 'CASH':
                    paymentTitle.innerText = 'Cash Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'none';
                    fundWallet.style.display = 'none'
                     paymentMethod.value = 'CASH'
                    stripeTokenInput.value = '';
                    break;

                case 'CARD':
                    paymentTitle.innerText = 'Card Payment';
                    stripeField.style.display = 'block';
                    walletBalance.style.display = 'none';
                      fundWallet.style.display = 'none'
                       paymentMethod.value = 'CARD'
                    stripeTokenInput.setAttribute('value', 'step-token');
                    break;

                default:
                paymentTitle.textContent = 'Wallet Payment';
                    stripeField.style.display = 'none';
                    walletBalance.style.display = 'block';
                    stripeTokenInput.value = '';
                    break;
            }
        }
        updatePaymentMethodDisplay(paymentSelect.value);
        paymentSelect.addEventListener('change', function () {
            updatePaymentMethodDisplay(this.value);
        });
    });
</script>
