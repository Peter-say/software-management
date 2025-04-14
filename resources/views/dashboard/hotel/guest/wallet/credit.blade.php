<!-- Button trigger modal -->
<style>
    #form-preloader {
        display: none;
        /* Hidden by default */
        position: fixed;
        top: 50%;
        left: 50%;
        align-items: center;
        justify-content: center;
        transform: translate(-50%, -50%);
        z-index: 9999;
        /* background: rgba(255, 255, 255, 0.8); */
        /* Optional: semi-transparent background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #form-preloader .lds-ripple {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }

    #form-preloader .form-lds-ripple div {
        position: absolute;
        border: 4px solid var(--primary);
        opacity: 1;
        border-radius: 50%;
        animation: form-lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    #form-preloader .form-lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes form-lds-ripple {
        0% {
            top: 28px;
            left: 28px;
            width: 0;
            height: 0;
            opacity: 1;
        }

        100% {
            top: 0;
            left: 0;
            width: 56px;
            height: 56px;
            opacity: 0;
        }
    }
</style>

<div class="modal fade" id="fund-guest-wallet-modal" tabindex="-1" role="dialog" aria-labelledby="fund-guest-wallet-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund Guest Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('dashboard.hotel.fund-guest-wallet') }}" id="fundGuestWallet" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Amount Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="amount">How Much Do You Want To Fund?</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" required>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Selection -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="currency" class="form-label">Currency</label>
                                <select id="currency" name="currency" readonly required
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
                        </div>
                    </div>
 <!-- Stripe Card Element -->
 <div class="row mb-3">
                        <div class="col-12">
                            <label for="card-element">Credit or Debit Card</label>
                            <div id="card-element"  class="form-control"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    <!-- Comment Field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Comment</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2"
                                    placeholder="Enter comment if any"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Preloader -->
                    <div id="form-preloader" class="row mb-3 text-center">
                        <div class="col-12">
                            <div class="form-lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="stripeToken" id="stripe-token">
                    <input type="hidden" name="stripe_payment" id="fund-wallet-method" value="Stripe">
                    <input type="hidden" name="payment_method" id="fund-wallet-method" value="CARD">
                    <input type="hidden" name="hotel_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                    <input type="hidden" name="payable_id" value="{{ $guest->id }}">
                    <input type="hidden" name="payable_type" value="{{ get_class($guest) }}">

                    <!-- Modal Footer -->
                    <div class="modal-footer">
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
    });
</script>
@include('dashboard.general.form-preloader')
@include('dashboard.general.payment.payment-platform-script')
<script src="https://js.stripe.com/v3/"></script>

