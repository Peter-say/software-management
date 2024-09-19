@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('dashboard.hotel.guests.index')}}">Guest</a></li>
                    <li class="breadcrumb-item">{{ isset($guest) ? 'Update Guest' : 'Create Guest' }}</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($guest) ? 'Update Guest' : 'Create Guest' }}</h4>
                    </div>

                    <div class="card-body">
                        <form id="guestForm"
                            action="{{ isset($guest) ? route('dashboard.hotel.guests.update', $guest->id) : route('dashboard.hotel.guests.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($guest))
                                @method('PUT')
                                <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                            @endif

                            <div class="row">
                                <!-- Guest Details -->
                                <div class="col-lg-12">
                                    <h5>Guest Details</h5>
                                    <div class="row">
                                        <!-- Title Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title</label>
                                                <select id="title" name="title" class="form-select form-control"
                                                    required>
                                                    <option value="">--Select--</option>
                                                    @foreach ($titleOptions as $title)
                                                        <option value="{{ $title }}"
                                                            {{ old('title', $guest->title ?? '') == $title ? 'selected' : '' }}>
                                                            {{ $title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- First Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="first_name" class="form-label">First Name*</label>
                                                <input type="text" id="first_name" name="first_name"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    value="{{ old('first_name', $guest->first_name ?? '') }}" required>
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Last Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="last_name" class="form-label">Last Name*</label>
                                                <input type="text" id="last_name" name="last_name"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    value="{{ old('last_name', $guest->last_name ?? '') }}" required>
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Other Names Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="other_names" class="form-label">Other Names</label>
                                                <input type="text" id="other_names" name="other_names"
                                                    class="form-control @error('other_names') is-invalid @enderror"
                                                    value="{{ old('other_names', $guest->other_names ?? '') }}">
                                                @error('other_names')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Birthday Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="birthday" class="form-label">Birthday Date</label>
                                                <input type="text" id="birthday" name="birthday"
                                                    class="form-control datepicker-default @error('birthday') is-invalid @enderror"
                                                    value="{{ old('birthday', isset($guest) && $guest->birthday ? $guest->birthday->format('d F, Y') : '') }}"
                                                    required>
                                                @error('birthday')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email*</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $guest->email ?? '') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone*</label>
                                                <input type="text" id="phone" name="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone', $guest->phone ?? '') }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Address Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address*</label>
                                                <input type="text" id="address" name="address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    value="{{ old('address', $guest->address ?? '') }}" required>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                            {{ old('country_id', $guest->country_id ?? '') == $country->id ? 'selected' : '' }}>
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



                                        <!-- ID Picture Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="id_picture_location" class="form-label">ID Photo</label>
                                                <input type="file" id="id_picture_location" name="id_picture_location"
                                                    class="form-control @error('id_picture_location') is-invalid @enderror"
                                                    value="{{ old('id_picture_location', $guest->id_picture_location ?? '') }}">
                                                @error('id_picture_location')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($guest) ? 'Update Guest' : 'Create Guest' }}</button>
                                <a href="{{ route('dashboard.hotel.guests.index') }}"
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
            $('#country_id').on('change', function() {
                var countryId = $(this).val();
                var stateDropdown = $('#state_id');
                stateDropdown.empty();

                if (countryId) {
                    $.ajax({
                        url: '{{ route('get-states-by-country') }}',
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            stateDropdown.append(
                                '<option value="">Select State</option>'); // Add placeholder
                            $.each(response.states, function(key, state) {
                                stateDropdown.append('<option value="' + state.id +
                                    '">' + state.name + '</option>');
                            });
                        },
                        error: function() {
                            alert('Error fetching states');
                        }
                    });
                } else {
                    stateDropdown.append('<option value="">Select State</option>');
                }
            });
        });
    </script>
@endsection
