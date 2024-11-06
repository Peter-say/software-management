@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.suppliers.index') }}">Supplier</a></li>
                    <li class="breadcrumb-item">{{ isset($supplier) ? 'Update supplier' : 'Create supplier' }}</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($supplier) ? 'Update supplier' : 'Create supplier' }}</h4>
                    </div>

                    <div class="card-body">
                        <form id="supplierForm"
                            action="{{ isset($supplier) ? route('dashboard.hotel.suppliers.update', $supplier->id) : route('dashboard.hotel.suppliers.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($supplier))
                                @method('PUT')
                                <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                            @endif

                            <div class="row">
                                <!-- supplier Details -->
                                <div class="col-lg-12">
                                    <h5>Supplier Details</h5>
                                    <div class="row">
                                       

                                        <!-- Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name*</label>
                                                <input type="text" id="name" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $supplier->name ?? '') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Last Name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="contact_person_name" class="form-label">Contact Person Name*</label>
                                                <input type="text" id="contact_person_name" name="contact_person_name"
                                                    class="form-control @error('contact_person_name') is-invalid @enderror"
                                                    value="{{ old('contact_person_name', $supplier->contact_person_name ?? '') }}" required>
                                                @error('contact_person_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Other Names Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="contact_person_phone" class="form-label">Contact Person Phone *</label>
                                                <input type="text" id="contact_person_phone" name="contact_person_phone"
                                                    class="form-control @error('contact_person_phone') is-invalid @enderror"
                                                    value="{{ old('contact_person_phone', $supplier->contact_person_phone ?? '') }}">
                                                @error('contact_person_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- bank_account_name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_account_name" class="form-label">Bank Account Name</label>
                                                <input type="text" id="bank_account_name" name="bank_account_name"
                                                    class="form-control @error('bank_account_name') is-invalid @enderror"
                                                    value="{{ old('bank_account_name', isset($supplier) && $supplier->bank_account_name) }}"
                                                    required>
                                                @error('bank_account_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- bank_name Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_name" class="form-label">Bank Name*</label>
                                                <input type="bank_name" id="bank_name" name="bank_name"
                                                    class="form-control @error('bank_name') is-invalid @enderror"
                                                    value="{{ old('bank_name', $supplier->bank_name ?? '') }}" required>
                                                @error('bank_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- bank_account_no Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="bank_account_no" class="form-label">Bank Account No*</label>
                                                <input type="number" id="bank_account_no" name="bank_account_no"
                                                    class="form-control @error('bank_account_no') is-invalid @enderror"
                                                    value="{{ old('bank_account_no', $supplier->bank_account_no ?? '') }}" required>
                                                @error('bank_account_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="address" id="address" name="address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    value="{{ old('address', $supplier->address ?? '') }}">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- email Field -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $supplier->email ?? '') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                       
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($supplier) ? 'Update Supplier' : 'Create Supplier' }}</button>
                                <a href="{{ route('dashboard.hotel.suppliers.index') }}"
                                    class="btn btn-danger light ms-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
