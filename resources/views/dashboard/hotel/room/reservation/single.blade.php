@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a
                            href="{{ route('dashboard.hotel.reservations.index') }}">Reservation</a></li>
                    <li class="breadcrumb-item">Details</li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    @if ($reservation)
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Reservation Invoice</h4>
                            <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
                        </div>
                        <div class="card-body">
                            <!-- Invoice Header -->
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h6>From:</h6>
                                    <p>{{ $reservation->hotel->hotel_name }}</p>
                                    <p>{{ $reservation->hotel->address }}</p>
                                    <p>Phone: {{ $reservation->hotel->phone }}</p>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <h6>To:</h6>
                                    <p>{{ $reservation->guest->full_name }}</p>
                                    <p>{{ $reservation->guest->address }}</p>
                                    <p>Phone: {{ $reservation->guest->phone }}</p>
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <p>Invoice Date: {{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
                                    <p>Reservation Code: {{ $reservation->reservation_code }}</p>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <p>Check-in Date: {{ $reservation->checkin_date }}</p>
                                    <p>Check-out Date: {{ $reservation->checkout_date }}</p>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Rate</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Room: {{ $reservation->room->name }}</td>
                                        <td>{{ number_format($reservation->rate) }}</td>
                                        <td>1</td>
                                        <td>{{ number_format($reservation->total_amount) }}</td>
                                    </tr>
                                    <!-- Add more rows here if there are additional services -->
                                    <tr>
                                        <!-- Room Images -->
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <h6>Room Images:</h6>
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($reservation->room->RoomImages() as $image)
                                                        <div class="me-3 mb-3">
                                                            <img class="rounded"
                                                                src="{{ asset('storage/' . $image->file_path) }}"
                                                                alt="Room Image"
                                                                style="width: 150px; height: 100px; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <td colspan="3" class="text-end">Net Total</td>
                                        <td>{{ number_format($reservation->total_amount) }}</td>
                                    </tr>
                                    @if ($reservation->guest->payments->isNotEmpty())
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Amount</th>
                                        </tr>

                                        @foreach ($reservation->guest->payments as $payment)
                                            <tr>
                                                <td>{{ $payment->created_at }}</td>
                                                <td>{{ $payment->amount }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>

                            <!-- Payment Information -->
                            <div class="row mt-4">
                                <div class="col-sm-6">
                                    <h6>Notes:</h6>
                                    <p>{{ $reservation->notes }}</p>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <p>Payment Status: <strong>{{ strtoupper($reservation->payment_status) }}</strong></p>
                                    <p>Bill Number: {{ $reservation->bill_number }}</p>
                                    <p>
                                        <span>Due </span>
                                        <b>₦{{ number_format($reservation->total_amount - ($reservation->payments() ?? collect())->sum('amount')) }}</b>
                                    </p>
                                    <div class="mt-3">
                                        <label for="payment-method">Select Payment Method:</label>
                                        <select id="payment-method" class="form-select">
                                            @foreach (['BANK TRANSFER', 'CREDIT-CARD,', 'CASH', 'POS', 'WALLET'] as $method)
                                                <option value="{{ $method }}">{{ $method }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-success mt-2">Pay Now</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#checkinModal">Check-in</button>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#checkoutModal">Check-out</button>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            No reservation found
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Check-in Modal -->
    <div class="modal fade" id="checkinModal" tabindex="-1" aria-labelledby="checkinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkinModalLabel">Confirm Check-in</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to check in this guest?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Confirm Check-in</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Check-out Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Confirm Check-out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to check out this guest?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Confirm Check-out</button>
                </div>
            </div>
        </div>
    </div>
    @if ($reservation)
        @include('dashboard.hotel.room.reservation.pay-with-wallet-modal')
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for changes in the select element in the payment method
            paymentMethod = document.getElementById('payment-method')

            paymentMethod.addEventListener('change', function() {
                // Get the selected option

                var selectedOption = this.value;
                console.log(selectedOption);

                // Check if the selected option is "WALLET"
                if (selectedOption === 'WALLET') {
                    // Trigger the modal to show
                    // console.log('hello');
                    $('#Pay-with-wallet-modal').modal('show');
                }
            });
        });
    </script>
@endsection
