<!-- Button trigger modal -->
@php
    $date = Date('d/m/y');
@endphp
<div class="modal fade" id="Pay-with-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="Pay-with-wallet-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mr-2">Pay With Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.hotel.pay-with-guest-wallet') }}" id="payWithWallet" method="post">
                @csrfa
                <div class="modal-body">
                    <div class="modal-body text-dark">
                        <div class="d-flex justify-content-between">
                            <div id="wallet-balance">
                                <p>Current balance</p>
                                <p>
                                    <span><b>{{ currencySymbol() }}{{ number_format($reservation->guest->wallet->balance, 2) }}</b></span>
                                </p>
                            </div>
                            <div>
                                <p>Payment Due</p>
                                <p>
                                    <b>{{ currencySymbol() }}{{ number_format(
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
                        @include('dashboard.general.payment.payable-details')
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
{{-- @include('dashboard.general.payment.payment-platform-script') --}}

<script>
    const amountInputJQ = $('#amount');
    const amountInputJS = document.getElementById('amount');
    const payableAmount = parseFloat(document.getElementById('payable-amount')?.value?.replace(/,/g, '') || 0);
    const form = document.getElementById('payWithWallet');
    // ================================
    // Amount Input Formatting
    // ================================
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
    amountInputJS.addEventListener('input', function() {
        let inputVal = this.value.replace(/[^0-9.]/g, '');
        const parts = inputVal.split('.');
        if (parts[0]) {
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
        this.value = parts.join('.');
    });
    form.addEventListener('submit', function(e) {
        amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
        amountInputJS.value = amountInputJS.value.replace(/,/g, '');

    });
</script>
