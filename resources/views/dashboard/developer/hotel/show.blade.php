@extends('dashboard.layouts.app')

@section('contents')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('dashboard.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Components</a></li>
            </ol>
        </div>
        <!-- Hotel Card -->
        <div class="card shadow-sm border-0">
            <div class="row g-0">
                <!-- Hotel Image -->
                <div class="col-md-4">
                    <a href="{{ $hotel->hotelLogo() }}" data-fancybox="hotel_logo">
                        <img src="{{ $hotel->hotelLogo() }}" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Hotel Logo">
                    </a>
                </div>

                <!-- Hotel Details -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $hotel->name }}</h5>

                        <div class="row mb-2">
                            <div class="col-md-6"><strong>UUID:</strong> {{ $hotel->uuid }}</div>
                            <div class="col-md-6"><strong>Joined:</strong> {{ $hotel->created_at->format('F d, Y') }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6"><strong>Owner:</strong> {{ $hotel->user->name }}</div>
                            <div class="col-md-6"><strong>Phone:</strong> {{ $hotel->phone ?? 'N/A' }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6"><strong>Country:</strong> {{ $hotel->country->name ?? 'N/A' }}</div>
                            <div class="col-md-6"><strong>State:</strong> {{ $hotel->state->name ?? 'N/A' }}</div>
                        </div>

                        <div class="mb-3"><strong>Address:</strong> {{ $hotel->address ?? 'N/A' }}</div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('dashboard.hotel.settings.hotel-info.edit', $hotel->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>

                            <button onclick="confirmDelete('{{ route('dashboard.hotels.delete-hotel', $hotel->id) }}')" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>

                            <form id="impersonate-form" method="POST" action="{{ route('dashboard.hotels.login-as-hotel-owner', $hotel->user->id) }}" style="display: none;">
                                @csrf
                            </form>
                            <button onclick="event.preventDefault(); document.getElementById('impersonate-form').submit();" class="btn btn-dark">
                                <i class="fas fa-user-secret me-1"></i> Login as Owner
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example3" class="display" style="min-width: 845px">
                    <thead>
                        <tr>
                            <th class="bg-none">
                                <div class="form-check style-1">
                                    <input class="form-check-input" type="checkbox"
                                        value="" id="checkAll3">
                                </div>
                            </th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotel_users as $hotel_user)
                        <tr>
                            <td>
                                <div class="form-check style-1">
                                    <input class="form-check-input" type="checkbox"
                                        value="">
                                </div>
                            </td>
                            <td>
                                <a href="{{ $hotel_user->photo() }}"
                                    data-fancybox="gallery_{{ $hotel->id }}"
                                    data-caption="{{ $hotel_user->name }}">
                                    <img src="{{ $hotel_user->photo() }}"
                                        alt="Image" class="img-thumbnail"
                                        style="width: 60px; height: 60px;">
                                </a>
                            </td>
                            <td>{{ $hotel_user->user->name }}</td>
                            <td>{{ $hotel_user->user->email }}</td>
                            <td>{{ $hotel_user->address ?? 'N/A' }}</td>
                            <td>{{ $hotel_user->role }}</td>
                            <td>{{ $hotel_user->phone ?? 'N/A' }}</td>
                            <td>{{ $hotel_user->created_at->format('D M, Y') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('{{ route('dashboard.hotel-users.delete', $hotel_user->id) }}')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                Are you sure you want to delete this hotel?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(url) {
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    }
</script>
@endsection