import { P as E, E as v } from "./pusher-DxtW_XPu.js";
window.Pusher = E;
document.addEventListener("DOMContentLoaded", async function () {
    window.Echo = new v({
        broadcaster: "pusher",
        key: "adadb8e8c491818d6a8f",
        cluster: "eu",
        forceTLS: !0,
    });
    const o = document.getElementById("notificationcount"),
        r = document.querySelector("#DZ_W_Notification1 .timeline"),
        s = 5;
    let a = 0;
    const p =
        "http://127.0.0.1:7000/storage/hotel/restaurant/items/6701f36a193c3_food1.jpeg";
    function c(e) {
        var f, h, u, g;
        const t = ((f = e.data) == null ? void 0 : f.items) || e.items || [],
            n = ((h = t[0]) == null ? void 0 : h.image) || p,
            i = ((u = e.data) == null ? void 0 : u.link) || e.link || "#",
            l = t.length,
            m = ((g = t[0]) == null ? void 0 : g.name) || "Item",
            w = l > 1 ? `${m} ordered and ${l - 1} more` : `${m} ordered`;
        return {
            id: e.id || e.notification_id,
            imageUrl: n,
            linkUrl: i,
            message: w,
            createdAt: new Date(e.created_at || new Date()).toLocaleString(),
        };
    }
    function d(e) {
        const t = document.createElement("li");
        (t.innerHTML = `
            <div class="timeline-panel" data-notification-id="${e.id}">
                <div class="media me-2">
                    <img alt="image" width="50" src="${e.imageUrl}">
                </div>
                <div class="media-body">
                    <a href="${e.linkUrl}" class="notification-link" target="_blank">
                        <h6 class="mb-1">${e.message}</h6>
                        <small class="d-block">${e.createdAt}</small>
                    </a>
                </div>
            </div>
        `),
            t.addEventListener("click", async () => {
                await b(e.id, t);
            }),
            r.prepend(t),
            y(r);
    }
    function y(e) {
        const t = e.querySelectorAll("li");
        t.length > s && t[t.length - 1].remove();
    }
    try {
        const t = await (
            await fetch("/dashboard/hotel/notifications/unread")
        ).json();
        (a = t.unread_count),
            (o.innerText = a),
            o.classList.toggle("bg-primary", a > 0),
            t.notification.length === 0
                ? (r.innerHTML =
                      '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>')
                : t.notification.forEach((n) => {
                      const i = c(n);
                      d(i);
                  });
    } catch (e) {
        console.error("Error fetching unread notifications:", e);
    }
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (e) => {
        const t = c(e);
        d(t), (a += 1), (o.innerText = a), o.classList.add("bg-primary");
    });
    async function b(e, t) {
        try {
            const n = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            (
                await fetch(
                    `/dashboard/hotel/notifications/mark-as-read/${e}`,
                    {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": n,
                            "Content-Type": "application/json",
                        },
                    }
                )
            ).ok &&
                ((a -= 1),
                (o.innerText = a),
                o.classList.toggle("bg-primary", a > 0),
                (t.style.color = "gray"),
                r.childElementCount < s && k());
        } catch (n) {
            console.error("Error marking notification as read:", n);
        }
    }
    async function k() {
        try {
            (
                await (
                    await fetch("/dashboard/hotel/notifications/unread")
                ).json()
            ).notification
                .slice(0, s - r.childElementCount)
                .forEach((n) => {
                    const i = c(n);
                    d(i);
                });
        } catch (e) {
            console.error("Error fetching additional unread notifications:", e);
        }
    }
});
