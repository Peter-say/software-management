@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Choose Module</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Select Modules</h4>
                            <p class="card-text">
                                Choose the modules you want to enable for your hotel operations. These modules define the
                                features and tools available in your dashboard.
                                You can always modify your selection later in the settings.
                            </p>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('dashboard.hotel.module-preferences.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    @foreach ($modules as $module)
                                        <div class="col-md-4 mb-4">
                                            <div class="card module-card" data-name="{{ $module }}">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $module }}</h5>
                                                    {{-- <p class="card-text">{{ $module->description }}</p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <input type="hidden" name="selected_modules" id="selected-modules">
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
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        .module-card.selected {
            border-color: red;
            background-color: #f0f8ff;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moduleCards = document.querySelectorAll('.module-card');
            const selectedModulesInput = document.getElementById('selected-modules');

            let selectedModules = [];

            moduleCards.forEach(card => {
                card.addEventListener('click', function() {
                    const moduleName = this.getAttribute('data-name');

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selectedModules = selectedModules.filter(name => name !== moduleName);
                    } else {
                        this.classList.add('selected');
                        selectedModules.push(moduleName);
                    }

                    selectedModulesInput.value = selectedModules.join(',');
                });
            });
        });
    </script>
@endsection
