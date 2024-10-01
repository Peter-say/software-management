@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Restaurant Items</a></li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs ">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                {{-- <a class="nav-link active" data-bs-toggle="tab" href="#AllRooms">All Rooms</a> --}}
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.restaurant-items.create') }}" class="btn btn-secondary">+ New
                            Item</a>
                        <div class="newest ms-3">
                            <select class="default-select">
                                <option>Newest</option>
                                <option>Oldest</option>
                            </select>
                        </div>
                    </div>
                </div>
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
                                                        <th>Image</th>
                                                        <th>Price</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th class="bg-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($restaurant_items as $item)
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
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    @if ($item->image)
                                                                        <!-- Display the first attachment -->
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
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $item->description }}</span>
                                                            </td>
                                                            <td> <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ getItemAvailability($item->is_available) }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown dropend">
                                                                    <a href="javascript:void(0);" class="btn-link"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <svg width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M11 12C11 12.5523 11.4477 13 12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12Z"
                                                                                stroke="#262626" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M18 12C18 12.5523 18.4477 13 19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11C18.4477 11 18 11.4477 18 12Z"
                                                                                stroke="#262626" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M4 12C4 12.5523 4.44772 13 5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11C4.44772 11 4 11.4477 4 12Z"
                                                                                stroke="#262626" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('dashboard.hotel.restaurant-items.edit', $item->id) }}">Edit</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                                            onclick="confirmDelete('{{ route('dashboard.hotel.restaurant-items.destroy', $item->id) }}')">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center">
                                            {{ $restaurant_items->links() }}
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
