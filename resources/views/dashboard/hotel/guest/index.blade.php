@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Guests</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Guests</h4>
                        <a href="{{ route('dashboard.hotel.guests.create') }}" class="btn btn-primary">Add New Guest</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Title</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Other Names</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Other Phone</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Birthday</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guests as $guest)
                                        <tr>
                                            @if ($guest->id_picture_location)
                                                <td><img class="rounded-circle" width="35"
                                                        src="{{ asset('storage/hotel/guest/id/' . $guest->id_picture_location) }}"
                                                        alt="ID Picture"></td>
                                            @else
                                                <td><img class="rounded-circle" width="35"
                                                        src="{{ asset('dashboard/images/profile/small/pic1.jpg') }}"
                                                        alt="ID Picture"></td>
                                            @endif
                                            <td>{{ $guest->title }}</td>
                                            <td>{{ $guest->first_name }}</td>
                                            <td>{{ $guest->last_name ?? 'N/A' }}</td>
                                            <td>{{ $guest->other_names ?? 'N/A' }}</td>
                                            <td><a href="mailto:{{ $guest->email }}">{{ $guest->email ?? 'N/A' }}</a></td>
                                            <td>{{ $guest->phone_code }} {{ $guest->phone ?? 'N/A' }}</td>
                                            <td>{{ $guest->other_phone ?? 'N/A' }}</td>
                                            <td>{{ $guest->state->name ?? 'N/A' }}</td>
                                            <td>{{ $guest->country->name ?? 'N/A' }}</td>
                                            <td>{{ $guest->birthday ? $guest->birthday->format('D M, Y') : 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('dashboard.hotel.guests.show', $guest->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('dashboard.hotel.guests.edit', $guest->id) }}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp"
                                                        onclick="confirmDelete('{{ route('dashboard.hotel.guests.destroy', $guest->id) }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#fund-guest-wallet-modal" class="btn btn-primary shadow btn-xs sharp">
                                                        <i class="fas fa-wallet"></i>
                                                    </a>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        @include('dashboard.hotel.guest.wallet.credit', ['guest' => $guest])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  @include('dashboard.hotel.guest.delete-modal')
@endsection
