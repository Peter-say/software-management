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
                            <th>Role</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="form-check style-1">
                                    <input class="form-check-input" type="checkbox"
                                        value="">
                                </div>
                            </td>
                            <td>
                                <a href="{{ $user->photo() }}"
                                    data-fancybox="gallery_{{ $user->id }}"
                                    data-caption="{{ $user->name }}">
                                    <img src="{{ $user->photo() }}"
                                        alt="Image" class="img-thumbnail"
                                        style="width: 60px; height: 60px;">
                                </a>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ optional($user->created_at)->format('D M, Y') ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('{{ route('dashboard.users.delete', $user->id) }}')">
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