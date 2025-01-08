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
                            <a href="" class="btn btn-primary">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
