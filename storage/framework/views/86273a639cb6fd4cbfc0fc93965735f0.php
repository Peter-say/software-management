<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButton = document.getElementById('deleteButton');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        const checkAllBox = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.notification-checkbox');
        let selectedNotifications = [];

        function updateDeleteButton() {
            selectedNotifications = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            deleteButton.classList.toggle('d-none', selectedNotifications.length === 0);
            deleteButton.innerText = selectedNotifications.length === 1 ? 'Delete Selected' :
                'Delete All Selected';
        }

        checkAllBox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => checkbox.checked = checkAllBox.checked);
            updateDeleteButton();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateDeleteButton);
        });

        deleteButton.addEventListener('click', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });

        confirmDeleteButton.addEventListener('click', function() {
            const url = selectedNotifications.length === 1 ?
                routes.deleteSingle.replace('{id}', selectedNotifications[
                    0]) // Replace placeholder with actual ID
                :
                routes.deleteBulk;
            console.log(url); // Log the URL before the fetch call

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        notificationIds: selectedNotifications
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        selectedNotifications.forEach(id => {
                            document.querySelector(`.notification-row[data-id="${id}"]`)
                                .remove();
                        });
                        selectedNotifications = [];
                        updateDeleteButton();
                        Toastify({
                            text: "Notifications deleted successfully!",
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    } else {
                        Toastify({
                            text: "Error deleting notifications.",
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function confirmDelete(id) {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();

        confirmDeleteButton.onclick = function() {
            const url = routes.deleteSingle.replace('{id}', id); // Ensure the ID is replaced here

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.notification-row[data-id="${id}"]`).remove();
                        Toastify({
                            text: "Notification deleted successfully!",
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    } else {
                        Toastify({
                            text: "Error deleting notification.",
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    }
                });
        };
    }
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.querySelector(
            'tbody'); // Select the table body where notifications are displayed

        function fetchUnreadNotifications() {
            fetch('/dashboard/hotel/notifications/unread', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.unread_count > 0) {
                        data.notification.forEach(notification => {
                            // Check if the notification already exists in the table by ID
                            if (!document.querySelector(
                                    `tr[data-notification-id="${notification.id}"]`)) {
                                appendNotification(
                                    notification); // Append only if it doesn't already exist
                            }
                        });
                        document.getElementById('notificationcount').innerText = data
                            .unread_count; // Update the count
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Call fetchUnreadNotifications every 10 seconds
        setInterval(fetchUnreadNotifications, 10000);

        // Function to append a notification to the table body
        function appendNotification(notification) {
            const items = notification.data.items;
            const firstItemName = items[0].name || 'Unknown';
            const additionalCount = items.length - 1;

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-notification-id', notification.id);

            newRow.innerHTML = `
                <td>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" value="">
                    </div>
                </td>
                <td>${notification.id}</td>
                <td>
                    <a href="#" class="btn notification-link" data-id="${notification.id}" data-bs-toggle="modal"
                       data-bs-target="#notificationModal${notification.id}">
                        ${notification.data.message} for ${firstItemName}
                        ${additionalCount > 0 ? `and ${additionalCount} more` : ''}
                    </a>
                   
                </td>
                <td>
                    <a href="javascript:void(0);" class="btn-md text-info" data-status-id="${notification.id}">
                        <i class="fas fa-times-circle"></i> Not Read
                    </a>
                </td>
                <td>${formatDate(notification.created_at)}</td>
                 <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="confirmDelete('<?php echo e($notification->id); ?>')"
                                                                    class="btn btn-danger shadow btn-xs sharp">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
            `;

            tbody.prepend(newRow); // Add the new notification at the top of the list

            // Reattach event listeners for the "mark as read" functionality
            attachNotificationClickHandler(newRow);
        }

        // Function to attach the click event for marking notifications as read
        function attachNotificationClickHandler(row) {
            row.querySelector('.notification-link').addEventListener('click', function() {
                const notificationId = this.getAttribute('data-id');

                fetch(`/dashboard/hotel/notifications/mark-as-read/${notificationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI for read status
                            const statusElement = document.querySelector(
                                `[data-status-id="${notificationId}"]`);
                            if (statusElement) {
                                statusElement.classList.remove('text-info');
                                statusElement.classList.add('text-success');
                                statusElement.innerHTML =
                                    `<i class="fas fa-check-circle"></i> Read`;
                            }
                        }
                    })
                    .catch(error => console.error('Error marking notification as read:', error));
            });
        }
    });
</script><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/notification/order/notification-script.blade.php ENDPATH**/ ?>