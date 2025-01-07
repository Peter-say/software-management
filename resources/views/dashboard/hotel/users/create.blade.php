@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ isset($hotel_user) ? 'Update User' : 'Create User' }}</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($hotel_user) ? 'Update User' : 'Create User' }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($hotel_user) ? route('dashboard.hotel-users.update', $hotel_user->id) : route('dashboard.hotel-users.store') }}" 
                              enctype="multipart/form-data" 
                              method="POST">
                            @csrf
                            @if(isset($hotel_user))
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $hotel_user->id }}">
                            @endif

                            <div class="row">
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="text-label form-label">Name*</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                            value="{{ old('name', $hotel_user->user->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="text-label form-label">Email*</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Email Address" value="{{ old('email', $hotel_user->user->email ?? '') }}" required>
                                        @error('email')
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
                                            placeholder="Phone Number" value="{{ old('phone', $hotel_user->phone ?? '') }}" required>
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
                                            placeholder="Address" value="{{ old('address', $hotel_user->address ?? '') }}">
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="gender" class="text-label form-label">Gender</label>
                                        <select id="gender" name="gender"
                                            class="form-control @error('gender') is-invalid @enderror" required>
                                            <option value="" disabled>Select Role</option>
                                            @foreach (['Male', 'Female'] as $gender)
                                                <option value="{{ $gender }}"
                                                    {{ old('gender', $hotel_user->gender ?? '') == $gender ? 'selected' : '' }}>{{$gender}}</option>
                                            @endforeach
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role" class="text-label form-label">Role*</label>
                                        <select id="role" name="role"
                                            class="form-control @error('role') is-invalid @enderror" required>
                                            <option value="" disabled>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ old('role', $hotel_user->role ?? '') == $role ? 'selected' : '' }}>{{$role}}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="photo" class="text-label form-label">Profile Photo</label>
                                        <input type="file" id="photo" name="photo"
                                            class="form-control @error('photo') is-invalid @enderror">
                                        @error('photo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="status" class="text-label form-label">Status</label>
                                        <select id="status" name="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="" disabled>Select Status</option>
                                            @foreach ($statusOptions as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $hotel_user->status ?? '') == $status ? 'selected' : '' }}>{{$status}}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ isset($hotel_user) ? 'Update' : 'Submit' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
