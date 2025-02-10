@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Order Items</a></li>
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
                        <a href="{{ route('dashboard.hotel.bar-items.create') }}" class="btn btn-secondary me-2">+
                            New Item</a>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#upload-bar-items-modal"
                            class="btn btn-primary me-2">Upload Items</a>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#truncate-items-modal"
                            class="btn btn-primary me-2">Truncate Items <i class="fas fa-question-circle"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete all the bar items"></i></a>
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
                                                        <th>Item Name</th>
                                                        <th>Category</th>
                                                        <th>Image</th>
                                                        <th>Price</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th class="bg-none">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bar_items as $item)
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
                                                                            class="fs-16 font-w500 text-nowrap">{{ $item->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $item->category ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    @if ($item->image)
                                                                        <a href="{{ $item->itemImage() }}"
                                                                            data-fancybox="gallery_{{ $item->id }}"
                                                                            data-caption="{{ $item->name }}">
                                                                            <img src="{{ $item->itemImage() }}"
                                                                                alt="Image" class="img-thumbnail"
                                                                                style="width: 60px; height: 60px;">
                                                                        </a>
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">₦{{ number_format($item->price) }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="fs-16 font-w500 text-nowrap">
                                                                    <button type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#generalItemDescriptionModal"
                                                                        class="btn btn-primary btn-sm show-body"
                                                                        data-item-id="{{ $item->id }}"
                                                                        data-item-content="{{ $item->description }}">
                                                                        View
                                                                    </button>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ getItemAvailability($item->is_available) }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <!-- Edit Button -->
                                                                    <a href="{{ route('dashboard.hotel.bar-items.edit', $item->id) }}"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>

                                                                    <!-- Delete Button -->
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger shadow btn-xs sharp"
                                                                        onclick="confirmDelete('{{ route('dashboard.hotel.bar-items.destroy', $item->id) }}')">
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
                                            {{ $bar_items->links() }}
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
    {{-- @include('dashboard.hotel.bar-items.truncate-modal'); --}}
    {{-- @include('dashboard.hotel.bar-items.upload-modal') --}}
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
                    Are you sure you want to delete this room?
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
