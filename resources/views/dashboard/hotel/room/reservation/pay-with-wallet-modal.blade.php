<!-- Button trigger modal -->
@php
    $date = Date('d/m/y');
@endphp
<div class="modal fade" id="Pay-with-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="Pay-with-wallet-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Pay-with-wallet-modal">Wallet Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.hotel.pay-with-guest-wallet') }}" id="payWithWallet" method="post">
                @csrf
                <div class="modal-body">
                    <div class="modal-body text-dark">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p>Current balance</p>
                                <p>
                                    <span><b>₦{{ number_format($reservation->guest->wallet->balance) }}</b></span>
                                </p>
                            </div>

                            <div>
                                <p>Payment Due</p>
                                <p>
                                    <b>₦{{ number_format($reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments()?->sum('amount') ?? 0), 3) }}
                                    </b>
                                    <input type="hidden" id="payable-amount" name="payable-amount"
                                        value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
                                </p>
                            </div>
                        </div>

                        <div class="col-12 m-3">
                            <div class="form-group">
                                <label for="amount">How Much Do You Want To Pay?</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" placeholder="Enter Amount">
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
                        <input type="hidden" name="payment_method" id="wallet-payment-method" value="WALLET">
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
                            @foreach ($reservation->guest->restaurantOrders as $restaurant_order)
                                <input type="hidden" name="payables[{{ $index }}][payable_id]"
                                    value="{{ $restaurant_order->id }}">
                                <input type="hidden" name="payables[{{ $index }}][payable_type]"
                                    value="{{ get_class($restaurant_order) }}">
                                <input type="hidden" name="payables[{{ $index }}][payable_amount]"
                                    value="{{ $restaurant_order->total_amount }}">
                                @php $index++; @endphp
                            @endforeach
                            @foreach ($reservation->guest->barOrders as $bar_order)
                                <input type="hidden" name="payables[{{ $index }}][payable_id]"
                                    value="{{ $bar_order->id }}">
                                <input type="hidden" name="payables[{{ $index }}][payable_type]"
                                    value="{{ get_class($bar_order) }}">
                                <input type="hidden" name="payables[{{ $index }}][payable_amount]"
                                    value="{{ $bar_order->total_amount }}">
                                @php $index++; @endphp
                            @endforeach
                        @endif
                        <input type="hidden" name="amount_due"
                            value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
                        <button type="submit" class="btn btn-primary">Pay now</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal"
                            class="btn btn-primary">Fund your wallet</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInputJQ = $('#amount'); // jQuery version
        const amountInputJS = document.getElementById('amount'); // Plain JavaScript version
        const payableAmount = parseFloat($('#payable-amount').val());

        // Handle input event with jQuery
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

        // Handle input formatting with plain JavaScript
        amountInputJS.addEventListener('input', function () {
            let inputVal = this.value.replace(/[^0-9.]/g, '');
            const parts = inputVal.split('.');
            if (parts[0]) {
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            this.value = parts.join('.');
        });

        // Ensure proper format before form submission
        document.getElementById('payWithWallet').addEventListener('submit', function () {
            amountInputJQ.val(amountInputJQ.val().replace(/,/g, ''));
        });
    });
</script>

