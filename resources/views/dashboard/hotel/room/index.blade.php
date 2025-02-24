@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Components</a></li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs mb-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#AllRooms">All Rooms</a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.rooms.create') }}" class="btn btn-secondary">+ New Room</a>
                        <div class="newest ms-3">
                            <form id="filter-form" class="d-flex justify-content-between gap-3">
                                <div class="form-group me-2">
                                    <input class="form-control" type="text" placeholder="Search...." name="search"
                                        value="{{ request()->search }}" id="search-input">
                                </div>
                                <select class="default-select room-selection" id="room-selection">
                                    <option name="select_room" value="Newest"
                                        {{ request()->selection == 'Newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option name="select_room" value="Oldest"
                                        {{ request()->selection == 'Oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                    <option name="select_room" value="Available"
                                        {{ request()->selection == 'Available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option name="select_room" value="Occupied"
                                        {{ request()->selection == 'Occupied' ? 'selected' : '' }}>
                                        Occupied</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
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
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="checkAll3">
                                                        </div>
                                                    </th>
                                                    <th>Room Name</th>
                                                    <th>Room Type</th>
                                                    <th>Rate</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th class="bg-none"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($rooms) > 0)
                                                    @foreach ($rooms as $room)
                                                        <tr>
                                                            <td>
                                                                <div class="form-check style-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="room-list-bx d-flex align-items-center">
                                                                    <a href="{{ $room->RoomImage() }}"
                                                                        data-fancybox="gallery_{{ $room->id }}"
                                                                        data-caption="{{ $room->name }}">
                                                                        <img class="me-3 rounded img-thumbnail"
                                                                            src="{{ $room->RoomImage() }}"
                                                                            alt="{{ basename($room->RoomImage()) }}">
                                                                    </a>
                                                                    @foreach ($room->RoomImages()->skip(1) as $key => $image)
                                                                        <a href="{{ getStorageUrl($image->file_path) }}"
                                                                            data-fancybox="gallery_{{ $room->id }}"
                                                                            data-caption="{{ $room->name }}">
                                                                            <img class="me-3 rounded img-thumbnail"
                                                                                src="{{ getStorageUrl($image->file_path) }}"
                                                                                alt="{{ basename($image->file_path) }}"
                                                                                style="display: none">
                                                                        </a>
                                                                    @endforeach

                                                                    <div>
                                                                        <span
                                                                            class="fs-16 font-w500 text-nowrap">{{ $room->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $room->roomType->name }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="">
                                                                    <span class="mb-2">Price</span>
                                                                    <span
                                                                        class="font-w500">{{currencySymbol()}}{{ number_format($room->roomType->rate) }}<small
                                                                            class="fs-14 ms-2">/night</small></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <span
                                                                        class="fs-16 font-w500">{{ $room->description }}</span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-{{ $room->status == 'active' ? 'success' : 'danger' }} btn-md">
                                                                    {{ strtoupper($room->status) }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-between">
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
                                                                                href="{{ route('dashboard.hotel.rooms.edit', $room->id) }}">Edit</a>
                                                                            <a class="dropdown-item"
                                                                                href="javascript:void(0);"
                                                                                onclick="confirmDelete('{{ route('dashboard.hotel.rooms.destroy', $room->id) }}')">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $hasReservations = $room->reservations->isNotEmpty();
                                                                        $checkin_date = $hasReservations
                                                                            ? optional(
                                                                                $room->reservations
                                                                                    ->pluck('checkin_date')
                                                                                    ->first(),
                                                                            )->format('Y-m-d')
                                                                            : null;
                                                                        $checkout_date = $hasReservations
                                                                            ? optional(
                                                                                $room->reservations
                                                                                    ->pluck('checkout_date')
                                                                                    ->first(),
                                                                            )->format('Y-m-d')
                                                                            : null;
                                                                    @endphp

                                                                    @if (!$hasReservations || ($checkin_date && $checkout_date && $room->isAvailable($checkin_date, $checkout_date)))
                                                                        <a href="{{ route('dashboard.hotel.reservations.create') }}?requested_room_id={{ $room->id }}"
                                                                            class="btn btn-dark btn-md">
                                                                            Book
                                                                        </a>
                                                                    @endif


                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">No data available in table
                                                        </td>
                                                @endif
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center">
                                        {{ $rooms->links() }}
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $(document).ready(function() {
                const form = document.getElementById('filter-form');

                $('.room-selection').change(function() {
                    let selectValue = $(this).val();

                    $.ajax({
                        url: "{{ route('dashboard.hotel.filter.rooms') }}",
                        type: "GET",
                        data: {
                            select_room: selectValue
                        },
                        success: function(response) {
                            $('#guestTable-all3 tbody').html(response.html);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });

                $('#search-input').keyup(function() {
                    let searchValue = $(this).val();

                    $.ajax({
                        url: "{{ route('dashboard.hotel.filter.rooms') }}",
                        type: "GET",
                        data: {
                            search_term: searchValue
                        },
                        success: function(response) {
                            console.log(response);

                            $('#guestTable-all3 tbody').html(response.html);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });

                form.addEventListener('submit', (event) => {
                    const submitter = event.submitter;
                    if (!submitter || !submitter.classList.contains('btn-success')) {
                        event.preventDefault();
                        console.log("Submission prevented: Not the filter button.");
                    }
                });
            });
        });
    </script>

@endsection
