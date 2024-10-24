
<!-- Modal for adding note -->
<div class="modal fade" id="addKitchenNoteModal-{{ $kitchen->id }}" tabindex="-1"
    aria-labelledby="addKitchenNoteModalLabel-{{ $kitchen->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKitchenNoteLabel-{{ $kitchen->id }}">
                    Add Note
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.hotel.kitchen.orders.add-note', ['id' => $kitchen->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Additional Notes (optional) --}}
                    <div class="form-group mb-3">
                        <label for="notes">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
