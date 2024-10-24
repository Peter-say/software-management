<!-- Button trigger modal -->
<div class="modal fade" id="cancelOrderModal{{ $order->id }}" tabindex="-1" role="dialog"
    aria-labelledby="cancelOrderModal{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Cancellation Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this order?
            </div>
            <div class="modal-footer">
                <!-- Use a button to trigger the cancellation -->
                <button class="btn btn-primary cancelOrderBtn" data-order-id="{{ $order->id }}">
                    Confirm
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Use event delegation for the confirm buttons
        $(document).on('click', '.cancelOrderBtn', function() {
            var orderId = $(this).data('order-id'); // Get the order ID from the button
            console.log('Order ID:', orderId); // Log the order ID

            if (!orderId) {
                alert('Order ID is missing!');
                return;
            }

            $.ajax({
                url: '/dashboard/hotel/restaurant/' + orderId + '/cancel-order',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Send CSRF token
                    order_id: orderId // Send the order ID if needed on the server
                },
                success: function(response) {
                    // Display success message
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    }).showToast();

                    // Redirect if needed
                    if (response.success) {
                        setTimeout(function() {
                            window.location.href = response.redirectUrl;
                        }, 2000); // Redirect after 2 seconds
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'An error occurred';
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
