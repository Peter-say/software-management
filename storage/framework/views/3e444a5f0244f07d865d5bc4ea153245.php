<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Check-in Confirmation
        document.getElementById('confirmCheckIn').addEventListener('click', async function() {
            const guestId = <?php echo e($reservation->id); ?>;
            try {
                const response = await fetch(`/dashboard/hotel/reservation/${guestId}/check-in-guest`, {
                    method: 'PUT',
                    body: JSON.stringify({ id: guestId }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                if (data.success) {
                    Toastify({
                        text: data.message || 'Check-in successful.',
                        duration: 3000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    }).showToast();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                    // Dismiss the modal
                    const checkinModal = new bootstrap.Modal(document.getElementById('checkinModal'));
                    checkinModal.hide();
                } else {
                    handleErrorMessages(data.errors);
                }
            } catch (error) {
                console.error('Error:', error);
                Toastify({
                    text: error.message || 'An unexpected error occurred.',
                    duration: 3000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                }).showToast();
            }
        });

        // Handle Check-out Confirmation
        document.getElementById('confirmCheckOut').addEventListener('click', async function() {
            const guestId = <?php echo e($reservation->id); ?>;
            try {
                const response = await fetch(`/dashboard/hotel/reservation/${guestId}/check-out-guest`, {
                    method: 'PUT',
                    body: JSON.stringify({ id: guestId }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                if (data.success) {
                    Toastify({
                        text: data.message || 'Check-out successful.',
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }).showToast();
                    setTimeout(() => {
                        location.reload();
                    }, 5000);
                    // Dismiss the modal
                    const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
                    checkoutModal.hide();
                } else {
                    handleErrorMessages(data.errors);
                }
            } catch (error) {
                console.error('Error:', error);
                Toastify({
                    text: error.message || 'An unexpected error occurred.',
                    duration: 5000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                }).showToast();
            }
        });

        // Helper function to handle error messages
        function handleErrorMessages(errors) {
            let errorMessages = '';
            if (errors) {
                for (const [key, value] of Object.entries(errors)) {
                    errorMessages += value.join('<br>');
                }
            }
            Toastify({
                text: errorMessages || 'Validation errors occurred.',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
            }).showToast();
        }

        // Set guest ID when opening the modals
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                const guestId = this.getAttribute('data-guest-id');
                if (this.getAttribute('data-bs-target') === '#checkinModal') {
                    document.getElementById('checkinGuestId').value = guestId;
                } else if (this.getAttribute('data-bs-target') === '#checkoutModal') {
                    document.getElementById('checkoutGuestId').value = guestId;
                }
            });
        });
    });
</script><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/room/reservation/check-in-out-script.blade.php ENDPATH**/ ?>