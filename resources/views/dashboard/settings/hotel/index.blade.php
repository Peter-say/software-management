@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('dashboard.hotel.settings.')}}">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Hotel</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Module Preference</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage modules you want to enable for your hotel operations
                            <a href="{{ route('dashboard.hotel.module-preferences.edit', Auth::user()->hotel->uuid) }}" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Hotel Info</h5>
                        <div class="card-body d-flex justify-content-between">
                            Manage your hotel info here
                            <a href="{{ route('dashboard.hotel.settings.hotel-info.edit') }}" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Payment Platform</h5>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Set up your payment platform here if you would like to receive payments online / have not done so</span>
                            <a href="{{route('dashboard.hotel.settings.hotel-info.choose-payment-platform')}}" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                    <div class="card">
                        <h5 class="card-header">Edit Hotel Currency</h5>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Edit the currency you want for your hotel for transaction. This will be used for all transactions. By default, it is set to your country's currency</span>
                            <a href="{{route('dashboard.hotel.settings.hotel-info.edit-currency')}}" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
