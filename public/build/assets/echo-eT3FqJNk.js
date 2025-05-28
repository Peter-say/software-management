import { P as L, E as b } from "./pusher-DxtW_XPu.js";
window.Pusher = L;
document.addEventListener("DOMContentLoaded", async function () {
    window.Echo = new b({
        broadcaster: "pusher",
        key: "adadb8e8c491818d6a8f",
        cluster: "eu",
        forceTLS: !0,
    });
    const n = document.getElementById("notificationcount"),
        r = document.querySelector("#DZ_W_Notification1 .timeline"),
        l = 5;
    let i = 0;
    const a = new Set();
    function d(e) {
        var m, f, h, u, g;
        const s =
                ((f = (((m = e.data) == null ? void 0 : m.items) ||
                    e.items ||
                    [])[0]) == null
                    ? void 0
                    : f.image) || "",
            o = ((h = e.data) == null ? void 0 : h.link) || e.link || "#",
            E = ((u = e.data) == null ? void 0 : u.title) || e.title;
        return {
            id: e.id || e.notification_id,
            imageUrl: s,
            linkUrl: o,
            message: E,
            description:
                (((g = e.data) == null ? void 0 : g.message) || "").slice(
                    0,
                    30
                ) + "...",
            createdAt: new Date(e.created_at || new Date()).toLocaleString(),
        };
    }
    function c(e) {
        if (a.has(e.id)) return;
        a.add(e.id);
        const t = document.createElement("li");
        (t.innerHTML = `
    <div class="timeline-panel">
        <p>${e.message}</p>
        <small>${e.createdAt}</small>
    </div>
`),
            t.addEventListener("click", async () => {
                await w(e.id, t);
            }),
            r.prepend(t),
            p(r);
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
                ? (r.innerHTML =
                      '<li><div class="timeline-panel"><div class="media-body text-center"><p>No notifications available</p></div></div></li>')
                : t.notification.forEach((s) => {
                      const o = d(s);
                      a.has(o.id) || (a.add(o.id), c(o));
                  });
    } catch (e) {
        console.error("Error fetching unread notifications:", e);
    }
    window.Echo.channel("kitchen-orders").listen(".OrderCreated", (e) => {
        const t = d(e);
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
                const t = d(e);
                a.has(t.id) ||
                    (a.add(t.id),
                    c(t),
                    (i += 1),
                    (n.innerText = i),
                    n.classList.add("bg-primary"));
            }
        ),
        window.Echo.channel("low_stock-alert").listen(".LowStockAlert", (e) => {
            const t = d(e);
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
                r.childElementCount < l && y());
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
                .slice(0, l - r.childElementCount)
                .forEach((s) => {
                    const o = d(s);
                    a.has(o.id) || (a.add(o.id), c(o));
                });
        } catch (e) {
            console.error("Error fetching additional unread notifications:", e);
        }
    }
});
