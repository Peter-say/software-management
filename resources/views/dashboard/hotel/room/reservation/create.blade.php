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
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">{{ isset($reservation) ? 'Update Reservation' : 'Create Reservation' }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="reservationForm"
                            action="{{ isset($reservation) ? route('dashboard.hotel.reservations.update', $reservation->id) : route('dashboard.hotel.reservations.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($reservation))
                                @method('PUT')
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <input type="hidden" id="guest_id" name="guest_id" value="{{ $reservation->guest->id }}">
                            @else
                                <input type="hidden" id="guest_id" name="guest_id" value="">
                            @endif

                            <div class="row">
                                <!-- Guest Details -->
                                <div class="col-lg-6">
                                    <h5>Guest Details</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="phone">Search Existing Guest</label>
                                            {{-- <input type="hidden" id="guest_id" name="guest_id" value=""> --}}
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
                                                    value="{{ old('other_names', $reservation->guest->other_names ?? '') }}">
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
                                        <!-- Country Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="country_id" class="form-label">Country</label>
                                                <select id="country_id" name="country_id"
                                                    class="form-control @error('country_id') is-invalid @enderror">
                                                    <option value="">Select Country</option>
                                                    @foreach (getModelItems('countries') as $country)
                                                        <option value="{{ $country->id }}"
                                                            {{ old('country_id', $reservation->guest->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- State Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="state_id" class="form-label">State</label>
                                                <select id="state_id" name="state_id"
                                                    class="form-control @error('state_id') is-invalid @enderror">
                                                    <option value="">Select State</option>
                                                </select>
                                                @error('state_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                <input type="date" id="checkin-date" name="checkin_date"
                                                    class="form-control @error('checkin_date') is-invalid @enderror"
                                                    value="{{ old('checkin_date', isset($reservation) ? $reservation->checkin_date->format('Y-m-d') : '') }}"
                                                    required>
                                                @error('checkin_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="checkout_date" class="text-label form-label">Check-out
                                                    Date*</label>
                                                <input type="date" id="checkout-date" name="checkout_date"
                                                    class="form-control @error('checkout_date') is-invalid @enderror"
                                                    value="{{ old('checkout_date', isset($reservation) ? $reservation->checkout_date->format('Y-m-d') : '') }}"
                                                    required>
                                                @error('checkout_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                            {{ old('room_id', isset($reservation->room_id)) == $room->id ? 'selected' : '' }}>
                                                            {{ $room->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('room_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="notes" class="text-label form-label">Notes</label>
                                                <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="4">{{ old('notes', $reservation->notes ?? '') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <b>Night: </b> <span><label id="night-count">0 Night(s)</label> </span> <span>
                                                X </span><b>Rate</b><span> <label id="rate">0.00</label></span>
                                        </div>

                                        <div class="col-sm-6 col-xs-6">
                                            <b>Total: </b> <span> <label id="total-amount">0.0</label></span>
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
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
        document.addEventListener('DOMContentLoaded', function() {
            var requestedRoom = getUrlParameter('requested_room_id');
            if (requestedRoom) {
                var roomSelect = document.getElementById('room_id');
                roomSelect.value = requestedRoom;
                var selectedRoom = roomSelect.options[roomSelect.selectedIndex];
                var roomRate = selectedRoom.getAttribute('data-rate');
                if (roomRate) {
                    document.getElementById('rate').value = roomRate;
                }
            }
            function setGuestInformation() {
                const guestInput = document.getElementById('guest_name');
                const guestsDataList = document.getElementById('guests');
                const guestIdField = document.getElementById('guest_id');
                console.log(guestIdField.value);

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
                            document.getElementById('state_id').value = data.state.name || '';
                            document.getElementById('country_id').value = data.country.name || '';
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
                                text: data.message || 'Operation successful.',
                                duration: 1000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                            }).showToast();
                            setTimeout(() => {
                                window.location.href = data.redirectUrl;
                            }, 1000);
                        } else {
                            handleErrorMessages(data.errors);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Toastify({
                            text: message || 'An unexpected error occurred.',
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    }

                    function handleErrorMessages(errors) {
                        if (typeof errors === 'string') {
                            Toastify({
                                text: errors,
                                duration: 5000,
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
                                            duration: 5000,
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

            // Function to check room availability
            function checkRoomAvailability(checkinDate, checkoutDate) {
                const data = {
                    checkin_date: checkinDate || null,
                    checkout_date: checkoutDate || null
                };

                fetch('/dashboard/hotel/check-room-availability', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        const roomSelect = document.getElementById('room_id');
                        roomSelect.innerHTML = ''; // Clear previous options

                        // Handle nested response structure
                        const availableRooms = data?.available?.original?.rooms || [];

                        if (availableRooms.length > 0) {
                            let defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.textContent = 'Select Room';
                            roomSelect.appendChild(defaultOption);

                            // Populate room options and include the rate as a data attribute
                            availableRooms.forEach(room => {
                                let option = document.createElement('option');
                                option.value = room.id;
                                option.textContent = room.name;
                                option.setAttribute('data-rate', room.room_type
                                    .rate); // Attach the rate to each option
                                roomSelect.appendChild(option);
                            });

                            roomSelect.disabled = false; // Enable the dropdown
                        } else {
                            roomSelect.disabled = true; // Disable dropdown if no rooms
                            Toastify({
                                text: 'No rooms available for the selected dates.',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Listen for room selection and update the rate field
            document.getElementById('room_id').addEventListener('change', function() {
                const selectedRoom = this.options[this.selectedIndex];
                const rate = selectedRoom.getAttribute(
                    'data-rate'); // Get the rate from the selected option

                if (rate) {
                    document.getElementById('rate').value = rate; // Set the rate field
                } else {
                    document.getElementById('rate').value = ''; // Clear the rate if no room is selected
                }
            });


            // Handle check-in and check-out date change events
            const checkinInput = document.getElementById('checkin-date');
            const checkoutInput = document.getElementById('checkout-date');

            function handleDateChange() {
                console.log("Date change detected.");
                const checkinDate = checkinInput.value;
                const checkoutDate = checkoutInput.value;

                console.log("Selected Check-in Date:", checkinDate);
                console.log("Selected Check-out Date:", checkoutDate);

                // Check availability only if both dates are selected
                if (checkinDate && checkoutDate) {
                    checkRoomAvailability(checkinDate, checkoutDate);
                } else {
                    console.log("Both dates are not selected.");
                }
            }

            // Add event listeners to both inputs to handle changes
            checkinInput.addEventListener('change', handleDateChange);
            checkoutInput.addEventListener('change', handleDateChange);
            // Initialize the guest information and room selection handling
            setGuestInformation();

            // Function to calculate the number of nights and handle date validation
            function getNights() {
                var checkinValue = $('#checkin-date').val();
                var checkoutValue = $('#checkout-date').val();

                // Check if both dates are selected
                if (!checkinValue || !checkoutValue) {
                    return 0; // Default to 0 nights if any date is missing
                }

                // Parse date strings using Moment.js
                var checkin = moment(checkinValue, "YYYY-MM-DD");
                var checkout = moment(checkoutValue, "YYYY-MM-DD");

                // Calculate the difference in days
                var nights = checkout.diff(checkin, 'days');
                if (nights < 0) {
                    nights = 0; // Prevent negative nights
                }

                console.log("Nights:", nights); // Debugging
                return nights;
            }

            // Function to format a number as money with commas
            function formatMoney(number) {
                return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            // Function to update the total amount
            function updateTotalAmount() {
                var totalAmount = 0;
                var numberOfNights = getNights(); // Use getNights to calculate nights

                // Access the rate input value
                var rateField = $('#rate'); // jQuery selection
                var rate = parseFloat(rateField.val()) || 0; // Default to 0 if rate is empty or invalid

                console.log("Rate:", rate); // Debugging

                // Calculate the room total
                var roomTotal = rate * numberOfNights;
                console.log("Room Total:", roomTotal); // Debugging

                totalAmount += roomTotal;

                // Format totalAmount as money with commas
                var formattedTotal = formatMoney(totalAmount);
                console.log("Formatted Total Amount:", formattedTotal); // Debugging

                // Display the total amount
                $("#total-amount").text(formattedTotal);
                $("#rate").text(rate);
            }

            // Function to calculate the night count and update the total amount
            function calculateNightCount() {
                var nights = getNights(); // Calculate nights
                $('#night-count').text(nights + ' Night(s)'); // Update night count display

                // Update total amount when night count changes
                updateTotalAmount();
            }

            // Add event listeners to check-in and check-out date inputs
            $('#checkin-date').change(calculateNightCount);
            $('#checkout-date').change(calculateNightCount);

            // Add event listener to the rate input to recalculate the total amount
            $('#rate').on('input', updateTotalAmount);

            // Call the functions initially to set the default values
            $('#night-count').text('0 Night(s)'); // Set default night count display
            $('#total-amount').text('0.00'); // Set default total amount display


        });
    </script>
@endsection
