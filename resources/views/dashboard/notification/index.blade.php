@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item">Notifications</li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <div class="d-flex justify-content-end">
                                            <button id="deleteButton" class="btn btn-danger d-none mt-3">Delete
                                                Selected</button>

                                        </div>
                                        <div class="table-responsive">
                                            <table class="table card-table mb-4 shadow-hover table-responsive-lg"
                                                id="ordersTable">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <input type="checkbox" id="checkAll">
                                                        </th>
                                                        <th>ID</th>
                                                        <th>Message</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th class="bg-none">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($notifications && $notifications->count() > 0)
                                                        @foreach ($notifications as $notification)
                                                            <tr class="notification-row" data-id="{{ $notification->id }}">
                                                                <td>
                                                                    <input type="checkbox" class="notification-checkbox"
                                                                        value="{{ $notification->id }}">
                                                                </td>
                                                                <td>{{ $notification->id }}</td>
                                                                <td>
                                                                    <a href="#" class="notification-link"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#notificationModal{{ $notification->id }}">
                                                                        {{ $notification->data['message'] }}
                                                                        @if (isset($notification->data['items']) && count($notification->data['items']) > 1)
                                                                            and
                                                                            {{ count($notification->data['items']) - 1 }}
                                                                            more
                                                                        @endif
                                                                    </a>
                                                                    @if ($notification->type === 'App\Notifications\KitchenOrderNotification')
                                                                        @include(
                                                                            'dashboard.notification.order.details-modal',
                                                                            ['notification' => $notification]
                                                                        )
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-{{ $notification->read_at ? 'success' : 'info' }}">
                                                                        <i
                                                                            class="{{ $notification->read_at ? 'fas fa-check-circle' : 'fas fa-times-circle' }}"></i>
                                                                        {{ $notification->read_at ? 'Read' : 'Not Read' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $notification->created_at->format('Y-m-d H:i:s') }}
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="confirmDelete('{{ $notification->id }}')"
                                                                        class="btn btn-danger shadow btn-xs sharp">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <script>
                                                                const routes = {
                                                                    deleteSingle: "{{ route('dashboard.hotel.notifications.delete', $notification->id) }}", // Route URL without ID
                                                                    deleteBulk: "{{ route('dashboard.hotel.notifications.delete-bulk') }}"
                                                                };
                                                            </script>
                                                            @include('dashboard.notification.order.notification-script')
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Showing {{ $notifications->firstItem() }} to
                                                {{ $notifications->lastItem() }} of {{ $notifications->total() }} entries
                                            </div>
                                            <nav aria-label="Page navigation">
                                                {{ $notifications->links('pagination::bootstrap-4') }}
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected notifications?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
