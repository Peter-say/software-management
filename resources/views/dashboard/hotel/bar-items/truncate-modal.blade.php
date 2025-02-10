<!-- Modal -->
<div class="modal fade" id="truncate-items-modal" tabindex="-1" role="dialog" aria-labelledby="truncate-items-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Truncate Restaurant Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="truncateItemsForm" method="POST">
                @csrf
                @method('DELETE')

                {{-- <input type="hidden" name="items" id="items" value="{{ $items }}"> --}}

                <div class="modal-body">
                    Are you sure you want to delete all the items? Be certain. Deleted items cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="truncateItemsBtn">Proceed</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#truncateItemsForm').on('submit', function (event) {
            event.preventDefault(); // Prevent default form submission
            
            $.ajax({
                url: '{{ route('dashboard.hotel.bar-items.truncate') }}',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE',
                    items: $('#items').val()
                },
                success: function (response) {
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    }).showToast();

                    $('#truncate-items-modal').modal('hide'); // Close modal on success
                },
                error: function (xhr) {
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred';
                    Toastify({
                        text: errorMessage,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }).showToast();
                }
            });
        });
    });
</script>
