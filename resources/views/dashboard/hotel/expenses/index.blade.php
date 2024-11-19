@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">expenses</a></li>
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

                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    class="text-{{ $expense->paymentStatus() === 'pending' ? 'danger' : ($expense->paymentStatus() === 'partial' ? 'warning' : 'success') }} btn-md">
                                                                    {{ strtoupper($expense->paymentStatus()) }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <span
                                                                    class="fs-16 font-w500 text-nowrap">{{ number_format($expense->amount) ?? '' }}</span>
                                                            </td>

                                                            <td>
                                                                <div class="d-flex">
                                                                    @if ($expense->amount > $expense->payments()->sum('amount') || $expense->payments() === null)
                                                                        {{-- Payment Modal Button --}}
                                                                        <a type="button" data-bs-toggle="modal"
                                                                            data-bs-target="#payment-modal-{{ $expense->id }}"
                                                                            class="btn btn-primary shadow btn-xs sharp me-2">
                                                                            <i class="fas fa-money-bill"></i>
                                                                        </a>
                                                                    @endif
                                                                    <!-- Edit Button -->
                                                                    <a href="{{ route('dashboard.hotel.expenses.edit', $expense->id) }}"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>

                                                                    <!-- Delete Button -->
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger shadow btn-xs sharp"
                                                                        onclick="confirmDelete('{{ route('dashboard.hotel.expenses.destroy', $expense->id) }}')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            @include('dashboard.general.payment.modal', [
                                                                'payableType' => $payableType,
                                                                'payableModel' => $expense,
                                                                'currencies' => $currencies,
                                                            ])
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
