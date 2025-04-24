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
                                <a class="nav-link active" data-bs-toggle="tab" href="#AllReservations">All Reservations</a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.reservation-dashboard') }}" class="btn btn-secondary me-2">
                            View Dashboard</a>
                        <a href="{{ route('dashboard.hotel.reservations.create') }}" class="btn btn-secondary">+ New
                            Reservation</a>
                        <div class="newest ms-3">
                            <select class="default-select">
                                <option>Newest</option>
                                <option>Oldest</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="AllReservations">
                                        <div class="table-responsive">
                                            <table class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                id="reservationsTable">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <div class="form-check style-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="checkAll">
                                                            </div>
                                                        </th>
                                                        <th>Guest</th>
                                                        <th>Room</th>
                                                        <th>Rate</th>
                                                        <th>Total Amount</th>
                                                        <th>Check-in Date</th>
                                                        <th>Check-out Date</th>
                                                        <th>Check-In At</th>
                                                        <th>Check-out At</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th>Payment Status</th>
                                                        <th class="bg-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($reservations && $reservations->count() > 0)
                                                        @foreach ($reservations as $reservation)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check style-1">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $reservation->guest->fullName }}</td>
                                                                <td>{{ $reservation->room->name }}</td>
                                                                <td>{{ number_format($reservation->rate )}}</td>
                                                                <td>{{ number_format($reservation->total_amount) }}</td>
                                                                <td>{{ $reservation->checkin_date ? $reservation->checkin_date->format('Y-m-d') : 'N/A' }}
                                                                </td>
                                                                <td>{{ $reservation->checkout_date ? $reservation->checkout_date->format('Y-m-d') : 'N/A' }}</td>
                                                                    <td>{{ $reservation->checked_in_at ? $reservation->checked_in_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                                                        <td>{{ $reservation->checked_out_at ? $reservation->checked_out_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                                                </td>

                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-{{ $reservation->status == 'active' ? 'success' : 'danger' }} btn-md">
                                                                        {{ strtoupper($reservation->status) }}
                                                                    </a>
                                                                </td>
                                                                <td>{{ $reservation->created_at->format('Y-m-d H:i:s') }}
                                                                </td>
                                                                <td class="text-{{$reservation->payment_status === 'completed' ? 'success' : 'warning'}}">{{strtoupper( $reservation->payment_status) }}</td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('dashboard.hotel.reservations.show', $reservation->reservation_code) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('dashboard.hotel.reservations.edit', $reservation->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" onclick="confirmDelete('{{ route('dashboard.hotel.reservations.destroy', $reservation->id) }}')">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="15" class="text-center">No reservations found.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center">
                                            {{ $reservations->links() }}
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this reservation?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
