import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
document.addEventListener("DOMContentLoaded", async function () {
    // Initialize Echo instance
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
    });

    const badge = document.getElementById("notificationcount");
    const notificationList = document.querySelector("#DZ_W_Notification1 .timeline");
    const maxNotifications = 5; // Limit to 5 notifications
    let unreadCount = 0;

    // Track notification IDs to prevent duplicates
    const addedNotificationIds = new Set(); // A set to track already added notification IDs

    // Standard image fallback
    const imagePath = "dashboard/food/food1.jpeg";
    const defaultImage = getStorageUrl(imagePath);

    // Helper function to format notification data
    function formatNotificationData(notification) {
        const items = notification.data?.items || notification.items || [];
        const imageUrl = items[0]?.image || defaultImage;
        const linkUrl = notification.data?.link || notification.link || "#";
        const notificationMessage = notification.data?.title || notification.title;

        return {
            id: notification.id || notification.notification_id,
            imageUrl,
            linkUrl,
            message: notificationMessage,
            description: (notification.data?.message || "").slice(0, 30) + '...',
            createdAt: new Date(notification.created_at || new Date()).toLocaleString(),
        };
    }

    // Function to add a notification to the DOM
    function addNotificationToList(notificationData) {
        // Check if the notification has already been added
        if (addedNotificationIds.has(notificationData.id)) {
            return; // Skip adding duplicate notification
        }

        // Add the notification ID to the set
        addedNotificationIds.add(notificationData.id);

        const notificationItem = document.createElement("li");
        notificationItem.innerHTML = `
            <div class="timeline-panel" data-notification-id="${notificationData.id}">
                <div class="media me-2">
                    <img alt="image" width="50" src="${notificationData.imageUrl}">
                </div>
                <div class="media-body">
                    <a href="${notificationData.linkUrl}" class="notification-link" target="_blank">
                        <h6 class="mb-1">${notificationData.message}</h6>
                        <small class="d-block">${notificationData.description}</small>
                        <small class="d-block">${notificationData.createdAt}</small>
                    </a>
                </div>
            </div>
        `;

        // Add click event to mark as read
        notificationItem.addEventListener("click", async () => {
            await markNotificationAsRead(notificationData.id, notificationItem);
        });

        // Prepend new notification to list
        notificationList.prepend(notificationItem);
        limitNotificationDisplay(notificationList);
    }

    // Function to limit displayed notifications
    function limitNotificationDisplay(notificationList) {
        const notifications = notificationList.querySelectorAll("li");
        if (notifications.length > maxNotifications) {
            notifications[notifications.length - 1].remove();
        }
    }

    // Fetch unread notifications on page load
    try {
        const response = await fetch("/dashboard/hotel/notifications/unread");
        const data = await response.json();
        unreadCount = data.unread_count;
        badge.innerText = unreadCount;
        badge.classList.toggle("bg-primary", unreadCount > 0);

        if (data.notification.length === 0) {
            notificationList.innerHTML =
                '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>';
        } else {
            data.notification.forEach((notification) => {
                const formattedData = formatNotificationData(notification);

                // Only add the notification if it hasn't been added already
                if (!addedNotificationIds.has(formattedData.id)) {
                    addedNotificationIds.add(formattedData.id);
                    addNotificationToList(formattedData);
                }
            });
        }
    } catch (error) {
        console.error("Error fetching unread notifications:", error);
    }

    // Listen for new notifications via Pusher
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (event) => {
        alert("Received Requisition Requested:", event);
        const formattedData = formatNotificationData(event);

        // Only add the notification if it hasn't been added already
        if (!addedNotificationIds.has(formattedData.id)) {
            addedNotificationIds.add(formattedData.id);
            addNotificationToList(formattedData);

            // Update badge count
            unreadCount += 1;
            badge.innerText = unreadCount;
            badge.classList.add("bg-primary");
        }
    });

    window.Echo.channel("item-requisition").listen(".RequisitionRequested", (event) => {
        alert("Received Requisition Requested:", event);
        const formattedData = formatNotificationData(event);
        console.log("Received Requisition Requested:", event);
        // Only add the notification if it hasn't been added already
        if (!addedNotificationIds.has(formattedData.id)) {
            addedNotificationIds.add(formattedData.id);
            addNotificationToList(formattedData);

            // Update badge count
            unreadCount += 1;
            badge.innerText = unreadCount;
            badge.classList.add("bg-primary");
        }
    });

    window.Echo.channel("low_stock-alert").listen(".LowStockAlert", (event) => {
        const formattedData = formatNotificationData(event);

        // Only add the notification if it hasn't been added already
        if (!addedNotificationIds.has(formattedData.id)) {
            addedNotificationIds.add(formattedData.id);
            addNotificationToList(formattedData);

            // Update badge count
            unreadCount += 1;
            badge.innerText = unreadCount;
            badge.classList.add("bg-primary");
        }
    });

    // Mark notification as read and remove it from DOM
    async function markNotificationAsRead(notificationId, notificationItem) {
        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            const response = await fetch(
                `/dashboard/hotel/notifications/mark-as-read/${notificationId}`,
                {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                }
            );

            if (response.ok) {
                unreadCount -= 1;
                badge.innerText = unreadCount;
                badge.classList.toggle("bg-primary", unreadCount > 0);
                notificationItem.style.color = "gray"; // Mark it as read

                // Re-fetch unread notifications if space is available
                if (notificationList.childElementCount < maxNotifications) {
                    fetchAndAddUnreadNotifications();
                }
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
        }
    }

    // Fetch additional unread notifications to fill up empty space
    async function fetchAndAddUnreadNotifications() {
        try {
            const response = await fetch("/dashboard/hotel/notifications/unread");
            const data = await response.json();
            data.notification
                .slice(0, maxNotifications - notificationList.childElementCount)
                .forEach((notification) => {
                    const formattedData = formatNotificationData(notification);

                    // Only add the notification if it hasn't been added already
                    if (!addedNotificationIds.has(formattedData.id)) {
                        addedNotificationIds.add(formattedData.id);
                        addNotificationToList(formattedData);
                    }
                });
        } catch (error) {
            console.error("Error fetching additional unread notifications:", error);
        }
    }
});
