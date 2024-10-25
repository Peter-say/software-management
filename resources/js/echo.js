import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

document.addEventListener("DOMContentLoaded", async function () {
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
    });

    Pusher.logToConsole = true;

    const badge = document.getElementById("notificationcount");
    let unreadCount = 0; // Track unread notifications count

    // Fetch unread notifications count and list on page load
    try {
        const response = await fetch("/dashboard/hotel/notifications/unread");
        const data = await response.json();
        unreadCount = data.unread_count;
        badge.innerText = unreadCount;

        // Update badge class based on unread count
        if (unreadCount > 0) {
            badge.classList.add("bg-primary");
        } else {
            badge.classList.remove("bg-primary");
        }

        // Display notifications
        const notificationList = document.querySelector("#DZ_W_Notification1 .timeline");
        const defaultImage = 'http://127.0.0.1:7000/storage/hotel/restaurant/items/6701f36a193c3_food1.jpeg'; // Default image path

        data.notification.forEach(notification => {
            const imageUrl = notification.user_id 
                ? `images/avatar/${notification.user_id}.jpg` 
                : defaultImage;

            const notificationItem = document.createElement("li");
            notificationItem.innerHTML = `
                <div class="timeline-panel" data-notification-id="${notification.id}">
                    <div class="media me-2">
                        <img alt="image" width="50" src="${imageUrl}">
                    </div>
                    <div class="media-body">
                        <h6 class="mb-1">${notification.data.title || 'New notification'}</h6>
                         <p class="mb-1">${notification.data.message}</p>
                        <small class="d-block">${new Date(notification.created_at).toLocaleString()}</small>
                    </div>
                </div>
            `;
            if (notificationList) {
                notificationList.prepend(notificationItem);
            }

            // Add click event listener to the notification item
            notificationItem.addEventListener("click", async () => {
                await markNotificationAsRead(notification.id);
            });
        });
    } catch (error) {
        console.error("Error fetching unread notifications:", error);
    }

    // Listen for new notifications
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (event) => {
        console.log("New order notification:", event);

        // Add the new notification item to the list
        const defaultImage = 'http://127.0.0.1:7000/storage/hotel/restaurant/items/6701f36a193c3_food1.jpeg'; // Ensure default image is defined
        const imageUrl = event.user_id 
            ? `images/avatar/${event.user_id}.jpg` 
            : defaultImage;

        const notificationItem = document.createElement("li");
        notificationItem.innerHTML = `
            <div class="timeline-panel" data-notification-id="${event.notification_id}">
                <div class="media me-2">
                   <img alt="image" width="50" src="${imageUrl}">
                </div>
                <div class="media-body">
                    <h6 class="mb-1">${event.items[0]?.name || 'Item'} ordered</h6>
                    <small class="d-block">${new Date().toLocaleString()}</small>
                </div>
            </div>
        `;

        const notificationList = document.querySelector("#DZ_W_Notification1 .timeline");
        if (notificationList) {
            notificationList.prepend(notificationItem);
        }else{
            notificationList.add("You are caught off!");
        }

        // Increment the unread notifications counter
        unreadCount += 1;
        badge.innerText = unreadCount;
        badge.classList.add("bg-primary");

        // Add click event listener to the notification item
        notificationItem.addEventListener("click", async () => {
            await markNotificationAsRead(event.notification_id);
        });
    });

    // Function to mark notification as read
    async function markNotificationAsRead(notificationId) {
        try {
            const response = await fetch(`/dashboard/hotel/notifications/mark-read/${notificationId}`, { method: "POST" });
            if (response.ok) {
                unreadCount -= 1; // Decrement unread count
                badge.innerText = unreadCount;

                if (unreadCount === 0) {
                    badge.classList.remove("bg-primary");
                }

                // Remove the notification from the DOM
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.remove(); // Remove only if successfully marked as read
                }
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
        }
    }
});
