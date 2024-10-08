@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Outlet</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($outlet) ? 'Update Outlet' : 'Create Outlet' }}</h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($outlet) ? route('dashboard.hotel.outlets.update', $outlet->id) : route('dashboard.hotel.outlets.store') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @if (isset($outlet))
                                @method('PUT')
                                <input type="hidden" name="outlet_id" value="{{ $outlet->id }}">
                            @endif
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet_name" class="text-label form-label">Outlet Name*</label>
                                        <select id="outlet_name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                                            <option value="">Select Outlet Name</option>
                                            @foreach($outlets as $outlet)
                                                <option value="{{ $outlet }}" {{ old('name') == $outlet ? 'selected' : '' }}>
                                                    {{ $outlet }}
                                                </option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                        
                                        <input type="text" id="custom_outlet_name" name="name_custom" 
                                            class="form-control mt-2 @error('name_custom') is-invalid @enderror" 
                                            placeholder="Enter custom outlet name" 
                                            value="{{ old('name_custom') }}" 
                                            style="display: none;" />
                                            
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @error('name_custom')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
            
                                <div class="col-lg-8 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet-type" class="text-label form-label">Type*</label>
                                        <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="" disabled>Select Type</option>
                                            @foreach ($outlet_types as $type)
                                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">{{ isset($outlet) ? 'Update' : 'Submit' }}</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <script>
                document.getElementById('outlet_name').addEventListener('change', function () {
                    var customOutletField = document.getElementById('custom_outlet_name');
                    if (this.value === 'other') {
                        customOutletField.style.display = 'block';
                        customOutletField.value = ''; // Clear custom outlet field if "Other" is selected
                    } else {
                        customOutletField.style.display = 'none';
                        customOutletField.value = ''; // Reset custom input
                    }
                });
            
                // Handle form submission
                document.querySelector('form').addEventListener('submit', function (e) {
                    var outletNameField = document.getElementById('outlet_name');
                    var customOutletField = document.getElementById('custom_outlet_name');
                    
                    // Check if "Other" is selected and the custom outlet field is visible
                    if (outletNameField.value === 'other' && customOutletField.style.display === 'block') {
                        outletNameField.name = 'name_custom'; // Change the name to send custom name
                    } else {
                        outletNameField.name = 'name'; // Keep the selected outlet name
                    }
                });
            </script>
            
        </div>
    </div>
@endsection
