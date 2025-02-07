import { P as b, E as k } from "./pusher-DxtW_XPu.js";
window.Pusher = b;
console.log(window.Pusher, "hello");
document.addEventListener("DOMContentLoaded", async function () {
    window.Echo = new k({
        broadcaster: "pusher",
        key: "adadb8e8c491818d6a8f",
        cluster: "eu",
        forceTLS: !0,
    });
    const i = document.getElementById("notificationcount"),
        o = document.querySelector("#DZ_W_Notification1 .timeline"),
        d = 5;
    let a = 0;
    // const u = getStorageUrl("dashboard/food/food1.jpeg");
    function s(e) {
        var l, m, h, g, f;
        const n =
                ((m = (((l = e.data) == null ? void 0 : l.items) ||
                    e.items ||
                    [])[0]) == null
                    ? void 0
                    : m.image) || u,
            c = ((h = e.data) == null ? void 0 : h.link) || e.link || "#",
            y = ((g = e.data) == null ? void 0 : g.title) || e.title;
        return {
            id: e.id || e.notification_id,
            imageUrl: n,
            linkUrl: c,
            message: y,
            description:
                (((f = e.data) == null ? void 0 : f.message) || "").slice(
                    0,
                    30
                ) + "...",
            createdAt: new Date(e.created_at || new Date()).toLocaleString(),
        };
    }
    function r(e) {
        const t = document.createElement("li");
        (t.innerHTML = `
            <div class="timeline-panel" data-notification-id="${e.id}">
                <div class="media me-2">
                    <img alt="image" width="50" src="${e.imageUrl}">
                </div>
                <div class="media-body">
                    <a href="${e.linkUrl}" class="notification-link" target="_blank">
                        <h6 class="mb-1">${e.message}</h6>
                         <small class="d-block">${e.description}</small>
                        <small class="d-block">${e.createdAt}</small>
                    </a>
                </div>
            </div>
        `),
            t.addEventListener("click", async () => {
                await w(e.id, t);
            }),
            o.prepend(t),
            p(o);
    }
    function p(e) {
        const t = e.querySelectorAll("li");
        t.length > d && t[t.length - 1].remove();
    }
    try {
        const t = await (
            await fetch("/dashboard/hotel/notifications/unread")
        ).json();
        (a = t.unread_count),
            (i.innerText = a),
            i.classList.toggle("bg-primary", a > 0),
            t.notification.length === 0
                ? (o.innerHTML =
                      '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>')
                : t.notification.forEach((n) => {
                      const c = s(n);
                      r(c);
                  });
    } catch (e) {
        console.error("Error fetching unread notifications:", e);
    }
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (e) => {
        const t = s(e);
        r(t), (a += 1), (i.innerText = a), i.classList.add("bg-primary");
    }),
        window.Echo.channel("item-requisition").listen(
            ".RequisitionRequested",
            (e) => {
                const t = s(e);
                r(t),
                    (a += 1),
                    (i.innerText = a),
                    i.classList.add("bg-primary");
            }
        ),
        window.Echo.channel("low_stock-alert").listen(".LowStockAlert", (e) => {
            const t = s(e);
            r(t), (a += 1), (i.innerText = a), i.classList.add("bg-primary");
        });
    async function w(e, t) {
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
                (i.innerText = a),
                i.classList.toggle("bg-primary", a > 0),
                (t.style.color = "gray"),
                o.childElementCount < d && fetchAndAddUnreadNotifications());
        } catch (n) {
            console.error("Error marking notification as read:", n);
        }
    }
});
