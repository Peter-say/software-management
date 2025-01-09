@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('dashboard.hotel.expenses-dashbaord')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Details</a></li>
                </ol>
            </div>

            <!-- Action Bar -->
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-end align-items-center flex-wrap">
                    <div class="card-action coin-tabs ">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <!-- Example for possible future tabs -->
                                {{-- <a class="nav-link active" data-bs-toggle="tab" href="#AllRooms">All Rooms</a> --}}
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.expenses-dashbaord') }}" class="btn btn-secondary me-2">
                            View Dashboard</a>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.expenses.create') }}" class="btn btn-secondary me-2">+
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
                                                        <th>Date</th>
                                                        <th>Category</th>
                                                        <th>Item(s)</th>
                                                        <th>Supplier</th>
                                                        <th>Payment Status</th>
                                                        <th>Amount</th>
                                                        <th class="bg-none">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($expenses as $expense)
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
                                                                            class="fs-16 font-w500 text-nowrap">{{ $expense->expense_date->format('jS, M Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $expense->category->name }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $expense->getItems() ?? '' }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ $expense->supplier->name ?? 'N/A' }}</span>
                                                            </td>

                                                            <td
                                                                class="text-{{ $expense->paymentStatus() === 'paid' ? 'success' : ($expense->paymentStatus() === 'partial' ? 'warning' : 'danger') }}">
                                                                {{ strtoupper($expense->paymentStatus()) }}
                                                                <span>
                                                                    <i class="fas fa-question-circle"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="
                                                                        @if ($expense->paymentStatus() === 'paid') Paid: ₦{{ number_format($expense->payments->sum('amount'), 2, '.', ',') }} (Fully Paid)
                                                                        @elseif ($expense->paymentStatus() === 'partial')
                                                                            Paid: ₦{{ number_format($expense->payments->sum('amount'), 2, '.', ',') }} 
                                                                            (Remaining: ₦{{ number_format($expense->amount - $expense->payments->sum('amount'), 2, '.', ',') }})
                                                                        @else
                                                                            Not Paid @endif
                                                                   ">
                                                                    </i>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ number_format($expense->amount) ?? '' }}</span>
                                                            </td>

                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="{{ route('dashboard.hotel.expenses.show', $expense->id) }}"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    @if ($expense->paymentStatus() !== 'paid')
                                                                        <!-- Edit Button -->
                                                                        <a href="{{ route('dashboard.hotel.expenses.edit', $expense->id) }}"
                                                                            class="btn btn-primary shadow btn-xs sharp me-1">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                    @endif
                                                                    <!-- Delete Button -->
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger shadow btn-xs sharp"
                                                                        onclick="confirmDelete('{{ route('dashboard.hotel.expenses.destroy', $expense->id) }}')">
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
                                            {{ $expenses->links() }}
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
                    Are you sure you want to delete this expense?
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
