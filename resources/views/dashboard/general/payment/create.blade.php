@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles d-flex justify-content-between align-items-center">
                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-0 col-auto">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('dashboard.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Payment</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Pay</a>
                    </li>
                </ol>

                <!-- Go Back Button -->
                <div class="col-auto">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Title and Payment Option Row -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 id="payment-title" class="mb-0">Card Payment</h5>
                        <div class="d-flex align-items-center">
                            <select class="form-select w-auto ms-3" id="payment-option" name="payment_option">
                                <option value="CARD">CARD</option>
                                <option value="CASH">CASH</option>
                            </select>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal"
                                data-bs-target="#Pay-with-wallet-modal">
                                <i class="fas fa-wallet"></i> Pay with Wallet
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form id="paymentInitiate" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <div>
                                <p>Payment Due</p>
                                @if (isset($reservation))
                                    <p>
                                        <b>{{ currencySymbol() }}{{ number_format(
                                            $reservation->total_amount +
                                                $reservation->guest->calculateOrderNetTotal() -
                                                (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()),
                                            2,
                                        ) }}
                                        </b>
                                        <input type="hidden" id="main-payable-amount" name="payable-amount"
                                            value="{{ $reservation->total_amount +
                                                $reservation->guest->calculateOrderNetTotal() -
                                                (($reservation->payments() ?? collect())->sum('amount') + $reservation->guest->paidTotalOrders()) }}">
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">How Much Do You Want To Pay?</label>
                            <input type="text" class="form-control" id="main-amount" name="amount"
                                placeholder="Enter Amount" required>
                        </div>

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

                        <div id="stripe-card" class="mb-3">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Comment</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter comment if any"></textarea>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="stripeToken" id="stripe-token">
                        <input type="hidden" name="stripe_payment" id="stripe-payment" value="Stripe">
                        <input type="hidden" name="payment_method" id="main-payment-method">
                        <input type="hidden" name="hotel_id" value="{{ auth()->user()->id }}">
                        @include('dashboard.general.payment.payable-details', [
                            'reservation' => $reservation,
                        ])
                        <input type="hidden" name="amount_due"
                            value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
                        <button type="submit" class="btn btn-primary" id="pay-now">Pay Now</button>
                        <button type="reset" class="btn btn-secondary">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.hotel.room.reservation.pay-with-wallet-modal')
    @include('dashboard.general.payment.payment-platform-script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const walletButton = document.getElementById('loadWalletModal');
            const walletModal = new bootstrap.Modal(document.getElementById('Pay-with-wallet-modal'));

            walletButton.addEventListener('click', function() {
                walletModal.show();
            });
        });
    </script>
@endsection
