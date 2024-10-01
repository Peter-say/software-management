@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Room</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($room) ? 'Update Room' : 'Create Room' }}</h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($room) ? route('dashboard.hotel.rooms.update', $room->id) : route('dashboard.hotel.rooms.store') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @if (isset($room))
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $room->id }}">
                            @endif

                            <div class="row">
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="text-label form-label">Name*</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                            value="{{ old('name', $room->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="room-type" class="text-label form-label">Type*</label>
                                        <select id="room-type" name="room_type_id"
                                            class="form-control @error('room_type') is-invalid @enderror" required>
                                            <option value="" disabled>Select Type</option>
                                            @foreach ($room_types as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('room_type_id', $room->roomType->id ?? '') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('room_type_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="file-upload" class="text-label form-label">File Upload</label>
                                        <input type="file" id="photo" name="file_upload[]" accept="image/*" multiple
                                            class="form-control @error('file_upload') is-invalid @enderror">
                                        @error('file_upload')
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
                                                    {{ old('status', $room->status ?? '') == $status ? 'selected' : '' }}>
                                                    {{ $status }}</option>
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

                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-group">
                                    <label for="description" class="text-label form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $room->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary">{{ isset($room) ? 'Update' : 'Submit' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
