<table class="table card-table display mb-4 shadow-hover table-responsive-lg" id="guestTable-all3">

    <tbody>
        @if (count($rooms) > 0)
            @foreach ($rooms as $room)
                <tr>
                    <td>
                        <div class="form-check style-1">
                            <input class="form-check-input" type="checkbox" value="">
                        </div>
                    </td>
                    <td>
                        <div class="room-list-bx d-flex align-items-center">
                            <a href="{{ $room->RoomImage() }}" data-fancybox="gallery_{{ $room->id }}"
                                data-caption="{{ $room->name }}">
                                <img class="me-3 rounded img-thumbnail" src="{{ $room->RoomImage() }}"
                                    alt="{{ basename($room->RoomImage()) }}">
                            </a>
                            @foreach ($room->RoomImages()->skip(1) as $key => $image)
                                <a href="{{ getStorageUrl($image->file_path) }}"
                                    data-fancybox="gallery_{{ $room->id }}" data-caption="{{ $room->name }}">
                                    <img class="me-3 rounded img-thumbnail" src="{{ getStorageUrl($image->file_path) }}"
                                        alt="{{ basename($image->file_path) }}" style="display: none">
                                </a>
                            @endforeach

                            <div>
                                <span class="fs-16 font-w500 text-nowrap">{{ $room->name }}</span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="fs-16 font-w500 text-nowrap">{{ $room->roomType->name }}</span>
                    </td>
                    <td>
                        <div class="">
                            <span class="mb-2">Price</span>
                            <span class="font-w500">{{ $room->roomType->rate }}<small
                                    class="fs-14 ms-2">/night</small></span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="fs-16 font-w500">{{ $room->description }}</span>
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
                                <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11 12C11 12.5523 11.4477 13 12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12Z"
                                            stroke="#262626" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M18 12C18 12.5523 18.4477 13 19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11C18.4477 11 18 11.4477 18 12Z"
                                            stroke="#262626" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M4 12C4 12.5523 4.44772 13 5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11C4.44772 11 4 11.4477 4 12Z"
                                            stroke="#262626" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.hotel.rooms.edit', $room->id) }}">Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        onclick="confirmDelete('{{ route('dashboard.hotel.rooms.destroy', $room->id) }}')">Delete</a>
                                </div>
                            </div>
                            @php
                                $hasReservations = $room->reservations->isNotEmpty();
                                $checkin_date = $hasReservations
                                    ? optional($room->reservations->pluck('checkin_date')->first())->format('Y-m-d')
                                    : null;
                                $checkout_date = $hasReservations
                                    ? optional($room->reservations->pluck('checkout_date')->first())->format('Y-m-d')
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
                <td colspan="7" class="text-center">No data available in table</td>
        @endif
    </tbody>
</table>
