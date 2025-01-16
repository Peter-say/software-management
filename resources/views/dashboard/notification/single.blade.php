@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.notifications.view-all') }}">Notifications</a></li>
                    <li class="breadcrumb-item">Details</li>
                </ol>
            </div>

            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <!-- Notification Title -->
                                        <div class="d-flex justify-content-between p-3">
                                            <div class="d-flex flex-column">
                                                <h4 class="font-weight-bold">{{ $notification->data['title']}}</h4>
                                                <p class="text-muted">Notification ID: {{ $notification->id }}</p>
                                                <p class="mb-2">{{ $notification->data['message'] }}</p>
                                                <p class="text-primary font-weight-bold">Status: {{ $notification->data['status'] }}</p>
                                            </div>
                                        </div>

                                        <!-- Conditional Display based on Notification Type -->
                                        @if($notification->type === 'App\Notifications\KitchenOrderNotification')
                                            <!-- Kitchen Order Details -->
                                            <div class="p-3">
                                                <h5 class="font-weight-bold">Order Details:</h5>
                                                <p><strong>Order ID:</strong> {{ $notification->data['order_id'] }}</p>
                                                <p><strong>Total Amount:</strong> ${{ $notification->data['total_amount'] }}</p>
                                                <p><strong>Status:</strong> {{ $notification->data['status'] }}</p>

                                                <h6 class="font-weight-bold">Items in the Order:</h6>
                                                <ul class="list-group">
                                                    @foreach ($notification->data['items'] as $item)
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong>{{ $item['name'] }}</strong>
                                                                </div>
                                                                <div class="text-muted">
                                                                    Quantity: {{ $item['quantity'] }}
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif($notification->type === 'App\Notifications\StoreItemRequisitionNotification')
                                            <!-- Store Item Requisition Details -->
                                            <div class="p-3">
                                                <h5 class="font-weight-bold">Requisition Details:</h5>
                                                <p><strong>Requisition ID:</strong> {{ $notification->data['requisition_id'] }}</p>
                                                <p><strong>Department:</strong> {{ $notification->data['department'] }}</p>
                                                <p><strong>Purpose:</strong> {{ $notification->data['purpose'] }}</p>
                                                <p><strong>Status:</strong> {{ $notification->data['status'] }}</p>

                                                <h6 class="font-weight-bold">Items Requested:</h6>
                                                <ul class="list-group">
                                                    @foreach ($notification->data['items'] as $item)
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong>{{ $item['item_name'] }}</strong>
                                                                </div>
                                                                <div class="text-muted">
                                                                    Quantity: {{ $item['quantity'] }} {{ $item['unit'] ?? '' }}
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <!-- Handle other notification types or show an error message -->
                                            <div class="alert alert-warning">Unknown notification type.</div>
                                        @endif

                                        <!-- Link to view more details -->
                                        {{-- <div class="d-flex justify-content-end p-3">
                                            <a href="{{ $notification->link }}" class="btn btn-primary">View Details</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
