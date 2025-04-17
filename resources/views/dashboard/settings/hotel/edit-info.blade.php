@extends('dashboard.layouts.app')

@section('contents')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.hotel.settings.') }}">Settings</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Hotel Info</a></li>
            </ol>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Hotel Info</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.hotel.settings.hotel-info.update')}}"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="hotel_name" class="text-label form-label">Name*</label>
                                    <input type="text" id="hotel_name" name="hotel_name"
                                        class="form-control @error('hotel_name') is-invalid @enderror" placeholder="Name"
                                        value="{{ old('name', $hotel->hotel_name ?? '') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="phone" class="text-label form-label">Phone*</label>
                                    <input type="text" id="phone" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Phone Number" value="{{ old('phone', $hotel->phone ?? '') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="address" class="text-label form-label">Address</label>
                                    <input type="text" id="address" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address" value="{{ old('address', $hotel->address ?? '') }}">
                                    @error('address')
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
                                            {{ old('country_id', $hotel->country_id ?? '') == $country->id ? 'selected' : '' }}>
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
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="logo" class="text-label form-label">Logo</label>
                                    <input type="file" id="logo" name="logo"
                                        class="form-control w-100 @error('logo') is-invalid @enderror">
                                    @error('logo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <div class="form-group">
                                    <label for="website" class="text-label form-label">Website</label>
                                    <input type="text" id="website" name="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        placeholder="Website URL" value="{{ old('website') }}">
                                    @error('website')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ 'Submit' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var stateId = '{{ old('state_id', $hotel->state_id ?? '') }}';
        var countryId = '{{ old('country_id', $hotel->country_id ?? '') }}';

        function loadStates(countryId, selectedStateId = null) {
            var stateDropdown = $('#state_id');
            stateDropdown.empty();

            if (countryId) {
                $.ajax({
                    url: '{{ route('get-states-by-country') }}',
                    type: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function (response) {
                        stateDropdown.append('<option value="">Select State</option>');
                        $.each(response.states, function (key, state) {
                            var selected = (state.id == selectedStateId) ? 'selected' : '';
                            stateDropdown.append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                        });
                    },
                    error: function () {
                        alert('Error fetching states');
                    }
                });
            } else {
                stateDropdown.append('<option value="">Select State</option>');
            }
        }

        // Trigger on country change
        $('#country_id').on('change', function () {
            var selectedCountryId = $(this).val();
            loadStates(selectedCountryId);
        });

        // Load states on page load if country is pre-selected
        if (countryId) {
            loadStates(countryId, stateId);
        }
    });
</script>
