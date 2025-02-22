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
                        <h4 class="card-header">Select a Currency</h4>
                        <div class="card-body">
                            <p>
                                <strong class="text-warning">Caution:</strong>
                                <span class="text-info">
                                    The currency you select will be used across the app for transactions unless otherwise
                                    stated.
                                </span>
                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ensure that the selected currency is accurate. This currency will be used for all 
                                    transactions within the app. Future integration will allow users from other 
                                    countries to book using their local currency. This will be integrated when 
                                    the hotel plans to launch a web-based site. Please make sure to review the 
                                    currency settings periodically to accommodate any changes in the hotel's 
                                    operational regions.">
                                </i>
                            </p>
                            <form action="{{ route('dashboard.hotel.update-hotel-currency') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="currency" class="form-label">Currency</label>
                                        @php
                                            $selectedCurrencyCode = getCountryCurrency(); // This returns something like 'USD'
                                            $selectedCurrency = collect(getModelItems('currencies'))->firstWhere(
                                                'short_name',
                                                $selectedCurrencyCode,
                                            );
                                        @endphp

                                        <select id="currency" name="currency_id"
                                            class="form-control @error('currency_id') is-invalid @enderror">
                                            <option value="">Select Currency</option>
                                            @foreach (getModelItems('currencies') as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ old('currency_id', $selectedCurrency->id ?? null) == $currency->id ? 'selected' : '' }}>
                                                    {{ $currency->short_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('currency_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
