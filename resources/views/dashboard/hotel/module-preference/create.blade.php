@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                @if (Auth::user()->hotelUser)
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{route('dashboard.home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('dashboard.hotel.settings.')}}">Settings</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('dashboard.hotel.settings.hotel-info.')}}">Hotel Info</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Choose Module</a></li>
                </ol>
                @endif
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            @if (isset($selected_modules))
                                <h4 class="card-title">Update Modules </h4>
                            @else
                                <h4 class="card-title">Select Modules</h4>
                            @endif
                            <p class="card-text">
                                Choose the modules you want to enable for your hotel operations. These modules define the
                                features and tools available in your dashboard.
                                @if (isset($selected_modules))
                                    You can always modify your selection later in the settings.
                                @endif
                            </p>
                        </div>

                        <div class="card-body">
                            <form
                                action="{{ isset($selected_modules) ? route('dashboard.hotel.module-preferences.update', Auth::user()->hotel->id) : route('dashboard.hotel.module-preferences.store') }}"
                                method="post">
                                @csrf
                                @if (isset($selected_modules))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    {{-- @php
                                        dd($selected_modules);
                                    @endphp --}}
                                    @foreach ($modules as $module)
                                        <div class="col-md-4 mb-4">
                                            <div class="card module-card" data-name="{{ $module }}"
                                                @if (isset($selected_modules) && in_array($module, $selected_modules)) class="selected" @endif>
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $module }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="selected_modules" id="selected-modules"
                                    value="{{ isset($selected_modules) ? implode(',', $selected_modules) : '' }}">
                                <button type="submit" class="btn btn-primary">Save Modules</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .module-card {
            cursor: pointer;
            border: 2px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .module-card:hover {
            border-color: red;
            {{-- box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2); --}}
        }

        .module-card.selected {
            border-color: red;
            background-color: #f0f8ff;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moduleCards = document.querySelectorAll('.module-card');
            const selected_modulesInput = document.getElementById('selected-modules');

            // Initialize selected modules from the hidden input field
            let selected_modules = selected_modulesInput.value ? selected_modulesInput.value.split(',') : [];
            console.log(selected_modules);

            moduleCards.forEach(card => {
                const moduleName = card.getAttribute('data-name');
                if (selected_modules.includes(moduleName)) {
                    card.classList.add('selected');
                }

                card.addEventListener('click', function() {
                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selected_modules = selected_modules.filter(name => name !== moduleName);
                    } else {
                        this.classList.add('selected');
                        selected_modules.push(moduleName);
                    }

                    // Update the hidden input with the current selected modules
                    selected_modulesInput.value = selected_modules.join(',');
                });
            });
        });
    </script>
@endsection
