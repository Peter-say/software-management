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
    let unreadCount = 0;

    const notificationList = document.querySelector("#DZ_W_Notification1 .timeline");
    const defaultImage = 'http://127.0.0.1:7000/storage/hotel/restaurant/items/6701f36a193c3_food1.jpeg';

    // Display empty state if no notifications
    function displayEmptyState() {
        if (notificationList) {
            notificationList.innerHTML = '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>';
        }
    }

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

        if (data.notification.length === 0) {
            displayEmptyState();
        } else {
            data.notification.forEach(notification => {
                const imageUrl = notification.data.items[0]?.image || defaultImage;
                const linkUrl = notification.data.link || '#';

                const itemsList = notification.data.items.map(item => `<li>${item.name}</li>`).join('') || '<li>Item ordered</li>';
                const notificationItem = document.createElement("li");

                notificationItem.innerHTML = `
                    <div class="timeline-panel" data-notification-id="${notification.id}">
                        <div class="media me-2">
                            <img alt="image" width="50" src="${imageUrl}">
                        </div>
                        <div class="media-body">
                            <a href="${linkUrl}" class="notification-link" target="_blank">
                                <h6 class="mb-1">${notification.data.title || 'New notification'}</h6>
                                <p class="mb-1">${notification.data.message}</p>
                                <ul>${itemsList}</ul>
                                <small class="d-block">${new Date(notification.created_at).toLocaleString()}</small>
                            </a>
                        </div>
                    </div>
                `;
                notificationList.prepend(notificationItem);

                // Mark notification as read on click
                notificationItem.querySelector(".notification-link").addEventListener("click", async (event) => {
                    event.preventDefault();
                    await markNotificationAsRead(notification.id);
                    window.open(linkUrl, "_blank"); // Open the link in a new tab
                });
            });
        }
    } catch (error) {
        console.error("Error fetching unread notifications:", error);
        displayEmptyState();
    }

    // Listen for new notifications
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (event) => {
        console.log("New order notification:", event);

        const imageUrl = event.items[0]?.image || defaultImage;
        const linkUrl = event.link || '#';


        const itemsList = event.items.map(item => `<li>${item.name}</li>`).join('') || '<li>Item ordered</li>';
        const notificationItem = document.createElement("li");

        notificationItem.innerHTML = `
            <div class="timeline-panel" data-notification-id="${event.notification_id}">
                <div class="media me-2">
                    <img alt="image" width="50" src="${imageUrl}">
                </div>
                <div class="media-body">
                    <a href="${linkUrl}" class="notification-link" target="_blank">
                        <h6 class="mb-1">${event.items[0]?.name || 'Item'} ordered</h6>
                        <ul>${itemsList}</ul>
                        <small class="d-block">${new Date().toLocaleString()}</small>
                    </a>
                </div>
            </div>
        `;

        if (notificationList) {
            notificationList.prepend(notificationItem);
        } else {
            displayEmptyState();
        }

        unreadCount += 1;
        badge.innerText = unreadCount;
        badge.classList.add("bg-primary");

        // Mark notification as read on click
        notificationItem.querySelector(".notification-link").addEventListener("click", async (event) => {
            event.preventDefault();
            await markNotificationAsRead(event.notification_id);
            window.open(linkUrl, "_blank"); // Open the link in a new tab
        });
    });

    // Function to mark notification as read
    async function markNotificationAsRead(notificationId) {
        try {
            const response = await fetch(`/dashboard/hotel/notifications/mark-read/${notificationId}`, { method: "POST" });
            if (response.ok) {
                unreadCount -= 1;
                badge.innerText = unreadCount;

                if (unreadCount === 0) {
                    badge.classList.remove("bg-primary");
                    displayEmptyState();
                }

                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.remove();
                }
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
        }
    }
});
