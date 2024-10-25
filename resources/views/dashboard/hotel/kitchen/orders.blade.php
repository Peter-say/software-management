@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item">Orders</li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs mb-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#AllOrders">All Orders</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="AllOrders">
                                        <div class="table-responsive">
                                            <table class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                id="ordersTable">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <div class="form-check style-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="checkAll">
                                                            </div>
                                                        </th>
                                                        {{-- <th>kitchen</th> --}}
                                                        <th>Waitstaff</th>
                                                        <th>Orders</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th class="bg-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($kitchen_orders && $kitchen_orders->count() > 0)
                                                        @foreach ($kitchen_orders as $kitchen)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check style-1">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="">
                                                                    </div>
                                                                </td>
                                                                {{-- <td>{{ $kitchen->order->outlet->name }}</td> --}}
                                                                <td>{{ $kitchen->user->name ?? 'Not Available' }}</td>
                                                                <td>
                                                                    {{-- @php
                                                                        dd($kitchen->restaurantOrder);
                                                                    @endphp --}}
                                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" 
                                                                            data-bs-target="#orderItemsModal{{ $kitchen->restaurantOrder->id }}">
                                                                        View Items
                                                                    </button>
                                                                    
                                                                    @include('dashboard.hotel.restaurant-item.order.order-items-modal', ['order' => $kitchen->restaurantOrder->id])
                                                                </td>
                                                                <td>

                                                                    <a href="javascript:void(0);"
                                                                        class="btn-md text-{{ $kitchen->status == 'ready'
                                                                            ? 'success'
                                                                            : ($kitchen->status == 'in_progress'
                                                                                ? 'info'
                                                                                : ($kitchen->status == 'pending'
                                                                                    ? 'warning'
                                                                                    : 'secondary')) }}">
                                                                        <i
                                                                            class="{{ $kitchen->status == 'ready'
                                                                                ? 'fas fa-check-circle'
                                                                                : ($kitchen->status == 'in_progress'
                                                                                    ? 'fas fa-spinner'
                                                                                    : ($kitchen->status == 'pending'
                                                                                        ? 'fas fa-hourglass-start'
                                                                                        : 'fas fa-question-circle')) }}"></i>
                                                                        {{ strtoupper($kitchen->status ?? 'Pending') }}
                                                                    </a>

                                                                </td>

                                                                <td>{{ $kitchen->created_at->format('Y-m-d H:i:s') }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <button class="btn btn-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#changeStatusModal-{{ $kitchen->id }}">
                                                                            <i class="fas fa-sync-alt"></i> Change Status
                                                                        </button>
                                                                        {{-- Icon to Add Note with Tooltip --}}
                                                                        <a href="" class="btn btn-info btn-xs sharp"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addKitchenNoteModal-{{ $kitchen->id }}"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="Add Note">
                                                                            <i class="fas fa-sticky-note"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                @include(
                                                                    'dashboard.hotel.kitchen.modal.add-note',
                                                                    ['kitchen' => $kitchen]
                                                                )
                                                                @include(
                                                                    'dashboard.hotel.kitchen.modal.update-status',
                                                                    ['kitchen' => $kitchen]
                                                                )
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="10" class="text-center">No orders found.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Showing {{$kitchen_orders->firstItem() }} to {{ $kitchen_orders->lastItem() }} of {{ $kitchen_orders->total() }} entries
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    {{ $kitchen_orders->links('pagination::bootstrap-4') }}
                                                </ul>
                                            </nav>
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
                    Are you sure you want to delete this order?
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
