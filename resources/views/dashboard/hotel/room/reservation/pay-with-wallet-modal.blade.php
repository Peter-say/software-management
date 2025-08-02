<!-- Pay with Wallet Modal -->
<div class="modal fade" id="Pay-with-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="Pay-with-wallet-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mr-2">Pay With Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.hotel.pay-with-guest-wallet') }}" id="walletPaymentForm" method="post">
                @csrf
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
                                    2
                                ) }}
                                </b>
                                <input type="hidden" id="wallet-payable-amount" name="wallet_payable_amount"
                                       value="{{ $reservation->total_amount +
                                           $reservation->guest->calculateOrderNetTotal() -
                                           (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()) }}">
                            </p>
                        </div>
                    </div>

                    <!-- Amount Input -->
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="wallet-amount">How Much Do You Want To Pay?</label>
                            <input type="text" class="form-control @error('wallet_amount') is-invalid @enderror"
                                   id="wallet-amount" name="wallet_amount" placeholder="Enter Amount" required>
                            @error('wallet_amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="wallet-description">Comment</label>
                            <textarea class="form-control @error('wallet_description') is-invalid @enderror"
                                      name="wallet_description" id="wallet-description" cols="5" rows="2"
                                      placeholder="Enter payment comment if any">{{ old('wallet_description') }}</textarea>
                            @error('wallet_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="wallet_payment_method" value="Wallet">
                    <input type="hidden" name="wallet_hotel_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="wallet_reservation_id" value="{{ $reservation->id }}">
                    <input type="hidden" name="wallet_amount_due"
                           value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">

                    <button type="submit" class="btn btn-primary">Pay now</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal"
                            class="btn btn-primary" id="fund-wallet">Fund your wallet</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
(function() {
    const walletForm = document.getElementById('walletPaymentForm');
    const walletAmountInput = document.getElementById('wallet-amount');
    const walletPayableAmount = parseFloat(document.getElementById('wallet-payable-amount')?.value?.replace(/,/g,'') || 0);

    // Format and validate input
    $(walletAmountInput).on('input', function() {
        let rawValue = this.value.replace(/,/g, '');
        let enteredAmount = parseFloat(rawValue || 0);

        if (enteredAmount > walletPayableAmount) {
            Toastify({
                text: `You cannot pay more than ₦${walletPayableAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}.`,
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
            }).showToast();

            this.value = walletPayableAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            this.value = (isNaN(enteredAmount) ? '' : enteredAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }
    });

    // Clean input before submit
    walletForm.addEventListener('submit', function(e) {
        walletAmountInput.value = walletAmountInput.value.replace(/,/g, '');
    });

})();
</script>
