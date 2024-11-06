@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Suppliers</a></li>
                </ol>
            </div>

            <!-- Action Bar -->
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs ">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <!-- Example for possible future tabs -->
                                {{-- <a class="nav-link active" data-bs-toggle="tab" href="#AllRooms">All Rooms</a> --}}
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.suppliers.create') }}" class="btn btn-secondary me-2">+
                           Add New</a>
                    </div>
                </div>

                <!-- Restaurant Items Table -->
                <div class="row ">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="AllRooms">
                                        <div class="table-responsive">
                                            <table class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                id="guestTable-all3">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <div class="form-check style-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="checkAll3">
                                                            </div>
                                                        </th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Contact Person Name</th>
                                                        <th>Contact Person Phone</th>
                                                        <th>Address</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Account No</th>
                                                        <th>Bank Holder Name</th>
                                                        <th>Status</th>
                                                        <th class="bg-none">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($suppliers as $supplier)
                                                        <tr>
                                                            <td>
                                                                <div class="form-check style-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    <div>
                                                                        <span
                                                                            class="fs-16 font-w500 text-nowrap">{{ $supplier->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $supplier->email ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $supplier->contact_person_name ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $supplier->contact_person_phone ?? 'N/A'}}</span>
                                                            </td>
                                                           
                                                            <td>
                                                                <span
                                                                class="fs-16 font-w500 text-nowrap">{{ $supplier->address ?? 'N/A'}}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                class="fs-16 font-w500 text-nowrap">{{ $supplier->bank_account_name ?? 'N/A'}}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                class="fs-16 font-w500 text-nowrap">{{ $supplier->bank_name ?? 'N/A'}}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                class="fs-16 font-w500 text-nowrap">{{ $supplier->bank_account_no ?? 'N/A'}}</span>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                        class="text-{{ $supplier->status == 'Active' ? 'success' : 'danger' }} btn-md">
                                                                        {{ strtoupper($supplier->status) }}
                                                                    </a>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <!-- Edit Button -->
                                                                    <a href="{{ route('dashboard.hotel.suppliers.edit', $supplier->id) }}"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>

                                                                    <!-- Delete Button -->
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger shadow btn-xs sharp"
                                                                        onclick="confirmDelete('{{ route('dashboard.hotel.suppliers.destroy', $supplier->id) }}')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center">
                                            {{ $suppliers->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this supplier?
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
