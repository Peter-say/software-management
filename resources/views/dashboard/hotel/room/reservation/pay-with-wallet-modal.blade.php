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
                                    <b>₦{{ number_format($reservation->total_amount - ($reservation->payments() ?? collect())->sum('amount')) }}</b>
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
                        <input type="hidden" name="payable_id" value="{{ $reservation->id }}">
                        {{-- <input type="hidden" name="guest_id" value="{{ $reservation->guest->id }}"> --}}
                        <input type="hidden" name="payable_type" value="{{ get_class($reservation) }}">


                        <button type="submit" class="btn btn-primary">Pay
                            now</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal"
                            class="btn btn-primary">Fund your wallet</button>

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
            // this.value.replace(/,/g, '');
            // console.log(inputVal);

        });

        // Ensure proper format before form submission
        document.getElementById('payWithWallet').addEventListener('submit', function() {
            // Remove commas before submitting the form
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    });
</script>
