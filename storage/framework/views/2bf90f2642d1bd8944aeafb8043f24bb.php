
<!-- Modal for order deletelation, created only once -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order delection Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <!-- Confirmation button for deletelation -->
                <button class="btn btn-primary confirmdeleteOrderBtn">Confirm</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let orderId; // Variable to hold the current order ID

        // Capture the order ID when the delete button is clicked
        $(document).on('click', '.deleteOrderBtn', function() {
            orderId = $(this).data('order-id'); // Set the order ID from button data
            console.log('Selected Order ID:', orderId); // Log the selected order ID
        });

        // Confirm deletelation action
        $(document).on('click', '.confirmdeleteOrderBtn', function() {
            if (!orderId) {
                alert('Order ID is missing!');
                return;
            }

            $.ajax({
                url: '/dashboard/hotel/bar/' + orderId + '/delete-order',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>', // Send CSRF token
                    order_id: orderId // Send the order ID if needed on the server
                },
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    }).showToast();

                    // Redirect if needed
                    if (response.success) {
                        window.location.href = response.redirectUrl; // Redirect immediately
                    }
                },
                error: function(xhr) {
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
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/bar-items/order/delete-modal.blade.php ENDPATH**/ ?>