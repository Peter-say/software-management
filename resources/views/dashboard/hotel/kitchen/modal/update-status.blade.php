
<!-- Modal for changing status -->
<div class="modal fade" id="changeStatusModal-{{ $kitchen->id }}" tabindex="-1"
    aria-labelledby="changeStatusModalLabel-{{ $kitchen->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel-{{ $kitchen->id }}">
                    Change Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.hotel.kitchen.orders.change-status', ['id' => $kitchen->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" class="form-control">
                            @foreach (getStatuses() as $status => $details)
                                <option value="{{ $status }}"
                                    {{ $kitchen->status == $status ? 'selected' : '' }}>
                                    {{ $details['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
