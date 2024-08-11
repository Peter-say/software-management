@extends('dashboard.layouts.app')

@section('contents')

    @extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body ">
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
                        <h4 class="card-title">Hotel Uses</h4>
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
                                                <td><img class="rounded-circle" width="35"
                                                        src="{{ asset('storage/hotel/users/photos/' . $hotel_user->photo) }}"
                                                        alt="photo"></td>
                                            @else
                                                <td><img class="rounded-circle" width="35"
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
                                                    <a href="{{route('dashboard.hotel-users.edit', $hotel_user->id)}}" class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                                            class="fa fa-trash"></i></a>
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
@endsection


@endsection
