@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.settings.') }}">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Hotel</a></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <h4 class="card-header">Select a Payment Platform</h4>
                        <div class="card-body">
                            <p>
                                <strong class="text-warning">Caution:</strong>
                                <span class="text-danger">
                                    Please ensure that you enter the correct details for your payment platform to avoid
                                    transaction issues.
                                </span>
                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ensure that the provided credentials, such as Public Key and Secret Key, are accurate and match your payment provider's settings.">
                                </i>
                            </p>
                            @foreach ($payment_platforms as $platform)
                                <label class="d-flex align-items-center p-3 shadow-sm rounded mb-2" style="cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#paymentModal{{ $platform->id }}">

                                    @php
                                        $logoPath = 'storage/' . $platform->logo;
                                        $selected_platform = $platform->hotelPaymentPlatforms
                                            ->where('hotel_id', \App\Models\User::getAuthenticatedUser()->hotel->id)
                                            ->first();
                                        // dd($selected_platform)
                                    @endphp
                                    @if ($platform->logo && Storage::exists($platform->logo))
                                        <img src="{{ asset($logoPath) }}" alt="{{ $platform->name }}" class="me-3"
                                            style="width: 50px;">
                                    @else
                                        <img src="{{ getStorageUrl('dashboard/icons/payment-icon-vector.jpg') }}"
                                            alt="{{ $platform->name }}" class="me-3" style="width: 50px;">
                                    @endif

                                    <h6 class="mb-0 flex-grow-1">{{ $platform->name }}</h6>
                                    <input type="radio" name="selected_platform" value="{{ $platform->id }}"
                                        class="platform-radio" @checked(optional($selected_platform)->payment_platform_id == $platform->id)>

                                </label>
                                <!-- Payment Platform Modal (inside loop) -->
                                <div class="modal fade" id="paymentModal{{ $platform->id }}" tabindex="-1"
                                    aria-labelledby="paymentModalLabel{{ $platform->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentModalLabel{{ $platform->id }}">Enter
                                                    {{ $platform->name }} Payment Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="{{ isset($selected_platform) ? route('dashboard.hotel.update-payment-platform', optional($selected_platform)->id) : route('dashboard.hotel.store-payment-platform') }}"
                                                method="POST">
                                                @csrf
                                                @if (isset($selected_platform))
                                                    @method('PUT')
                                                @endif

                                                <div class="modal-body">
                                                    <input type="hidden" name="selected_platform"
                                                        value="{{ $platform->id }}">

                                                    <div class="mb-3">
                                                        <label for="public_key_{{ $platform->id }}"
                                                            class="form-label">Public Key</label>
                                                        <input type="text" name="public_key"
                                                            id="public_key_{{ $platform->paymentPlatform->id ?? '' }}"
                                                            class="form-control @error('public_key') is-invalid @enderror"
                                                            value="{{ old('public_key', $selected_platform->public_key ?? '') }}"
                                                            required>
                                                        @error('public_key')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="secret_key_{{ $platform->id }}"
                                                            class="form-label">Secret Key</label>
                                                        <input type="text" name="secret_key"
                                                            id="secret_key_{{ $platform->id }}"
                                                            class="form-control @error('secret_key') is-invalid @enderror"
                                                            value="{{ old('secret_key', $selected_platform->secret_key ?? '') }}"
                                                            required>
                                                        @error('secret_key')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function openModal(platformId, platformName) {
            document.getElementById('selectedPlatformId').value = platformId;
            document.getElementById('paymentModalLabel').textContent = "Enter " + platformName + " Payment Details";

            var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var paymentModal = document.getElementById('paymentModal');

            paymentModal.addEventListener('hidden.bs.modal', function() {
                // Remove all remaining modal-backdrop elements
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                // Ensure modal-open class is removed from body
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''; // Fixes possible body padding issue
            });
        });
    </script>
@endsection
