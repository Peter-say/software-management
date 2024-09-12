@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reservation</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($reservation) ? 'Update Reservation' : 'Create Reservation' }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="reservationForm"
                            action="{{ isset($reservation) ? route('dashboard.hotel.reservations.update', $reservation->id) : route('dashboard.hotel.reservations.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($reservation))
                                @method('PUT')
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                            @endif

                            <div class="row">
                                <!-- Guest Details -->
                                <div class="col-lg-6">
                                    <h5>Guest Details</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="phone">Search Existing Guest</label>
                                            <input type="hidden" id="guest_id" name="guest_id">
                                            <input id="guest_name" autofocus name="guest_name" type="text" list="guests"
                                                class="form-control" placeholder="Search Guest by Name">
                                        </div>
                                        <datalist id="guests">
                                            @foreach (getModelItems('guests') as $guest)
                                                <option data-id="{{ $guest->id }}" value="{{ $guest->full_name }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="row">
                                        <!-- Title Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="title" class="text-label form-label">Title</label>
                                                <select id="title" name="title" class="form-select form-control guest"
                                                    required>
                                                    <option value="">--Select--</option>
                                                    @foreach ($titleOptions as $title)
                                                        <option value="{{ $title }}"
                                                            {{ old('title', $reservation->guest->title ?? '') == $title ? 'selected' : '' }}>
                                                            {{ $title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('title')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- First Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="first_name" class="text-label form-label">First Name*</label>
                                                <input type="text" id="first_name" name="first_name"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    value="{{ old('first_name', $reservation->guest->first_name ?? '') }}"
                                                    required>
                                                @error('first_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Last Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="last_name" class="text-label form-label">Last Name*</label>
                                                <input type="text" id="last_name" name="last_name"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    value="{{ old('last_name', $reservation->guest->last_name ?? '') }}"
                                                    required>
                                                @error('last_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Other Names Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="other_names" class="text-label form-label">Other Names*</label>
                                                <input type="text" id="other_names" name="other_names"
                                                    class="form-control @error('other_names') is-invalid @enderror"
                                                    value="{{ old('other_names', $reservation->guest->other_names ?? '') }}"
                                                    required>
                                                @error('other_names')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email" class="text-label form-label">Email*</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $reservation->guest->email ?? '') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="phone" class="text-label form-label">Phone*</label>
                                                <input type="text" id="phone" name="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone', $reservation->guest->phone ?? '') }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reservation Details -->
                                <div class="col-lg-6">
                                    <h5>Reservation Details</h5>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="checkin_date" class="text-label form-label">Check-in
                                                    Date*</label>
                                                <input type="text" id="checkin_date" name="checkin_date"
                                                    class="form-control datepicker-default @error('checkin_date') is-invalid @enderror"
                                                    value="{{ old('checkin_date', isset($reservation) ? $reservation->checkin_date->format('d F, Y') : '') }}"
                                                    required>
                                                @error('checkin_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="checkout_date" class="text-label form-label">Check-out
                                                    Date*</label>
                                                <input type="text" id="checkout_date" name="checkout_date"
                                                    class="form-control datepicker-default @error('checkout_date') is-invalid @enderror"
                                                    value="{{ old('checkout_date', isset($reservation) ? $reservation->checkout_date->format('d F, Y') : '') }}"
                                                    required>
                                                @error('checkout_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="room_id" class="text-label form-label">Room*</label>
                                                <select id="room_id" name="room_id"
                                                    class="form-control @error('room_id') is-invalid @enderror" required>
                                                    <option value="" disabled selected>Select Room</option>
                                                    @foreach (getModelItems('rooms') as $room)
                                                        <option value="{{ $room->id }}"
                                                            data-rate="{{ $room->roomType->rate }}"
                                                            {{ old('room_id', $reservation->room_id ?? '') == $room->id ? 'selected' : '' }}>
                                                            {{ $room->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('room_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="rate" class="text-label form-label">Room Rate</label>
                                                <input type="text" id="rate" name="rate"
                                                    class="form-control @error('rate') is-invalid @enderror"
                                                    value="{{ old('rate', $reservation->rate ?? '') }}" readonly>
                                                @error('rate')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="notes " class="text-label form-label">Notes</label>
                                                <textarea class="form-control @error('notes ') is-invalid @enderror" name="notes " id="notes " rows="4">{{ old('notes ', $reservation->notes ?? '') }}</textarea>
                                                @error('notes ')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($reservation) ? 'Update Reservation' : 'Create Reservation' }}</button>
                                <a href="{{ route('dashboard.hotel.reservations.index') }}"
                                    class="btn btn-danger light ms-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setGuestInformation() {
                const guestInput = document.getElementById('guest_name');
                const guestsDataList = document.getElementById('guests');
                const guestIdField = document.getElementById('guest_id');

                // Handle guest selection and autofill guest details
                guestInput.addEventListener('input', function() {
                    const inputValue = guestInput.value;
                    let selectedOption = null;

                    for (let i = 0; i < guestsDataList.options.length; i++) {
                        if (guestsDataList.options[i].value === inputValue) {
                            selectedOption = guestsDataList.options[i];
                            break;
                        }
                    }

                    if (selectedOption) {
                        guestIdField.value = selectedOption.getAttribute('data-id');
                        fetchGuestInfo(selectedOption.getAttribute('data-id'));
                    }
                });

                function fetchGuestInfo(guestId) {
                    fetch(`/dashboard/hotel/set-guest-info?id=${guestId}`)
                        .then(response => {
                            // Log the status and content-type of the response for debugging
                            console.log('Response status:', response.status);
                            console.log('Response content-type:', response.headers.get('content-type'));

                            // Check if the response is not a 404 or another error
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.statusText);
                            }

                            // Check if the response is JSON
                            if (response.headers.get('content-type')?.includes('application/json')) {
                                return response.json();
                            } else {
                                throw new Error('Expected JSON, received something else');
                            }
                        })
                        .then(data => {
                            document.getElementById('title').value = data.title || '';
                            document.getElementById('first_name').value = data.first_name || '';
                            document.getElementById('last_name').value = data.last_name || '';
                            document.getElementById('other_names').value = data.other_names || '';
                            document.getElementById('email').value = data.email || '';
                            document.getElementById('phone').value = data.phone || '';
                        })
                        .catch(error => console.error('Error fetching guest data:', error));
                }


                // Handle room selection and update rate field
                const roomSelect = document.getElementById('room_id');
                const rateField = document.getElementById('rate');

                roomSelect.addEventListener('change', function() {
                    const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
                    const roomRate = selectedRoom.getAttribute('data-rate');

                    if (roomRate) {
                        rateField.value = roomRate; // Set the value of the rate field
                    } else {
                        rateField.value = ''; // Clear rate if no rate is available
                    }
                });

                const reservationForm = document.getElementById('reservationForm');
                reservationForm.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    try {
                        const formData = new FormData(reservationForm);
                        const response = await fetch(reservationForm.action, {
                            method: reservationForm.method,
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            Toastify({
                                text: data.success_message || 'Operation successful.',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                            }).showToast();
                            setTimeout(() => {
                                window.location.href = data.redirectUrl;
                            }, 3000);
                        } else {
                            handleErrorMessages(data.error_message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Toastify({
                            text: error.message || 'An unexpected error occurred.',
                            duration: 3000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    }

                    function handleErrorMessages(errors) {
                        if (typeof errors === 'string') {
                            Toastify({
                                text: errors,
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                        } else if (typeof errors === 'object') {
                            for (let key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errors[key].forEach(error => {
                                        Toastify({
                                            text: error,
                                            duration: 3000,
                                            gravity: 'top',
                                            position: 'right',
                                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                                        }).showToast();
                                    });
                                }
                            }
                        }
                    }

                });
            }

            function checkRoomAvailability(checkinDate, checkoutDate) {
                fetch(`/dashboard/hotel/check-room-availability`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            checkin_date: checkinDate,
                            checkout_date: checkoutDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const roomSelect = document.getElementById('room_id');
                            roomSelect.disabled = !data.available;
                            if (!data.available) {
                                Toastify({
                                    text: 'No rooms available for the selected dates.',
                                    duration: 3000,
                                    gravity: 'top',
                                    position: 'right',
                                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                                }).showToast();
                            }
                        } else {
                            Toastify({
                                text: data.error_message ||
                                    'An error occurred while checking availability.',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Handle date changes and room availability check
            document.getElementById('checkin_date').addEventListener('change', function() {
                const checkinDate = this.value;
                const checkoutDate = document.getElementById('checkout_date').value;
                if (checkinDate && checkoutDate) {
                    checkRoomAvailability(checkinDate, checkoutDate);
                }
            });

            document.getElementById('checkout_date').addEventListener('change', function() {
                const checkoutDate = this.value;
                const checkinDate = document.getElementById('checkin_date').value;
                if (checkoutDate && checkinDate) {
                    checkRoomAvailability(checkinDate, checkoutDate);
                }
            });


            // Initialize the guest information and room selection handling
            setGuestInformation();
        });
    </script>
@endsection
