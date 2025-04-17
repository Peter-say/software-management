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
                    <h4 class="card-title">Hotels</h4>
                    <a href="" class="btn btn-primary">Add New</a>
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
                                    <th>Logo</th>
                                    <th>UUID</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>Joined Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotels as $hotel)
                                <tr>
                                    <td>
                                        <div class="form-check style-1">
                                            <input class="form-check-input" type="checkbox"
                                                value="">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ $hotel->hotelLogo() }}"
                                            data-fancybox="gallery_{{ $hotel->id }}"
                                            data-caption="{{ $hotel->name }}">
                                            <img src="{{ $hotel->hotelLogo() }}"
                                                alt="Image" class="img-thumbnail"
                                                style="width: 60px; height: 60px;">
                                        </a>
                                    </td>
                                    <td>{{ $hotel->uuid}}</td>
                                    <td>{{ $hotel->name }}</td>
                                    <td>{{ $hotel->user->name }}</td>
                                    <td>{{ $hotel->address ?? 'N/A' }}</td>
                                    <td>{{ $hotel->phone ?? 'N/A' }}</td>
                                    <td>{{ $hotel->country->name ?? 'N/A' }}</td>
                                    <td>{{ $hotel->state->name ?? 'N/A' }}</td>
                                    <td>{{ $hotel->created_at->format('D M, Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('dashboard.hotels.show-hotel', $hotel->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('dashboard.hotel.settings.hotel-info.edit')}}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('{{ route('dashboard.hotels.delete-hotel', $hotel->id) }}')">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <!-- Login as Hotel Owner Button -->
                                            <a href="{{ route('dashboard.hotels.login-as-hotel-owner', $hotel->user->id) }}"
                                                class="btn btn-dark shadow btn-xs sharp" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Login as Hotel Owner"
                                                onclick="event.preventDefault(); document.getElementById('login-as-form-{{$hotel->id}}').submit();">
                                                <i class="fas fa-user-secret"></i>
                                            </a>

                                            <!-- Impersonation Form -->
                                            <form id="login-as-form-{{$hotel->id}}" method="POST"
                                                action="{{ route('dashboard.hotels.login-as-hotel-owner', $hotel->user->id) }}"
                                                style="display: none;">
                                                @csrf
                                            </form>
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