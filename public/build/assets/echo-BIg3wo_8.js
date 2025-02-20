import { P as k, E } from "./pusher-DxtW_XPu.js";
window.Pusher = k;
document.addEventListener("DOMContentLoaded", async function () {
    window.Echo = new E({
        broadcaster: "pusher",
        key: "adadb8e8c491818d6a8f",
        cluster: "eu",
        forceTLS: !0,
    });
    const n = document.getElementById("notificationcount"),
        d = document.querySelector("#DZ_W_Notification1 .timeline"),
        l = 5;
    let i = 0;
    const a = new Set();
    function r(e) {
        var m, h, f, u, g;
        const s =
                ((h = (((m = e.data) == null ? void 0 : m.items) ||
                    e.items ||
                    [])[0]) == null
                    ? void 0
                    : h.image) || "",
            o = ((f = e.data) == null ? void 0 : f.link) || e.link || "#",
            b = ((u = e.data) == null ? void 0 : u.title) || e.title;
        return {
            id: e.id || e.notification_id,
            imageUrl: s,
            linkUrl: o,
            message: b,
            description:
                (((g = e.data) == null ? void 0 : g.message) || "").slice(
                    0,
                    30
                ) + "...",
            createdAt: new Date(e.created_at || new Date()).toLocaleString(),
        };
    }
    function c(e) {
        if ((console.log("Adding notification:", e), a.has(e.id))) return;
        a.add(e.id);
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
            d.prepend(t),
            p(d);
    }
    function p(e) {
        const t = e.querySelectorAll("li");
        t.length > l && t[t.length - 1].remove();
    }
    try {
        const t = await (
            await fetch("/dashboard/hotel/notifications/unread")
        ).json();
        (i = t.unread_count),
            (n.innerText = i),
            n.classList.toggle("bg-primary", i > 0),
            t.notification.length === 0
                ? (d.innerHTML =
                      '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>')
                : t.notification.forEach((s) => {
                      const o = r(s);
                      a.has(o.id) || (a.add(o.id), c(o));
                  });
    } catch (e) {
        console.error("Error fetching unread notifications:", e);
    }
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (e) => {
        const t = r(e);
        a.has(t.id) ||
            (a.add(t.id),
            c(t),
            (i += 1),
            (n.innerText = i),
            n.classList.add("bg-primary"));
    }),
        window.Echo.channel("item-requisition").listen(
            ".RequisitionRequested",
            (e) => {
                const t = r(e);
                a.has(t.id) ||
                    (a.add(t.id),
                    c(t),
                    (i += 1),
                    (n.innerText = i),
                    n.classList.add("bg-primary"));
            }
        ),
        window.Echo.channel("low_stock-alert").listen(".LowStockAlert", (e) => {
            const t = r(e);
            a.has(t.id) ||
                (a.add(t.id),
                c(t),
                (i += 1),
                (n.innerText = i),
                n.classList.add("bg-primary"));
        });
    async function w(e, t) {
        try {
            const s = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            (
                await fetch(
                    `/dashboard/hotel/notifications/mark-as-read/${e}`,
                    {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": s,
                            "Content-Type": "application/json",
                        },
                    }
                )
            ).ok &&
                ((i -= 1),
                (n.innerText = i),
                n.classList.toggle("bg-primary", i > 0),
                (t.style.color = "gray"),
                d.childElementCount < l && y());
        } catch (s) {
            console.error("Error marking notification as read:", s);
        }
    }
    async function y() {
        try {
            (
                await (
                    await fetch("/dashboard/hotel/notifications/unread")
                ).json()
            ).notification
                .slice(0, l - d.childElementCount)
                .forEach((s) => {
                    const o = r(s);
                    a.has(o.id) || (a.add(o.id), c(o));
                });
        } catch (e) {
            console.error("Error fetching additional unread notifications:", e);
        }
    }
});
