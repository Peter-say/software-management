@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item">Restaurant Orders</li>
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
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.restaurant.create-order') }}" class="btn btn-secondary">+ New
                            Order</a>
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
                                                        <th>Date</th>
                                                        <th>Restaurant</th>
                                                        <th>Waitstaff</th>
                                                        <th>Order By</th>
                                                        <th>Items</th>
                                                        <th>Total Amount</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th>Payment Status</th>
                                                        <th class="bg-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($restaurant_orders && $restaurant_orders->count() > 0)
                                                        @foreach ($restaurant_orders as $order)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check style-1">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                                <td>{{ $order->outlet->name }}</td>
                                                                <td>{{ $order->user->name }}</td>
                                                                <td>
                                                                    @if ($order->guest)
                                                                        {{ $order->guest->full_name }}
                                                                        <span>
                                                                            <i class="fas fa-question-circle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top" title="Guest Order">
                                                                            </i>
                                                                        </span>
                                                                    @endif
                                                                    @if ($order->walkInCustomer)
                                                                        {{ $order->walkInCustomer->name }}
                                                                        <span>
                                                                            <i class="fas fa-question-circle"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Walk-in Customer">
                                                                            </i>
                                                                        </span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-info"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#orderItemsModal{{ $order->id }}">
                                                                        View Items
                                                                    </button>

                                                                    @include(
                                                                        'dashboard.hotel.restaurant-item.order.order-items-modal',
                                                                        ['order' => $order]
                                                                    )
                                                                </td>
                                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        class="text-{{ $order->status == 'Open' ? 'success' : ($order->status == 'closed' ? 'secondary' : ($order->status == 'Cancelled' ? 'danger' : 'muted')) }} btn-md">
                                                                        {{ strtoupper($order->status) }}
                                                                    </a>
                                                                </td>

                                                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                                                <td
                                                                    class="text-{{ $order->paymentStatus() === 'paid' ? 'success' : ($order->paymentStatus() === 'partial' ? 'warning' : 'danger') }}">
                                                                    {{ strtoupper($order->paymentStatus()) }}
                                                                    <span>
                                                                        <i class="fas fa-question-circle"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="
                                                                                @if ($order->paymentStatus() === 'paid') Paid: ₦{{ number_format($order->payments->sum('amount'), 2, '.', ',') }} (Fully Paid)
                                                                                @elseif ($order->paymentStatus() === 'partial')
                                                                                    Paid: ₦{{ number_format($order->payments->sum('amount'), 2, '.', ',') }} 
                                                                                    (Remaining: ₦{{ number_format($order->total_amount - $order->payments->sum('amount'), 2, '.', ',') }})
                                                                                @else
                                                                                    Not Paid @endif
                                                                           ">
                                                                        </i>
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <div class="d-flex">
                                                                        {{-- Edit Order --}}
                                                                        <a href="{{ route('dashboard.hotel.restaurant.edit-order', $order->id) }}"
                                                                            class="btn btn-primary shadow btn-xs sharp me-2">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                        {{-- Delete Order --}}
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-danger shadow btn-xs sharp me-2"
                                                                            onclick="confirmDelete('{{ route('dashboard.hotel.restaurant.destroy-order', $order->id) }}')">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                        @if ($order->total_amount > $order->payments()->sum('amount') || $order->payments() === null)
                                                                            {{-- Payment Modal Button --}}
                                                                            <a type="button" data-bs-toggle="modal"
                                                                                data-bs-target="#paymentModal{{ $order->id }}"
                                                                                class="btn btn-primary shadow btn-xs sharp me-2">
                                                                                <i class="fas fa-money-bill"></i>
                                                                            </a>
                                                                        @endif
                                                                        @if ($order->status !== 'Cancelled')
                                                                            <!-- Button to trigger modal for each order -->
                                                                            <a type="button" data-bs-toggle="modal"
                                                                                data-bs-target="#cancelOrderModal"
                                                                                data-order-id="{{ $order->id }}"
                                                                                class="btn btn-warning shadow btn-xs sharp me-2 cancelOrderBtn">
                                                                                <i class="fas fa-times"></i>
                                                                            </a>
                                                                        @endif

                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @include('dashboard.hotel.restaurant-item.order.choose-paymet-method-modal',[
                                                                'order' => $order,
                                                                'payableType' => $payableType,
                                                                'payableModel' => $order,
                                                                'currencies' => $currencies,
                                                                ])
                                                                @include('dashboard.hotel.restaurant-item.order.cancel-modal', [
                                                'order' => $order,
                                            ])
                           
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
                                                Showing {{ $restaurant_orders->firstItem() }} to
                                                {{ $restaurant_orders->lastItem() }} of {{ $restaurant_orders->total() }}
                                                entries
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    {{ $restaurant_orders->links('pagination::bootstrap-4') }}
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
