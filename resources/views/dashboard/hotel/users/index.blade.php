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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Hotel Users</h4>
                        <a href="{{route('dashboard.hotel-users.create')}}" class="btn btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Joining Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel_users as $hotel_user)
                                        <tr>
                                            @if ($hotel_user->photo)
                                                <td><img class="" width="35"
                                                        src="{{ getStorageUrl('hotel/users/photos/' . $hotel_user->photo) }}"
                                                        alt="photo"></td>
                                            @else
                                                <td><img class="" width="35"
                                                        src="{{ asset('dashboard/images/profile/small/pic1.jpg') }}"
                                                        alt="photo"></td>
                                            @endif
                                            <td>{{ $hotel_user->user->name }}</td>
                                            <td>{{ $hotel_user->role }}</td>
                                            <td>{{ $hotel_user->gender ?? 'N/A' }}</td>
                                            <td><a
                                                    href="javascript:void(0);"><strong>{{ $hotel_user->phone ?? 'N/A' }}</strong></a>
                                            </td>
                                            <td><a
                                                    href="javascript:void(0);"><strong>{{ $hotel_user->user->email }}</strong></a>
                                            </td>
                                            <td>{{ $hotel_user->created_at->format('D M, Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('dashboard.hotel-users.edit', $hotel_user->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
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
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
                    Are you sure you want to delete this user?
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
