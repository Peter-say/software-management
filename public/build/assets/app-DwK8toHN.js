function qe(e) {
    "@babel/helpers - typeof";
    return (
        (qe =
            typeof Symbol == "function" && typeof Symbol.iterator == "symbol"
                ? function (t) {
                      return typeof t;
                  }
                : function (t) {
                      return t &&
                          typeof Symbol == "function" &&
                          t.constructor === Symbol &&
                          t !== Symbol.prototype
                          ? "symbol"
                          : typeof t;
                  }),
        qe(e)
    );
}
function H(e, t) {
    if (!(e instanceof t))
        throw new TypeError("Cannot call a class as a function");
}
function Wo(e, t) {
    for (var r = 0; r < t.length; r++) {
        var s = t[r];
        (s.enumerable = s.enumerable || !1),
            (s.configurable = !0),
            "value" in s && (s.writable = !0),
            Object.defineProperty(e, s.key, s);
    }
}
function $(e, t, r) {
    return (
        t && Wo(e.prototype, t),
        Object.defineProperty(e, "prototype", { writable: !1 }),
        e
    );
}
function Fe() {
    return (
        (Fe =
            Object.assign ||
            function (e) {
                for (var t = 1; t < arguments.length; t++) {
                    var r = arguments[t];
                    for (var s in r)
                        Object.prototype.hasOwnProperty.call(r, s) &&
                            (e[s] = r[s]);
                }
                return e;
            }),
        Fe.apply(this, arguments)
    );
}
function K(e, t) {
    if (typeof t != "function" && t !== null)
        throw new TypeError(
            "Super expression must either be null or a function"
        );
    (e.prototype = Object.create(t && t.prototype, {
        constructor: { value: e, writable: !0, configurable: !0 },
    })),
        Object.defineProperty(e, "prototype", { writable: !1 }),
        t && Mt(e, t);
}
function st(e) {
    return (
        (st = Object.setPrototypeOf
            ? Object.getPrototypeOf
            : function (r) {
                  return r.__proto__ || Object.getPrototypeOf(r);
              }),
        st(e)
    );
}
function Mt(e, t) {
    return (
        (Mt =
            Object.setPrototypeOf ||
            function (s, a) {
                return (s.__proto__ = a), s;
            }),
        Mt(e, t)
    );
}
function Xo() {
    if (typeof Reflect > "u" || !Reflect.construct || Reflect.construct.sham)
        return !1;
    if (typeof Proxy == "function") return !0;
    try {
        return (
            Boolean.prototype.valueOf.call(
                Reflect.construct(Boolean, [], function () {})
            ),
            !0
        );
    } catch {
        return !1;
    }
}
function Ko(e) {
    if (e === void 0)
        throw new ReferenceError(
            "this hasn't been initialised - super() hasn't been called"
        );
    return e;
}
function Jo(e, t) {
    if (t && (typeof t == "object" || typeof t == "function")) return t;
    if (t !== void 0)
        throw new TypeError(
            "Derived constructors may only return object or undefined"
        );
    return Ko(e);
}
function J(e) {
    var t = Xo();
    return function () {
        var s = st(e),
            a;
        if (t) {
            var c = st(this).constructor;
            a = Reflect.construct(s, arguments, c);
        } else a = s.apply(this, arguments);
        return Jo(this, a);
    };
}
var en = (function () {
        function e() {
            H(this, e);
        }
        return (
            $(e, [
                {
                    key: "listenForWhisper",
                    value: function (r, s) {
                        return this.listen(".client-" + r, s);
                    },
                },
                {
                    key: "notification",
                    value: function (r) {
                        return this.listen(
                            ".Illuminate\\Notifications\\Events\\BroadcastNotificationCreated",
                            r
                        );
                    },
                },
                {
                    key: "stopListeningForWhisper",
                    value: function (r, s) {
                        return this.stopListening(".client-" + r, s);
                    },
                },
            ]),
            e
        );
    })(),
    vr = (function () {
        function e(t) {
            H(this, e), (this.namespace = t);
        }
        return (
            $(e, [
                {
                    key: "format",
                    value: function (r) {
                        return [".", "\\"].includes(r.charAt(0))
                            ? r.substring(1)
                            : (this.namespace && (r = this.namespace + "." + r),
                              r.replace(/\./g, "\\"));
                    },
                },
                {
                    key: "setNamespace",
                    value: function (r) {
                        this.namespace = r;
                    },
                },
            ]),
            e
        );
    })();
function Vo(e) {
    try {
        new e();
    } catch (t) {
        if (t.message.includes("is not a constructor")) return !1;
    }
    return !0;
}
var tn = (function (e) {
        K(r, e);
        var t = J(r);
        function r(s, a, c) {
            var u;
            return (
                H(this, r),
                (u = t.call(this)),
                (u.name = a),
                (u.pusher = s),
                (u.options = c),
                (u.eventFormatter = new vr(u.options.namespace)),
                u.subscribe(),
                u
            );
        }
        return (
            $(r, [
                {
                    key: "subscribe",
                    value: function () {
                        this.subscription = this.pusher.subscribe(this.name);
                    },
                },
                {
                    key: "unsubscribe",
                    value: function () {
                        this.pusher.unsubscribe(this.name);
                    },
                },
                {
                    key: "listen",
                    value: function (a, c) {
                        return this.on(this.eventFormatter.format(a), c), this;
                    },
                },
                {
                    key: "listenToAll",
                    value: function (a) {
                        var c = this;
                        return (
                            this.subscription.bind_global(function (u, f) {
                                if (!u.startsWith("pusher:")) {
                                    var d = c.options.namespace.replace(
                                            /\./g,
                                            "\\"
                                        ),
                                        y = u.startsWith(d)
                                            ? u.substring(d.length + 1)
                                            : "." + u;
                                    a(y, f);
                                }
                            }),
                            this
                        );
                    },
                },
                {
                    key: "stopListening",
                    value: function (a, c) {
                        return (
                            c
                                ? this.subscription.unbind(
                                      this.eventFormatter.format(a),
                                      c
                                  )
                                : this.subscription.unbind(
                                      this.eventFormatter.format(a)
                                  ),
                            this
                        );
                    },
                },
                {
                    key: "stopListeningToAll",
                    value: function (a) {
                        return (
                            a
                                ? this.subscription.unbind_global(a)
                                : this.subscription.unbind_global(),
                            this
                        );
                    },
                },
                {
                    key: "subscribed",
                    value: function (a) {
                        return (
                            this.on(
                                "pusher:subscription_succeeded",
                                function () {
                                    a();
                                }
                            ),
                            this
                        );
                    },
                },
                {
                    key: "error",
                    value: function (a) {
                        return (
                            this.on("pusher:subscription_error", function (c) {
                                a(c);
                            }),
                            this
                        );
                    },
                },
                {
                    key: "on",
                    value: function (a, c) {
                        return this.subscription.bind(a, c), this;
                    },
                },
            ]),
            r
        );
    })(en),
    _r = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "whisper",
                    value: function (a, c) {
                        return (
                            this.pusher.channels.channels[this.name].trigger(
                                "client-".concat(a),
                                c
                            ),
                            this
                        );
                    },
                },
            ]),
            r
        );
    })(tn),
    Go = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "whisper",
                    value: function (a, c) {
                        return (
                            this.pusher.channels.channels[this.name].trigger(
                                "client-".concat(a),
                                c
                            ),
                            this
                        );
                    },
                },
            ]),
            r
        );
    })(tn),
    Qo = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "here",
                    value: function (a) {
                        return (
                            this.on(
                                "pusher:subscription_succeeded",
                                function (c) {
                                    a(
                                        Object.keys(c.members).map(function (
                                            u
                                        ) {
                                            return c.members[u];
                                        })
                                    );
                                }
                            ),
                            this
                        );
                    },
                },
                {
                    key: "joining",
                    value: function (a) {
                        return (
                            this.on("pusher:member_added", function (c) {
                                a(c.info);
                            }),
                            this
                        );
                    },
                },
                {
                    key: "whisper",
                    value: function (a, c) {
                        return (
                            this.pusher.channels.channels[this.name].trigger(
                                "client-".concat(a),
                                c
                            ),
                            this
                        );
                    },
                },
                {
                    key: "leaving",
                    value: function (a) {
                        return (
                            this.on("pusher:member_removed", function (c) {
                                a(c.info);
                            }),
                            this
                        );
                    },
                },
            ]),
            r
        );
    })(_r),
    br = (function (e) {
        K(r, e);
        var t = J(r);
        function r(s, a, c) {
            var u;
            return (
                H(this, r),
                (u = t.call(this)),
                (u.events = {}),
                (u.listeners = {}),
                (u.name = a),
                (u.socket = s),
                (u.options = c),
                (u.eventFormatter = new vr(u.options.namespace)),
                u.subscribe(),
                u
            );
        }
        return (
            $(r, [
                {
                    key: "subscribe",
                    value: function () {
                        this.socket.emit("subscribe", {
                            channel: this.name,
                            auth: this.options.auth || {},
                        });
                    },
                },
                {
                    key: "unsubscribe",
                    value: function () {
                        this.unbind(),
                            this.socket.emit("unsubscribe", {
                                channel: this.name,
                                auth: this.options.auth || {},
                            });
                    },
                },
                {
                    key: "listen",
                    value: function (a, c) {
                        return this.on(this.eventFormatter.format(a), c), this;
                    },
                },
                {
                    key: "stopListening",
                    value: function (a, c) {
                        return (
                            this.unbindEvent(this.eventFormatter.format(a), c),
                            this
                        );
                    },
                },
                {
                    key: "subscribed",
                    value: function (a) {
                        return (
                            this.on("connect", function (c) {
                                a(c);
                            }),
                            this
                        );
                    },
                },
                {
                    key: "error",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "on",
                    value: function (a, c) {
                        var u = this;
                        return (
                            (this.listeners[a] = this.listeners[a] || []),
                            this.events[a] ||
                                ((this.events[a] = function (f, d) {
                                    u.name === f &&
                                        u.listeners[a] &&
                                        u.listeners[a].forEach(function (y) {
                                            return y(d);
                                        });
                                }),
                                this.socket.on(a, this.events[a])),
                            this.listeners[a].push(c),
                            this
                        );
                    },
                },
                {
                    key: "unbind",
                    value: function () {
                        var a = this;
                        Object.keys(this.events).forEach(function (c) {
                            a.unbindEvent(c);
                        });
                    },
                },
                {
                    key: "unbindEvent",
                    value: function (a, c) {
                        (this.listeners[a] = this.listeners[a] || []),
                            c &&
                                (this.listeners[a] = this.listeners[a].filter(
                                    function (u) {
                                        return u !== c;
                                    }
                                )),
                            (!c || this.listeners[a].length === 0) &&
                                (this.events[a] &&
                                    (this.socket.removeListener(
                                        a,
                                        this.events[a]
                                    ),
                                    delete this.events[a]),
                                delete this.listeners[a]);
                    },
                },
            ]),
            r
        );
    })(en),
    yr = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "whisper",
                    value: function (a, c) {
                        return (
                            this.socket.emit("client event", {
                                channel: this.name,
                                event: "client-".concat(a),
                                data: c,
                            }),
                            this
                        );
                    },
                },
            ]),
            r
        );
    })(br),
    Yo = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "here",
                    value: function (a) {
                        return (
                            this.on("presence:subscribed", function (c) {
                                a(
                                    c.map(function (u) {
                                        return u.user_info;
                                    })
                                );
                            }),
                            this
                        );
                    },
                },
                {
                    key: "joining",
                    value: function (a) {
                        return (
                            this.on("presence:joining", function (c) {
                                return a(c.user_info);
                            }),
                            this
                        );
                    },
                },
                {
                    key: "whisper",
                    value: function (a, c) {
                        return (
                            this.socket.emit("client event", {
                                channel: this.name,
                                event: "client-".concat(a),
                                data: c,
                            }),
                            this
                        );
                    },
                },
                {
                    key: "leaving",
                    value: function (a) {
                        return (
                            this.on("presence:leaving", function (c) {
                                return a(c.user_info);
                            }),
                            this
                        );
                    },
                },
            ]),
            r
        );
    })(yr),
    ot = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                { key: "subscribe", value: function () {} },
                { key: "unsubscribe", value: function () {} },
                {
                    key: "listen",
                    value: function (a, c) {
                        return this;
                    },
                },
                {
                    key: "listenToAll",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "stopListening",
                    value: function (a, c) {
                        return this;
                    },
                },
                {
                    key: "subscribed",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "error",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "on",
                    value: function (a, c) {
                        return this;
                    },
                },
            ]),
            r
        );
    })(en),
    mr = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "whisper",
                    value: function (a, c) {
                        return this;
                    },
                },
            ]),
            r
        );
    })(ot),
    Zo = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "whisper",
                    value: function (a, c) {
                        return this;
                    },
                },
            ]),
            r
        );
    })(ot),
    ea = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            return H(this, r), t.apply(this, arguments);
        }
        return (
            $(r, [
                {
                    key: "here",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "joining",
                    value: function (a) {
                        return this;
                    },
                },
                {
                    key: "whisper",
                    value: function (a, c) {
                        return this;
                    },
                },
                {
                    key: "leaving",
                    value: function (a) {
                        return this;
                    },
                },
            ]),
            r
        );
    })(mr),
    nn = (function () {
        function e(t) {
            H(this, e),
                (this._defaultOptions = {
                    auth: { headers: {} },
                    authEndpoint: "/broadcasting/auth",
                    userAuthentication: {
                        endpoint: "/broadcasting/user-auth",
                        headers: {},
                    },
                    broadcaster: "pusher",
                    csrfToken: null,
                    bearerToken: null,
                    host: null,
                    key: null,
                    namespace: "App.Events",
                }),
                this.setOptions(t),
                this.connect();
        }
        return (
            $(e, [
                {
                    key: "setOptions",
                    value: function (r) {
                        this.options = Fe(this._defaultOptions, r);
                        var s = this.csrfToken();
                        return (
                            s &&
                                ((this.options.auth.headers["X-CSRF-TOKEN"] =
                                    s),
                                (this.options.userAuthentication.headers[
                                    "X-CSRF-TOKEN"
                                ] = s)),
                            (s = this.options.bearerToken),
                            s &&
                                ((this.options.auth.headers.Authorization =
                                    "Bearer " + s),
                                (this.options.userAuthentication.headers.Authorization =
                                    "Bearer " + s)),
                            r
                        );
                    },
                },
                {
                    key: "csrfToken",
                    value: function () {
                        var r;
                        return typeof window < "u" &&
                            window.Laravel &&
                            window.Laravel.csrfToken
                            ? window.Laravel.csrfToken
                            : this.options.csrfToken
                            ? this.options.csrfToken
                            : typeof document < "u" &&
                              typeof document.querySelector == "function" &&
                              (r = document.querySelector(
                                  'meta[name="csrf-token"]'
                              ))
                            ? r.getAttribute("content")
                            : null;
                    },
                },
            ]),
            e
        );
    })(),
    er = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            var s;
            return (
                H(this, r), (s = t.apply(this, arguments)), (s.channels = {}), s
            );
        }
        return (
            $(r, [
                {
                    key: "connect",
                    value: function () {
                        typeof this.options.client < "u"
                            ? (this.pusher = this.options.client)
                            : this.options.Pusher
                            ? (this.pusher = new this.options.Pusher(
                                  this.options.key,
                                  this.options
                              ))
                            : (this.pusher = new Pusher(
                                  this.options.key,
                                  this.options
                              ));
                    },
                },
                {
                    key: "signin",
                    value: function () {
                        this.pusher.signin();
                    },
                },
                {
                    key: "listen",
                    value: function (a, c, u) {
                        return this.channel(a).listen(c, u);
                    },
                },
                {
                    key: "channel",
                    value: function (a) {
                        return (
                            this.channels[a] ||
                                (this.channels[a] = new tn(
                                    this.pusher,
                                    a,
                                    this.options
                                )),
                            this.channels[a]
                        );
                    },
                },
                {
                    key: "privateChannel",
                    value: function (a) {
                        return (
                            this.channels["private-" + a] ||
                                (this.channels["private-" + a] = new _r(
                                    this.pusher,
                                    "private-" + a,
                                    this.options
                                )),
                            this.channels["private-" + a]
                        );
                    },
                },
                {
                    key: "encryptedPrivateChannel",
                    value: function (a) {
                        return (
                            this.channels["private-encrypted-" + a] ||
                                (this.channels["private-encrypted-" + a] =
                                    new Go(
                                        this.pusher,
                                        "private-encrypted-" + a,
                                        this.options
                                    )),
                            this.channels["private-encrypted-" + a]
                        );
                    },
                },
                {
                    key: "presenceChannel",
                    value: function (a) {
                        return (
                            this.channels["presence-" + a] ||
                                (this.channels["presence-" + a] = new Qo(
                                    this.pusher,
                                    "presence-" + a,
                                    this.options
                                )),
                            this.channels["presence-" + a]
                        );
                    },
                },
                {
                    key: "leave",
                    value: function (a) {
                        var c = this,
                            u = [
                                a,
                                "private-" + a,
                                "private-encrypted-" + a,
                                "presence-" + a,
                            ];
                        u.forEach(function (f, d) {
                            c.leaveChannel(f);
                        });
                    },
                },
                {
                    key: "leaveChannel",
                    value: function (a) {
                        this.channels[a] &&
                            (this.channels[a].unsubscribe(),
                            delete this.channels[a]);
                    },
                },
                {
                    key: "socketId",
                    value: function () {
                        return this.pusher.connection.socket_id;
                    },
                },
                {
                    key: "disconnect",
                    value: function () {
                        this.pusher.disconnect();
                    },
                },
            ]),
            r
        );
    })(nn),
    tr = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            var s;
            return (
                H(this, r), (s = t.apply(this, arguments)), (s.channels = {}), s
            );
        }
        return (
            $(r, [
                {
                    key: "connect",
                    value: function () {
                        var a = this,
                            c = this.getSocketIO();
                        return (
                            (this.socket = c(this.options.host, this.options)),
                            this.socket.on("reconnect", function () {
                                Object.values(a.channels).forEach(function (u) {
                                    u.subscribe();
                                });
                            }),
                            this.socket
                        );
                    },
                },
                {
                    key: "getSocketIO",
                    value: function () {
                        if (typeof this.options.client < "u")
                            return this.options.client;
                        if (typeof io < "u") return io;
                        throw new Error(
                            "Socket.io client not found. Should be globally available or passed via options.client"
                        );
                    },
                },
                {
                    key: "listen",
                    value: function (a, c, u) {
                        return this.channel(a).listen(c, u);
                    },
                },
                {
                    key: "channel",
                    value: function (a) {
                        return (
                            this.channels[a] ||
                                (this.channels[a] = new br(
                                    this.socket,
                                    a,
                                    this.options
                                )),
                            this.channels[a]
                        );
                    },
                },
                {
                    key: "privateChannel",
                    value: function (a) {
                        return (
                            this.channels["private-" + a] ||
                                (this.channels["private-" + a] = new yr(
                                    this.socket,
                                    "private-" + a,
                                    this.options
                                )),
                            this.channels["private-" + a]
                        );
                    },
                },
                {
                    key: "presenceChannel",
                    value: function (a) {
                        return (
                            this.channels["presence-" + a] ||
                                (this.channels["presence-" + a] = new Yo(
                                    this.socket,
                                    "presence-" + a,
                                    this.options
                                )),
                            this.channels["presence-" + a]
                        );
                    },
                },
                {
                    key: "leave",
                    value: function (a) {
                        var c = this,
                            u = [a, "private-" + a, "presence-" + a];
                        u.forEach(function (f) {
                            c.leaveChannel(f);
                        });
                    },
                },
                {
                    key: "leaveChannel",
                    value: function (a) {
                        this.channels[a] &&
                            (this.channels[a].unsubscribe(),
                            delete this.channels[a]);
                    },
                },
                {
                    key: "socketId",
                    value: function () {
                        return this.socket.id;
                    },
                },
                {
                    key: "disconnect",
                    value: function () {
                        this.socket.disconnect();
                    },
                },
            ]),
            r
        );
    })(nn),
    ta = (function (e) {
        K(r, e);
        var t = J(r);
        function r() {
            var s;
            return (
                H(this, r), (s = t.apply(this, arguments)), (s.channels = {}), s
            );
        }
        return (
            $(r, [
                { key: "connect", value: function () {} },
                {
                    key: "listen",
                    value: function (a, c, u) {
                        return new ot();
                    },
                },
                {
                    key: "channel",
                    value: function (a) {
                        return new ot();
                    },
                },
                {
                    key: "privateChannel",
                    value: function (a) {
                        return new mr();
                    },
                },
                {
                    key: "encryptedPrivateChannel",
                    value: function (a) {
                        return new Zo();
                    },
                },
                {
                    key: "presenceChannel",
                    value: function (a) {
                        return new ea();
                    },
                },
                { key: "leave", value: function (a) {} },
                { key: "leaveChannel", value: function (a) {} },
                {
                    key: "socketId",
                    value: function () {
                        return "fake-socket-id";
                    },
                },
                { key: "disconnect", value: function () {} },
            ]),
            r
        );
    })(nn),
    na = (function () {
        function e(t) {
            H(this, e),
                (this.options = t),
                this.connect(),
                this.options.withoutInterceptors || this.registerInterceptors();
        }
        return (
            $(e, [
                {
                    key: "channel",
                    value: function (r) {
                        return this.connector.channel(r);
                    },
                },
                {
                    key: "connect",
                    value: function () {
                        if (this.options.broadcaster == "reverb")
                            this.connector = new er(
                                Fe(Fe({}, this.options), { cluster: "" })
                            );
                        else if (this.options.broadcaster == "pusher")
                            this.connector = new er(this.options);
                        else if (this.options.broadcaster == "socket.io")
                            this.connector = new tr(this.options);
                        else if (this.options.broadcaster == "null")
                            this.connector = new ta(this.options);
                        else if (
                            typeof this.options.broadcaster == "function" &&
                            Vo(this.options.broadcaster)
                        )
                            this.connector = new this.options.broadcaster(
                                this.options
                            );
                        else
                            throw new Error(
                                "Broadcaster "
                                    .concat(qe(this.options.broadcaster), " ")
                                    .concat(
                                        this.options.broadcaster,
                                        " is not supported."
                                    )
                            );
                    },
                },
                {
                    key: "disconnect",
                    value: function () {
                        this.connector.disconnect();
                    },
                },
                {
                    key: "join",
                    value: function (r) {
                        return this.connector.presenceChannel(r);
                    },
                },
                {
                    key: "leave",
                    value: function (r) {
                        this.connector.leave(r);
                    },
                },
                {
                    key: "leaveChannel",
                    value: function (r) {
                        this.connector.leaveChannel(r);
                    },
                },
                {
                    key: "leaveAllChannels",
                    value: function () {
                        for (var r in this.connector.channels)
                            this.leaveChannel(r);
                    },
                },
                {
                    key: "listen",
                    value: function (r, s, a) {
                        return this.connector.listen(r, s, a);
                    },
                },
                {
                    key: "private",
                    value: function (r) {
                        return this.connector.privateChannel(r);
                    },
                },
                {
                    key: "encryptedPrivate",
                    value: function (r) {
                        if (this.connector instanceof tr)
                            throw new Error(
                                "Broadcaster "
                                    .concat(qe(this.options.broadcaster), " ")
                                    .concat(
                                        this.options.broadcaster,
                                        " does not support encrypted private channels."
                                    )
                            );
                        return this.connector.encryptedPrivateChannel(r);
                    },
                },
                {
                    key: "socketId",
                    value: function () {
                        return this.connector.socketId();
                    },
                },
                {
                    key: "registerInterceptors",
                    value: function () {
                        typeof Vue == "function" &&
                            Vue.http &&
                            this.registerVueRequestInterceptor(),
                            typeof axios == "function" &&
                                this.registerAxiosRequestInterceptor(),
                            typeof jQuery == "function" &&
                                this.registerjQueryAjaxSetup(),
                            (typeof Turbo > "u" ? "undefined" : qe(Turbo)) ===
                                "object" &&
                                this.registerTurboRequestInterceptor();
                    },
                },
                {
                    key: "registerVueRequestInterceptor",
                    value: function () {
                        var r = this;
                        Vue.http.interceptors.push(function (s, a) {
                            r.socketId() &&
                                s.headers.set("X-Socket-ID", r.socketId()),
                                a();
                        });
                    },
                },
                {
                    key: "registerAxiosRequestInterceptor",
                    value: function () {
                        var r = this;
                        axios.interceptors.request.use(function (s) {
                            return (
                                r.socketId() &&
                                    (s.headers["X-Socket-Id"] = r.socketId()),
                                s
                            );
                        });
                    },
                },
                {
                    key: "registerjQueryAjaxSetup",
                    value: function () {
                        var r = this;
                        typeof jQuery.ajax < "u" &&
                            jQuery.ajaxPrefilter(function (s, a, c) {
                                r.socketId() &&
                                    c.setRequestHeader(
                                        "X-Socket-Id",
                                        r.socketId()
                                    );
                            });
                    },
                },
                {
                    key: "registerTurboRequestInterceptor",
                    value: function () {
                        var r = this;
                        document.addEventListener(
                            "turbo:before-fetch-request",
                            function (s) {
                                s.detail.fetchOptions.headers["X-Socket-Id"] =
                                    r.socketId();
                            }
                        );
                    },
                },
            ]),
            e
        );
    })();
function ra(e) {
    return e &&
        e.__esModule &&
        Object.prototype.hasOwnProperty.call(e, "default")
        ? e.default
        : e;
}
var wr = { exports: {} };
/*!
 * Pusher JavaScript Library v8.4.0-rc2
 * https://pusher.com/
 *
 * Copyright 2020, Pusher
 * Released under the MIT licence.
 */ (function (e, t) {
    (function (s, a) {
        e.exports = a();
    })(window, function () {
        return (function (r) {
            var s = {};
            function a(c) {
                if (s[c]) return s[c].exports;
                var u = (s[c] = { i: c, l: !1, exports: {} });
                return (
                    r[c].call(u.exports, u, u.exports, a), (u.l = !0), u.exports
                );
            }
            return (
                (a.m = r),
                (a.c = s),
                (a.d = function (c, u, f) {
                    a.o(c, u) ||
                        Object.defineProperty(c, u, { enumerable: !0, get: f });
                }),
                (a.r = function (c) {
                    typeof Symbol < "u" &&
                        Symbol.toStringTag &&
                        Object.defineProperty(c, Symbol.toStringTag, {
                            value: "Module",
                        }),
                        Object.defineProperty(c, "__esModule", { value: !0 });
                }),
                (a.t = function (c, u) {
                    if (
                        (u & 1 && (c = a(c)),
                        u & 8 ||
                            (u & 4 &&
                                typeof c == "object" &&
                                c &&
                                c.__esModule))
                    )
                        return c;
                    var f = Object.create(null);
                    if (
                        (a.r(f),
                        Object.defineProperty(f, "default", {
                            enumerable: !0,
                            value: c,
                        }),
                        u & 2 && typeof c != "string")
                    )
                        for (var d in c)
                            a.d(
                                f,
                                d,
                                function (y) {
                                    return c[y];
                                }.bind(null, d)
                            );
                    return f;
                }),
                (a.n = function (c) {
                    var u =
                        c && c.__esModule
                            ? function () {
                                  return c.default;
                              }
                            : function () {
                                  return c;
                              };
                    return a.d(u, "a", u), u;
                }),
                (a.o = function (c, u) {
                    return Object.prototype.hasOwnProperty.call(c, u);
                }),
                (a.p = ""),
                a((a.s = 2))
            );
        })([
            function (r, s, a) {
                var c =
                    (this && this.__extends) ||
                    (function () {
                        var k = function (p, v) {
                            return (
                                (k =
                                    Object.setPrototypeOf ||
                                    ({ __proto__: [] } instanceof Array &&
                                        function (x, P) {
                                            x.__proto__ = P;
                                        }) ||
                                    function (x, P) {
                                        for (var I in P)
                                            P.hasOwnProperty(I) &&
                                                (x[I] = P[I]);
                                    }),
                                k(p, v)
                            );
                        };
                        return function (p, v) {
                            k(p, v);
                            function x() {
                                this.constructor = p;
                            }
                            p.prototype =
                                v === null
                                    ? Object.create(v)
                                    : ((x.prototype = v.prototype), new x());
                        };
                    })();
                Object.defineProperty(s, "__esModule", { value: !0 });
                var u = 256,
                    f = (function () {
                        function k(p) {
                            p === void 0 && (p = "="),
                                (this._paddingCharacter = p);
                        }
                        return (
                            (k.prototype.encodedLength = function (p) {
                                return this._paddingCharacter
                                    ? (((p + 2) / 3) * 4) | 0
                                    : ((p * 8 + 5) / 6) | 0;
                            }),
                            (k.prototype.encode = function (p) {
                                for (
                                    var v = "", x = 0;
                                    x < p.length - 2;
                                    x += 3
                                ) {
                                    var P =
                                        (p[x] << 16) |
                                        (p[x + 1] << 8) |
                                        p[x + 2];
                                    (v += this._encodeByte(
                                        (P >>> (3 * 6)) & 63
                                    )),
                                        (v += this._encodeByte(
                                            (P >>> (2 * 6)) & 63
                                        )),
                                        (v += this._encodeByte(
                                            (P >>> (1 * 6)) & 63
                                        )),
                                        (v += this._encodeByte(
                                            (P >>> (0 * 6)) & 63
                                        ));
                                }
                                var I = p.length - x;
                                if (I > 0) {
                                    var P =
                                        (p[x] << 16) |
                                        (I === 2 ? p[x + 1] << 8 : 0);
                                    (v += this._encodeByte(
                                        (P >>> (3 * 6)) & 63
                                    )),
                                        (v += this._encodeByte(
                                            (P >>> (2 * 6)) & 63
                                        )),
                                        I === 2
                                            ? (v += this._encodeByte(
                                                  (P >>> (1 * 6)) & 63
                                              ))
                                            : (v +=
                                                  this._paddingCharacter || ""),
                                        (v += this._paddingCharacter || "");
                                }
                                return v;
                            }),
                            (k.prototype.maxDecodedLength = function (p) {
                                return this._paddingCharacter
                                    ? ((p / 4) * 3) | 0
                                    : ((p * 6 + 7) / 8) | 0;
                            }),
                            (k.prototype.decodedLength = function (p) {
                                return this.maxDecodedLength(
                                    p.length - this._getPaddingLength(p)
                                );
                            }),
                            (k.prototype.decode = function (p) {
                                if (p.length === 0) return new Uint8Array(0);
                                for (
                                    var v = this._getPaddingLength(p),
                                        x = p.length - v,
                                        P = new Uint8Array(
                                            this.maxDecodedLength(x)
                                        ),
                                        I = 0,
                                        j = 0,
                                        F = 0,
                                        V = 0,
                                        W = 0,
                                        Q = 0,
                                        ee = 0;
                                    j < x - 4;
                                    j += 4
                                )
                                    (V = this._decodeChar(p.charCodeAt(j + 0))),
                                        (W = this._decodeChar(
                                            p.charCodeAt(j + 1)
                                        )),
                                        (Q = this._decodeChar(
                                            p.charCodeAt(j + 2)
                                        )),
                                        (ee = this._decodeChar(
                                            p.charCodeAt(j + 3)
                                        )),
                                        (P[I++] = (V << 2) | (W >>> 4)),
                                        (P[I++] = (W << 4) | (Q >>> 2)),
                                        (P[I++] = (Q << 6) | ee),
                                        (F |= V & u),
                                        (F |= W & u),
                                        (F |= Q & u),
                                        (F |= ee & u);
                                if (
                                    (j < x - 1 &&
                                        ((V = this._decodeChar(
                                            p.charCodeAt(j)
                                        )),
                                        (W = this._decodeChar(
                                            p.charCodeAt(j + 1)
                                        )),
                                        (P[I++] = (V << 2) | (W >>> 4)),
                                        (F |= V & u),
                                        (F |= W & u)),
                                    j < x - 2 &&
                                        ((Q = this._decodeChar(
                                            p.charCodeAt(j + 2)
                                        )),
                                        (P[I++] = (W << 4) | (Q >>> 2)),
                                        (F |= Q & u)),
                                    j < x - 3 &&
                                        ((ee = this._decodeChar(
                                            p.charCodeAt(j + 3)
                                        )),
                                        (P[I++] = (Q << 6) | ee),
                                        (F |= ee & u)),
                                    F !== 0)
                                )
                                    throw new Error(
                                        "Base64Coder: incorrect characters for decoding"
                                    );
                                return P;
                            }),
                            (k.prototype._encodeByte = function (p) {
                                var v = p;
                                return (
                                    (v += 65),
                                    (v += ((25 - p) >>> 8) & 6),
                                    (v += ((51 - p) >>> 8) & -75),
                                    (v += ((61 - p) >>> 8) & -15),
                                    (v += ((62 - p) >>> 8) & 3),
                                    String.fromCharCode(v)
                                );
                            }),
                            (k.prototype._decodeChar = function (p) {
                                var v = u;
                                return (
                                    (v +=
                                        (((42 - p) & (p - 44)) >>> 8) &
                                        (-u + p - 43 + 62)),
                                    (v +=
                                        (((46 - p) & (p - 48)) >>> 8) &
                                        (-u + p - 47 + 63)),
                                    (v +=
                                        (((47 - p) & (p - 58)) >>> 8) &
                                        (-u + p - 48 + 52)),
                                    (v +=
                                        (((64 - p) & (p - 91)) >>> 8) &
                                        (-u + p - 65 + 0)),
                                    (v +=
                                        (((96 - p) & (p - 123)) >>> 8) &
                                        (-u + p - 97 + 26)),
                                    v
                                );
                            }),
                            (k.prototype._getPaddingLength = function (p) {
                                var v = 0;
                                if (this._paddingCharacter) {
                                    for (
                                        var x = p.length - 1;
                                        x >= 0 &&
                                        p[x] === this._paddingCharacter;
                                        x--
                                    )
                                        v++;
                                    if (p.length < 4 || v > 2)
                                        throw new Error(
                                            "Base64Coder: incorrect padding"
                                        );
                                }
                                return v;
                            }),
                            k
                        );
                    })();
                s.Coder = f;
                var d = new f();
                function y(k) {
                    return d.encode(k);
                }
                s.encode = y;
                function _(k) {
                    return d.decode(k);
                }
                s.decode = _;
                var w = (function (k) {
                    c(p, k);
                    function p() {
                        return (k !== null && k.apply(this, arguments)) || this;
                    }
                    return (
                        (p.prototype._encodeByte = function (v) {
                            var x = v;
                            return (
                                (x += 65),
                                (x += ((25 - v) >>> 8) & 6),
                                (x += ((51 - v) >>> 8) & -75),
                                (x += ((61 - v) >>> 8) & -13),
                                (x += ((62 - v) >>> 8) & 49),
                                String.fromCharCode(x)
                            );
                        }),
                        (p.prototype._decodeChar = function (v) {
                            var x = u;
                            return (
                                (x +=
                                    (((44 - v) & (v - 46)) >>> 8) &
                                    (-u + v - 45 + 62)),
                                (x +=
                                    (((94 - v) & (v - 96)) >>> 8) &
                                    (-u + v - 95 + 63)),
                                (x +=
                                    (((47 - v) & (v - 58)) >>> 8) &
                                    (-u + v - 48 + 52)),
                                (x +=
                                    (((64 - v) & (v - 91)) >>> 8) &
                                    (-u + v - 65 + 0)),
                                (x +=
                                    (((96 - v) & (v - 123)) >>> 8) &
                                    (-u + v - 97 + 26)),
                                x
                            );
                        }),
                        p
                    );
                })(f);
                s.URLSafeCoder = w;
                var m = new w();
                function C(k) {
                    return m.encode(k);
                }
                s.encodeURLSafe = C;
                function A(k) {
                    return m.decode(k);
                }
                (s.decodeURLSafe = A),
                    (s.encodedLength = function (k) {
                        return d.encodedLength(k);
                    }),
                    (s.maxDecodedLength = function (k) {
                        return d.maxDecodedLength(k);
                    }),
                    (s.decodedLength = function (k) {
                        return d.decodedLength(k);
                    });
            },
            function (r, s, a) {
                Object.defineProperty(s, "__esModule", { value: !0 });
                var c = "utf8: invalid string",
                    u = "utf8: invalid source encoding";
                function f(_) {
                    for (
                        var w = new Uint8Array(d(_)), m = 0, C = 0;
                        C < _.length;
                        C++
                    ) {
                        var A = _.charCodeAt(C);
                        A < 128
                            ? (w[m++] = A)
                            : A < 2048
                            ? ((w[m++] = 192 | (A >> 6)),
                              (w[m++] = 128 | (A & 63)))
                            : A < 55296
                            ? ((w[m++] = 224 | (A >> 12)),
                              (w[m++] = 128 | ((A >> 6) & 63)),
                              (w[m++] = 128 | (A & 63)))
                            : (C++,
                              (A = (A & 1023) << 10),
                              (A |= _.charCodeAt(C) & 1023),
                              (A += 65536),
                              (w[m++] = 240 | (A >> 18)),
                              (w[m++] = 128 | ((A >> 12) & 63)),
                              (w[m++] = 128 | ((A >> 6) & 63)),
                              (w[m++] = 128 | (A & 63)));
                    }
                    return w;
                }
                s.encode = f;
                function d(_) {
                    for (var w = 0, m = 0; m < _.length; m++) {
                        var C = _.charCodeAt(m);
                        if (C < 128) w += 1;
                        else if (C < 2048) w += 2;
                        else if (C < 55296) w += 3;
                        else if (C <= 57343) {
                            if (m >= _.length - 1) throw new Error(c);
                            m++, (w += 4);
                        } else throw new Error(c);
                    }
                    return w;
                }
                s.encodedLength = d;
                function y(_) {
                    for (var w = [], m = 0; m < _.length; m++) {
                        var C = _[m];
                        if (C & 128) {
                            var A = void 0;
                            if (C < 224) {
                                if (m >= _.length) throw new Error(u);
                                var k = _[++m];
                                if ((k & 192) !== 128) throw new Error(u);
                                (C = ((C & 31) << 6) | (k & 63)), (A = 128);
                            } else if (C < 240) {
                                if (m >= _.length - 1) throw new Error(u);
                                var k = _[++m],
                                    p = _[++m];
                                if ((k & 192) !== 128 || (p & 192) !== 128)
                                    throw new Error(u);
                                (C =
                                    ((C & 15) << 12) |
                                    ((k & 63) << 6) |
                                    (p & 63)),
                                    (A = 2048);
                            } else if (C < 248) {
                                if (m >= _.length - 2) throw new Error(u);
                                var k = _[++m],
                                    p = _[++m],
                                    v = _[++m];
                                if (
                                    (k & 192) !== 128 ||
                                    (p & 192) !== 128 ||
                                    (v & 192) !== 128
                                )
                                    throw new Error(u);
                                (C =
                                    ((C & 15) << 18) |
                                    ((k & 63) << 12) |
                                    ((p & 63) << 6) |
                                    (v & 63)),
                                    (A = 65536);
                            } else throw new Error(u);
                            if (C < A || (C >= 55296 && C <= 57343))
                                throw new Error(u);
                            if (C >= 65536) {
                                if (C > 1114111) throw new Error(u);
                                (C -= 65536),
                                    w.push(
                                        String.fromCharCode(55296 | (C >> 10))
                                    ),
                                    (C = 56320 | (C & 1023));
                            }
                        }
                        w.push(String.fromCharCode(C));
                    }
                    return w.join("");
                }
                s.decode = y;
            },
            function (r, s, a) {
                r.exports = a(3).default;
            },
            function (r, s, a) {
                a.r(s);
                class c {
                    constructor(n, i) {
                        (this.lastId = 0), (this.prefix = n), (this.name = i);
                    }
                    create(n) {
                        this.lastId++;
                        var i = this.lastId,
                            l = this.prefix + i,
                            h = this.name + "[" + i + "]",
                            g = !1,
                            b = function () {
                                g || (n.apply(null, arguments), (g = !0));
                            };
                        return (
                            (this[i] = b),
                            { number: i, id: l, name: h, callback: b }
                        );
                    }
                    remove(n) {
                        delete this[n.number];
                    }
                }
                var u = new c("_pusher_script_", "Pusher.ScriptReceivers"),
                    f = {
                        VERSION: "8.4.0-rc2",
                        PROTOCOL: 7,
                        wsPort: 80,
                        wssPort: 443,
                        wsPath: "",
                        httpHost: "sockjs.pusher.com",
                        httpPort: 80,
                        httpsPort: 443,
                        httpPath: "/pusher",
                        stats_host: "stats.pusher.com",
                        authEndpoint: "/pusher/auth",
                        authTransport: "ajax",
                        activityTimeout: 12e4,
                        pongTimeout: 3e4,
                        unavailableTimeout: 1e4,
                        userAuthentication: {
                            endpoint: "/pusher/user-auth",
                            transport: "ajax",
                        },
                        channelAuthorization: {
                            endpoint: "/pusher/auth",
                            transport: "ajax",
                        },
                        cdn_http: "http://js.pusher.com",
                        cdn_https: "https://js.pusher.com",
                        dependency_suffix: "",
                    },
                    d = f;
                class y {
                    constructor(n) {
                        (this.options = n),
                            (this.receivers = n.receivers || u),
                            (this.loading = {});
                    }
                    load(n, i, l) {
                        var h = this;
                        if (h.loading[n] && h.loading[n].length > 0)
                            h.loading[n].push(l);
                        else {
                            h.loading[n] = [l];
                            var g = E.createScriptRequest(h.getPath(n, i)),
                                b = h.receivers.create(function (S) {
                                    if ((h.receivers.remove(b), h.loading[n])) {
                                        var T = h.loading[n];
                                        delete h.loading[n];
                                        for (
                                            var O = function (D) {
                                                    D || g.cleanup();
                                                },
                                                R = 0;
                                            R < T.length;
                                            R++
                                        )
                                            T[R](S, O);
                                    }
                                });
                            g.send(b);
                        }
                    }
                    getRoot(n) {
                        var i,
                            l = E.getDocument().location.protocol;
                        return (
                            (n && n.useTLS) || l === "https:"
                                ? (i = this.options.cdn_https)
                                : (i = this.options.cdn_http),
                            i.replace(/\/*$/, "") + "/" + this.options.version
                        );
                    }
                    getPath(n, i) {
                        return (
                            this.getRoot(i) +
                            "/" +
                            n +
                            this.options.suffix +
                            ".js"
                        );
                    }
                }
                var _ = new c(
                        "_pusher_dependencies",
                        "Pusher.DependenciesReceivers"
                    ),
                    w = new y({
                        cdn_http: d.cdn_http,
                        cdn_https: d.cdn_https,
                        version: d.VERSION,
                        suffix: d.dependency_suffix,
                        receivers: _,
                    });
                const m = {
                    baseUrl: "https://pusher.com",
                    urls: {
                        authenticationEndpoint: {
                            path: "/docs/channels/server_api/authenticating_users",
                        },
                        authorizationEndpoint: {
                            path: "/docs/channels/server_api/authorizing-users/",
                        },
                        javascriptQuickStart: {
                            path: "/docs/javascript_quick_start",
                        },
                        triggeringClientEvents: {
                            path: "/docs/client_api_guide/client_events#trigger-events",
                        },
                        encryptedChannelSupport: {
                            fullUrl:
                                "https://github.com/pusher/pusher-js/tree/cc491015371a4bde5743d1c87a0fbac0feb53195#encrypted-channel-support",
                        },
                    },
                };
                var A = {
                        buildLogSuffix: function (o) {
                            const n = "See:",
                                i = m.urls[o];
                            if (!i) return "";
                            let l;
                            return (
                                i.fullUrl
                                    ? (l = i.fullUrl)
                                    : i.path && (l = m.baseUrl + i.path),
                                l ? `${n} ${l}` : ""
                            );
                        },
                    },
                    k;
                (function (o) {
                    (o.UserAuthentication = "user-authentication"),
                        (o.ChannelAuthorization = "channel-authorization");
                })(k || (k = {}));
                class p extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class v extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class x extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class P extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class I extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class j extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class F extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class V extends Error {
                    constructor(n) {
                        super(n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                class W extends Error {
                    constructor(n, i) {
                        super(i),
                            (this.status = n),
                            Object.setPrototypeOf(this, new.target.prototype);
                    }
                }
                var ee = function (o, n, i, l, h) {
                    const g = E.createXHR();
                    g.open("POST", i.endpoint, !0),
                        g.setRequestHeader(
                            "Content-Type",
                            "application/x-www-form-urlencoded"
                        );
                    for (var b in i.headers)
                        g.setRequestHeader(b, i.headers[b]);
                    if (i.headersProvider != null) {
                        let S = i.headersProvider();
                        for (var b in S) g.setRequestHeader(b, S[b]);
                    }
                    return (
                        (g.onreadystatechange = function () {
                            if (g.readyState === 4)
                                if (g.status === 200) {
                                    let S,
                                        T = !1;
                                    try {
                                        (S = JSON.parse(g.responseText)),
                                            (T = !0);
                                    } catch {
                                        h(
                                            new W(
                                                200,
                                                `JSON returned from ${l.toString()} endpoint was invalid, yet status code was 200. Data was: ${
                                                    g.responseText
                                                }`
                                            ),
                                            null
                                        );
                                    }
                                    T && h(null, S);
                                } else {
                                    let S = "";
                                    switch (l) {
                                        case k.UserAuthentication:
                                            S = A.buildLogSuffix(
                                                "authenticationEndpoint"
                                            );
                                            break;
                                        case k.ChannelAuthorization:
                                            S = `Clients must be authorized to join private or presence channels. ${A.buildLogSuffix(
                                                "authorizationEndpoint"
                                            )}`;
                                            break;
                                    }
                                    h(
                                        new W(
                                            g.status,
                                            `Unable to retrieve auth string from ${l.toString()} endpoint - received status: ${
                                                g.status
                                            } from ${i.endpoint}. ${S}`
                                        ),
                                        null
                                    );
                                }
                        }),
                        g.send(n),
                        g
                    );
                };
                function ji(o) {
                    return qi(Mi(o));
                }
                var Oe = String.fromCharCode,
                    Xe =
                        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
                    Ni = function (o) {
                        var n = o.charCodeAt(0);
                        return n < 128
                            ? o
                            : n < 2048
                            ? Oe(192 | (n >>> 6)) + Oe(128 | (n & 63))
                            : Oe(224 | ((n >>> 12) & 15)) +
                              Oe(128 | ((n >>> 6) & 63)) +
                              Oe(128 | (n & 63));
                    },
                    Mi = function (o) {
                        return o.replace(/[^\x00-\x7F]/g, Ni);
                    },
                    Di = function (o) {
                        var n = [0, 2, 1][o.length % 3],
                            i =
                                (o.charCodeAt(0) << 16) |
                                ((o.length > 1 ? o.charCodeAt(1) : 0) << 8) |
                                (o.length > 2 ? o.charCodeAt(2) : 0),
                            l = [
                                Xe.charAt(i >>> 18),
                                Xe.charAt((i >>> 12) & 63),
                                n >= 2 ? "=" : Xe.charAt((i >>> 6) & 63),
                                n >= 1 ? "=" : Xe.charAt(i & 63),
                            ];
                        return l.join("");
                    },
                    qi =
                        window.btoa ||
                        function (o) {
                            return o.replace(/[\s\S]{1,3}/g, Di);
                        };
                class Hi {
                    constructor(n, i, l, h) {
                        (this.clear = i),
                            (this.timer = n(() => {
                                this.timer && (this.timer = h(this.timer));
                            }, l));
                    }
                    isRunning() {
                        return this.timer !== null;
                    }
                    ensureAborted() {
                        this.timer &&
                            (this.clear(this.timer), (this.timer = null));
                    }
                }
                var kn = Hi;
                function $i(o) {
                    window.clearTimeout(o);
                }
                function Fi(o) {
                    window.clearInterval(o);
                }
                class le extends kn {
                    constructor(n, i) {
                        super(setTimeout, $i, n, function (l) {
                            return i(), null;
                        });
                    }
                }
                class Ui extends kn {
                    constructor(n, i) {
                        super(setInterval, Fi, n, function (l) {
                            return i(), l;
                        });
                    }
                }
                var zi = {
                        now() {
                            return Date.now ? Date.now() : new Date().valueOf();
                        },
                        defer(o) {
                            return new le(0, o);
                        },
                        method(o, ...n) {
                            var i = Array.prototype.slice.call(arguments, 1);
                            return function (l) {
                                return l[o].apply(l, i.concat(arguments));
                            };
                        },
                    },
                    z = zi;
                function X(o, ...n) {
                    for (var i = 0; i < n.length; i++) {
                        var l = n[i];
                        for (var h in l)
                            l[h] &&
                            l[h].constructor &&
                            l[h].constructor === Object
                                ? (o[h] = X(o[h] || {}, l[h]))
                                : (o[h] = l[h]);
                    }
                    return o;
                }
                function Bi() {
                    for (var o = ["Pusher"], n = 0; n < arguments.length; n++)
                        typeof arguments[n] == "string"
                            ? o.push(arguments[n])
                            : o.push(Ke(arguments[n]));
                    return o.join(" : ");
                }
                function Tn(o, n) {
                    var i = Array.prototype.indexOf;
                    if (o === null) return -1;
                    if (i && o.indexOf === i) return o.indexOf(n);
                    for (var l = 0, h = o.length; l < h; l++)
                        if (o[l] === n) return l;
                    return -1;
                }
                function ne(o, n) {
                    for (var i in o)
                        Object.prototype.hasOwnProperty.call(o, i) &&
                            n(o[i], i, o);
                }
                function En(o) {
                    var n = [];
                    return (
                        ne(o, function (i, l) {
                            n.push(l);
                        }),
                        n
                    );
                }
                function Wi(o) {
                    var n = [];
                    return (
                        ne(o, function (i) {
                            n.push(i);
                        }),
                        n
                    );
                }
                function Ie(o, n, i) {
                    for (var l = 0; l < o.length; l++)
                        n.call(i || window, o[l], l, o);
                }
                function Pn(o, n) {
                    for (var i = [], l = 0; l < o.length; l++)
                        i.push(n(o[l], l, o, i));
                    return i;
                }
                function Xi(o, n) {
                    var i = {};
                    return (
                        ne(o, function (l, h) {
                            i[h] = n(l);
                        }),
                        i
                    );
                }
                function An(o, n) {
                    n =
                        n ||
                        function (h) {
                            return !!h;
                        };
                    for (var i = [], l = 0; l < o.length; l++)
                        n(o[l], l, o, i) && i.push(o[l]);
                    return i;
                }
                function On(o, n) {
                    var i = {};
                    return (
                        ne(o, function (l, h) {
                            ((n && n(l, h, o, i)) || l) && (i[h] = l);
                        }),
                        i
                    );
                }
                function Ki(o) {
                    var n = [];
                    return (
                        ne(o, function (i, l) {
                            n.push([l, i]);
                        }),
                        n
                    );
                }
                function In(o, n) {
                    for (var i = 0; i < o.length; i++)
                        if (n(o[i], i, o)) return !0;
                    return !1;
                }
                function Ji(o, n) {
                    for (var i = 0; i < o.length; i++)
                        if (!n(o[i], i, o)) return !1;
                    return !0;
                }
                function Vi(o) {
                    return Xi(o, function (n) {
                        return (
                            typeof n == "object" && (n = Ke(n)),
                            encodeURIComponent(ji(n.toString()))
                        );
                    });
                }
                function Gi(o) {
                    var n = On(o, function (l) {
                            return l !== void 0;
                        }),
                        i = Pn(Ki(Vi(n)), z.method("join", "=")).join("&");
                    return i;
                }
                function Qi(o) {
                    var n = [],
                        i = [];
                    return (function l(h, g) {
                        var b, S, T;
                        switch (typeof h) {
                            case "object":
                                if (!h) return null;
                                for (b = 0; b < n.length; b += 1)
                                    if (n[b] === h) return { $ref: i[b] };
                                if (
                                    (n.push(h),
                                    i.push(g),
                                    Object.prototype.toString.apply(h) ===
                                        "[object Array]")
                                )
                                    for (T = [], b = 0; b < h.length; b += 1)
                                        T[b] = l(h[b], g + "[" + b + "]");
                                else {
                                    T = {};
                                    for (S in h)
                                        Object.prototype.hasOwnProperty.call(
                                            h,
                                            S
                                        ) &&
                                            (T[S] = l(
                                                h[S],
                                                g +
                                                    "[" +
                                                    JSON.stringify(S) +
                                                    "]"
                                            ));
                                }
                                return T;
                            case "number":
                            case "string":
                            case "boolean":
                                return h;
                        }
                    })(o, "$");
                }
                function Ke(o) {
                    try {
                        return JSON.stringify(o);
                    } catch {
                        return JSON.stringify(Qi(o));
                    }
                }
                class Yi {
                    constructor() {
                        this.globalLog = (n) => {
                            window.console &&
                                window.console.log &&
                                window.console.log(n);
                        };
                    }
                    debug(...n) {
                        this.log(this.globalLog, n);
                    }
                    warn(...n) {
                        this.log(this.globalLogWarn, n);
                    }
                    error(...n) {
                        this.log(this.globalLogError, n);
                    }
                    globalLogWarn(n) {
                        window.console && window.console.warn
                            ? window.console.warn(n)
                            : this.globalLog(n);
                    }
                    globalLogError(n) {
                        window.console && window.console.error
                            ? window.console.error(n)
                            : this.globalLogWarn(n);
                    }
                    log(n, ...i) {
                        var l = Bi.apply(this, arguments);
                        Pt.log ? Pt.log(l) : Pt.logToConsole && n.bind(this)(l);
                    }
                }
                var N = new Yi(),
                    Zi = function (o, n, i, l, h) {
                        (i.headers !== void 0 || i.headersProvider != null) &&
                            N.warn(
                                `To send headers with the ${l.toString()} request, you must use AJAX, rather than JSONP.`
                            );
                        var g = o.nextAuthCallbackID.toString();
                        o.nextAuthCallbackID++;
                        var b = o.getDocument(),
                            S = b.createElement("script");
                        o.auth_callbacks[g] = function (R) {
                            h(null, R);
                        };
                        var T = "Pusher.auth_callbacks['" + g + "']";
                        S.src =
                            i.endpoint +
                            "?callback=" +
                            encodeURIComponent(T) +
                            "&" +
                            n;
                        var O =
                            b.getElementsByTagName("head")[0] ||
                            b.documentElement;
                        O.insertBefore(S, O.firstChild);
                    },
                    es = Zi;
                class ts {
                    constructor(n) {
                        this.src = n;
                    }
                    send(n) {
                        var i = this,
                            l = "Error loading " + i.src;
                        (i.script = document.createElement("script")),
                            (i.script.id = n.id),
                            (i.script.src = i.src),
                            (i.script.type = "text/javascript"),
                            (i.script.charset = "UTF-8"),
                            i.script.addEventListener
                                ? ((i.script.onerror = function () {
                                      n.callback(l);
                                  }),
                                  (i.script.onload = function () {
                                      n.callback(null);
                                  }))
                                : (i.script.onreadystatechange = function () {
                                      (i.script.readyState === "loaded" ||
                                          i.script.readyState === "complete") &&
                                          n.callback(null);
                                  }),
                            i.script.async === void 0 &&
                            document.attachEvent &&
                            /opera/i.test(navigator.userAgent)
                                ? ((i.errorScript =
                                      document.createElement("script")),
                                  (i.errorScript.id = n.id + "_error"),
                                  (i.errorScript.text =
                                      n.name + "('" + l + "');"),
                                  (i.script.async = i.errorScript.async = !1))
                                : (i.script.async = !0);
                        var h = document.getElementsByTagName("head")[0];
                        h.insertBefore(i.script, h.firstChild),
                            i.errorScript &&
                                h.insertBefore(
                                    i.errorScript,
                                    i.script.nextSibling
                                );
                    }
                    cleanup() {
                        this.script &&
                            ((this.script.onload = this.script.onerror = null),
                            (this.script.onreadystatechange = null)),
                            this.script &&
                                this.script.parentNode &&
                                this.script.parentNode.removeChild(this.script),
                            this.errorScript &&
                                this.errorScript.parentNode &&
                                this.errorScript.parentNode.removeChild(
                                    this.errorScript
                                ),
                            (this.script = null),
                            (this.errorScript = null);
                    }
                }
                class ns {
                    constructor(n, i) {
                        (this.url = n), (this.data = i);
                    }
                    send(n) {
                        if (!this.request) {
                            var i = Gi(this.data),
                                l = this.url + "/" + n.number + "?" + i;
                            (this.request = E.createScriptRequest(l)),
                                this.request.send(n);
                        }
                    }
                    cleanup() {
                        this.request && this.request.cleanup();
                    }
                }
                var rs = function (o, n) {
                        return function (i, l) {
                            var h = "http" + (n ? "s" : "") + "://",
                                g =
                                    h +
                                    (o.host || o.options.host) +
                                    o.options.path,
                                b = E.createJSONPRequest(g, i),
                                S = E.ScriptReceivers.create(function (T, O) {
                                    u.remove(S),
                                        b.cleanup(),
                                        O && O.host && (o.host = O.host),
                                        l && l(T, O);
                                });
                            b.send(S);
                        };
                    },
                    is = { name: "jsonp", getAgent: rs },
                    ss = is;
                function bt(o, n, i) {
                    var l = o + (n.useTLS ? "s" : ""),
                        h = n.useTLS ? n.hostTLS : n.hostNonTLS;
                    return l + "://" + h + i;
                }
                function yt(o, n) {
                    var i = "/app/" + o,
                        l =
                            "?protocol=" +
                            d.PROTOCOL +
                            "&client=js&version=" +
                            d.VERSION +
                            (n ? "&" + n : "");
                    return i + l;
                }
                var os = {
                        getInitial: function (o, n) {
                            var i = (n.httpPath || "") + yt(o, "flash=false");
                            return bt("ws", n, i);
                        },
                    },
                    as = {
                        getInitial: function (o, n) {
                            var i = (n.httpPath || "/pusher") + yt(o);
                            return bt("http", n, i);
                        },
                    },
                    cs = {
                        getInitial: function (o, n) {
                            return bt("http", n, n.httpPath || "/pusher");
                        },
                        getPath: function (o, n) {
                            return yt(o);
                        },
                    };
                class us {
                    constructor() {
                        this._callbacks = {};
                    }
                    get(n) {
                        return this._callbacks[mt(n)];
                    }
                    add(n, i, l) {
                        var h = mt(n);
                        (this._callbacks[h] = this._callbacks[h] || []),
                            this._callbacks[h].push({ fn: i, context: l });
                    }
                    remove(n, i, l) {
                        if (!n && !i && !l) {
                            this._callbacks = {};
                            return;
                        }
                        var h = n ? [mt(n)] : En(this._callbacks);
                        i || l
                            ? this.removeCallback(h, i, l)
                            : this.removeAllCallbacks(h);
                    }
                    removeCallback(n, i, l) {
                        Ie(
                            n,
                            function (h) {
                                (this._callbacks[h] = An(
                                    this._callbacks[h] || [],
                                    function (g) {
                                        return (
                                            (i && i !== g.fn) ||
                                            (l && l !== g.context)
                                        );
                                    }
                                )),
                                    this._callbacks[h].length === 0 &&
                                        delete this._callbacks[h];
                            },
                            this
                        );
                    }
                    removeAllCallbacks(n) {
                        Ie(
                            n,
                            function (i) {
                                delete this._callbacks[i];
                            },
                            this
                        );
                    }
                }
                function mt(o) {
                    return "_" + o;
                }
                class re {
                    constructor(n) {
                        (this.callbacks = new us()),
                            (this.global_callbacks = []),
                            (this.failThrough = n);
                    }
                    bind(n, i, l) {
                        return this.callbacks.add(n, i, l), this;
                    }
                    bind_global(n) {
                        return this.global_callbacks.push(n), this;
                    }
                    unbind(n, i, l) {
                        return this.callbacks.remove(n, i, l), this;
                    }
                    unbind_global(n) {
                        return n
                            ? ((this.global_callbacks = An(
                                  this.global_callbacks || [],
                                  (i) => i !== n
                              )),
                              this)
                            : ((this.global_callbacks = []), this);
                    }
                    unbind_all() {
                        return this.unbind(), this.unbind_global(), this;
                    }
                    emit(n, i, l) {
                        for (var h = 0; h < this.global_callbacks.length; h++)
                            this.global_callbacks[h](n, i);
                        var g = this.callbacks.get(n),
                            b = [];
                        if (
                            (l ? b.push(i, l) : i && b.push(i),
                            g && g.length > 0)
                        )
                            for (var h = 0; h < g.length; h++)
                                g[h].fn.apply(g[h].context || window, b);
                        else this.failThrough && this.failThrough(n, i);
                        return this;
                    }
                }
                class ls extends re {
                    constructor(n, i, l, h, g) {
                        super(),
                            (this.initialize =
                                E.transportConnectionInitializer),
                            (this.hooks = n),
                            (this.name = i),
                            (this.priority = l),
                            (this.key = h),
                            (this.options = g),
                            (this.state = "new"),
                            (this.timeline = g.timeline),
                            (this.activityTimeout = g.activityTimeout),
                            (this.id = this.timeline.generateUniqueID());
                    }
                    handlesActivityChecks() {
                        return !!this.hooks.handlesActivityChecks;
                    }
                    supportsPing() {
                        return !!this.hooks.supportsPing;
                    }
                    connect() {
                        if (this.socket || this.state !== "initialized")
                            return !1;
                        var n = this.hooks.urls.getInitial(
                            this.key,
                            this.options
                        );
                        try {
                            this.socket = this.hooks.getSocket(n, this.options);
                        } catch (i) {
                            return (
                                z.defer(() => {
                                    this.onError(i), this.changeState("closed");
                                }),
                                !1
                            );
                        }
                        return (
                            this.bindListeners(),
                            N.debug("Connecting", {
                                transport: this.name,
                                url: n,
                            }),
                            this.changeState("connecting"),
                            !0
                        );
                    }
                    close() {
                        return this.socket ? (this.socket.close(), !0) : !1;
                    }
                    send(n) {
                        return this.state === "open"
                            ? (z.defer(() => {
                                  this.socket && this.socket.send(n);
                              }),
                              !0)
                            : !1;
                    }
                    ping() {
                        this.state === "open" &&
                            this.supportsPing() &&
                            this.socket.ping();
                    }
                    onOpen() {
                        this.hooks.beforeOpen &&
                            this.hooks.beforeOpen(
                                this.socket,
                                this.hooks.urls.getPath(this.key, this.options)
                            ),
                            this.changeState("open"),
                            (this.socket.onopen = void 0);
                    }
                    onError(n) {
                        this.emit("error", {
                            type: "WebSocketError",
                            error: n,
                        }),
                            this.timeline.error(
                                this.buildTimelineMessage({
                                    error: n.toString(),
                                })
                            );
                    }
                    onClose(n) {
                        n
                            ? this.changeState("closed", {
                                  code: n.code,
                                  reason: n.reason,
                                  wasClean: n.wasClean,
                              })
                            : this.changeState("closed"),
                            this.unbindListeners(),
                            (this.socket = void 0);
                    }
                    onMessage(n) {
                        this.emit("message", n);
                    }
                    onActivity() {
                        this.emit("activity");
                    }
                    bindListeners() {
                        (this.socket.onopen = () => {
                            this.onOpen();
                        }),
                            (this.socket.onerror = (n) => {
                                this.onError(n);
                            }),
                            (this.socket.onclose = (n) => {
                                this.onClose(n);
                            }),
                            (this.socket.onmessage = (n) => {
                                this.onMessage(n);
                            }),
                            this.supportsPing() &&
                                (this.socket.onactivity = () => {
                                    this.onActivity();
                                });
                    }
                    unbindListeners() {
                        this.socket &&
                            ((this.socket.onopen = void 0),
                            (this.socket.onerror = void 0),
                            (this.socket.onclose = void 0),
                            (this.socket.onmessage = void 0),
                            this.supportsPing() &&
                                (this.socket.onactivity = void 0));
                    }
                    changeState(n, i) {
                        (this.state = n),
                            this.timeline.info(
                                this.buildTimelineMessage({
                                    state: n,
                                    params: i,
                                })
                            ),
                            this.emit(n, i);
                    }
                    buildTimelineMessage(n) {
                        return X({ cid: this.id }, n);
                    }
                }
                class xe {
                    constructor(n) {
                        this.hooks = n;
                    }
                    isSupported(n) {
                        return this.hooks.isSupported(n);
                    }
                    createConnection(n, i, l, h) {
                        return new ls(this.hooks, n, i, l, h);
                    }
                }
                var hs = new xe({
                        urls: os,
                        handlesActivityChecks: !1,
                        supportsPing: !1,
                        isInitialized: function () {
                            return !!E.getWebSocketAPI();
                        },
                        isSupported: function () {
                            return !!E.getWebSocketAPI();
                        },
                        getSocket: function (o) {
                            return E.createWebSocket(o);
                        },
                    }),
                    Rn = {
                        urls: as,
                        handlesActivityChecks: !1,
                        supportsPing: !0,
                        isInitialized: function () {
                            return !0;
                        },
                    },
                    Ln = X(
                        {
                            getSocket: function (o) {
                                return E.HTTPFactory.createStreamingSocket(o);
                            },
                        },
                        Rn
                    ),
                    jn = X(
                        {
                            getSocket: function (o) {
                                return E.HTTPFactory.createPollingSocket(o);
                            },
                        },
                        Rn
                    ),
                    Nn = {
                        isSupported: function () {
                            return E.isXHRSupported();
                        },
                    },
                    fs = new xe(X({}, Ln, Nn)),
                    ds = new xe(X({}, jn, Nn)),
                    ps = { ws: hs, xhr_streaming: fs, xhr_polling: ds },
                    Je = ps,
                    gs = new xe({
                        file: "sockjs",
                        urls: cs,
                        handlesActivityChecks: !0,
                        supportsPing: !1,
                        isSupported: function () {
                            return !0;
                        },
                        isInitialized: function () {
                            return window.SockJS !== void 0;
                        },
                        getSocket: function (o, n) {
                            return new window.SockJS(o, null, {
                                js_path: w.getPath("sockjs", {
                                    useTLS: n.useTLS,
                                }),
                                ignore_null_origin: n.ignoreNullOrigin,
                            });
                        },
                        beforeOpen: function (o, n) {
                            o.send(JSON.stringify({ path: n }));
                        },
                    }),
                    Mn = {
                        isSupported: function (o) {
                            var n = E.isXDRSupported(o.useTLS);
                            return n;
                        },
                    },
                    vs = new xe(X({}, Ln, Mn)),
                    _s = new xe(X({}, jn, Mn));
                (Je.xdr_streaming = vs),
                    (Je.xdr_polling = _s),
                    (Je.sockjs = gs);
                var bs = Je;
                class ys extends re {
                    constructor() {
                        super();
                        var n = this;
                        window.addEventListener !== void 0 &&
                            (window.addEventListener(
                                "online",
                                function () {
                                    n.emit("online");
                                },
                                !1
                            ),
                            window.addEventListener(
                                "offline",
                                function () {
                                    n.emit("offline");
                                },
                                !1
                            ));
                    }
                    isOnline() {
                        return window.navigator.onLine === void 0
                            ? !0
                            : window.navigator.onLine;
                    }
                }
                var ms = new ys();
                class ws {
                    constructor(n, i, l) {
                        (this.manager = n),
                            (this.transport = i),
                            (this.minPingDelay = l.minPingDelay),
                            (this.maxPingDelay = l.maxPingDelay),
                            (this.pingDelay = void 0);
                    }
                    createConnection(n, i, l, h) {
                        h = X({}, h, { activityTimeout: this.pingDelay });
                        var g = this.transport.createConnection(n, i, l, h),
                            b = null,
                            S = function () {
                                g.unbind("open", S),
                                    g.bind("closed", T),
                                    (b = z.now());
                            },
                            T = (O) => {
                                if (
                                    (g.unbind("closed", T),
                                    O.code === 1002 || O.code === 1003)
                                )
                                    this.manager.reportDeath();
                                else if (!O.wasClean && b) {
                                    var R = z.now() - b;
                                    R < 2 * this.maxPingDelay &&
                                        (this.manager.reportDeath(),
                                        (this.pingDelay = Math.max(
                                            R / 2,
                                            this.minPingDelay
                                        )));
                                }
                            };
                        return g.bind("open", S), g;
                    }
                    isSupported(n) {
                        return (
                            this.manager.isAlive() &&
                            this.transport.isSupported(n)
                        );
                    }
                }
                const Dn = {
                    decodeMessage: function (o) {
                        try {
                            var n = JSON.parse(o.data),
                                i = n.data;
                            if (typeof i == "string")
                                try {
                                    i = JSON.parse(n.data);
                                } catch {}
                            var l = {
                                event: n.event,
                                channel: n.channel,
                                data: i,
                            };
                            return n.user_id && (l.user_id = n.user_id), l;
                        } catch (h) {
                            throw {
                                type: "MessageParseError",
                                error: h,
                                data: o.data,
                            };
                        }
                    },
                    encodeMessage: function (o) {
                        return JSON.stringify(o);
                    },
                    processHandshake: function (o) {
                        var n = Dn.decodeMessage(o);
                        if (n.event === "pusher:connection_established") {
                            if (!n.data.activity_timeout)
                                throw "No activity timeout specified in handshake";
                            return {
                                action: "connected",
                                id: n.data.socket_id,
                                activityTimeout: n.data.activity_timeout * 1e3,
                            };
                        } else {
                            if (n.event === "pusher:error")
                                return {
                                    action: this.getCloseAction(n.data),
                                    error: this.getCloseError(n.data),
                                };
                            throw "Invalid handshake";
                        }
                    },
                    getCloseAction: function (o) {
                        return o.code < 4e3
                            ? o.code >= 1002 && o.code <= 1004
                                ? "backoff"
                                : null
                            : o.code === 4e3
                            ? "tls_only"
                            : o.code < 4100
                            ? "refused"
                            : o.code < 4200
                            ? "backoff"
                            : o.code < 4300
                            ? "retry"
                            : "refused";
                    },
                    getCloseError: function (o) {
                        return o.code !== 1e3 && o.code !== 1001
                            ? {
                                  type: "PusherError",
                                  data: {
                                      code: o.code,
                                      message: o.reason || o.message,
                                  },
                              }
                            : null;
                    },
                };
                var he = Dn;
                class xs extends re {
                    constructor(n, i) {
                        super(),
                            (this.id = n),
                            (this.transport = i),
                            (this.activityTimeout = i.activityTimeout),
                            this.bindListeners();
                    }
                    handlesActivityChecks() {
                        return this.transport.handlesActivityChecks();
                    }
                    send(n) {
                        return this.transport.send(n);
                    }
                    send_event(n, i, l) {
                        var h = { event: n, data: i };
                        return (
                            l && (h.channel = l),
                            N.debug("Event sent", h),
                            this.send(he.encodeMessage(h))
                        );
                    }
                    ping() {
                        this.transport.supportsPing()
                            ? this.transport.ping()
                            : this.send_event("pusher:ping", {});
                    }
                    close() {
                        this.transport.close();
                    }
                    bindListeners() {
                        var n = {
                                message: (l) => {
                                    var h;
                                    try {
                                        h = he.decodeMessage(l);
                                    } catch (g) {
                                        this.emit("error", {
                                            type: "MessageParseError",
                                            error: g,
                                            data: l.data,
                                        });
                                    }
                                    if (h !== void 0) {
                                        switch (
                                            (N.debug("Event recd", h), h.event)
                                        ) {
                                            case "pusher:error":
                                                this.emit("error", {
                                                    type: "PusherError",
                                                    data: h.data,
                                                });
                                                break;
                                            case "pusher:ping":
                                                this.emit("ping");
                                                break;
                                            case "pusher:pong":
                                                this.emit("pong");
                                                break;
                                        }
                                        this.emit("message", h);
                                    }
                                },
                                activity: () => {
                                    this.emit("activity");
                                },
                                error: (l) => {
                                    this.emit("error", l);
                                },
                                closed: (l) => {
                                    i(),
                                        l && l.code && this.handleCloseEvent(l),
                                        (this.transport = null),
                                        this.emit("closed");
                                },
                            },
                            i = () => {
                                ne(n, (l, h) => {
                                    this.transport.unbind(h, l);
                                });
                            };
                        ne(n, (l, h) => {
                            this.transport.bind(h, l);
                        });
                    }
                    handleCloseEvent(n) {
                        var i = he.getCloseAction(n),
                            l = he.getCloseError(n);
                        l && this.emit("error", l),
                            i && this.emit(i, { action: i, error: l });
                    }
                }
                class Ss {
                    constructor(n, i) {
                        (this.transport = n),
                            (this.callback = i),
                            this.bindListeners();
                    }
                    close() {
                        this.unbindListeners(), this.transport.close();
                    }
                    bindListeners() {
                        (this.onMessage = (n) => {
                            this.unbindListeners();
                            var i;
                            try {
                                i = he.processHandshake(n);
                            } catch (l) {
                                this.finish("error", { error: l }),
                                    this.transport.close();
                                return;
                            }
                            i.action === "connected"
                                ? this.finish("connected", {
                                      connection: new xs(i.id, this.transport),
                                      activityTimeout: i.activityTimeout,
                                  })
                                : (this.finish(i.action, { error: i.error }),
                                  this.transport.close());
                        }),
                            (this.onClosed = (n) => {
                                this.unbindListeners();
                                var i = he.getCloseAction(n) || "backoff",
                                    l = he.getCloseError(n);
                                this.finish(i, { error: l });
                            }),
                            this.transport.bind("message", this.onMessage),
                            this.transport.bind("closed", this.onClosed);
                    }
                    unbindListeners() {
                        this.transport.unbind("message", this.onMessage),
                            this.transport.unbind("closed", this.onClosed);
                    }
                    finish(n, i) {
                        this.callback(
                            X({ transport: this.transport, action: n }, i)
                        );
                    }
                }
                class Cs {
                    constructor(n, i) {
                        (this.timeline = n), (this.options = i || {});
                    }
                    send(n, i) {
                        this.timeline.isEmpty() ||
                            this.timeline.send(
                                E.TimelineTransport.getAgent(this, n),
                                i
                            );
                    }
                }
                class wt extends re {
                    constructor(n, i) {
                        super(function (l, h) {
                            N.debug("No callbacks on " + n + " for " + l);
                        }),
                            (this.name = n),
                            (this.pusher = i),
                            (this.subscribed = !1),
                            (this.subscriptionPending = !1),
                            (this.subscriptionCancelled = !1);
                    }
                    authorize(n, i) {
                        return i(null, { auth: "" });
                    }
                    trigger(n, i) {
                        if (n.indexOf("client-") !== 0)
                            throw new p(
                                "Event '" +
                                    n +
                                    "' does not start with 'client-'"
                            );
                        if (!this.subscribed) {
                            var l = A.buildLogSuffix("triggeringClientEvents");
                            N.warn(
                                `Client event triggered before channel 'subscription_succeeded' event . ${l}`
                            );
                        }
                        return this.pusher.send_event(n, i, this.name);
                    }
                    disconnect() {
                        (this.subscribed = !1), (this.subscriptionPending = !1);
                    }
                    handleEvent(n) {
                        var i = n.event,
                            l = n.data;
                        if (i === "pusher_internal:subscription_succeeded")
                            this.handleSubscriptionSucceededEvent(n);
                        else if (i === "pusher_internal:subscription_count")
                            this.handleSubscriptionCountEvent(n);
                        else if (i.indexOf("pusher_internal:") !== 0) {
                            var h = {};
                            this.emit(i, l, h);
                        }
                    }
                    handleSubscriptionSucceededEvent(n) {
                        (this.subscriptionPending = !1),
                            (this.subscribed = !0),
                            this.subscriptionCancelled
                                ? this.pusher.unsubscribe(this.name)
                                : this.emit(
                                      "pusher:subscription_succeeded",
                                      n.data
                                  );
                    }
                    handleSubscriptionCountEvent(n) {
                        n.data.subscription_count &&
                            (this.subscriptionCount =
                                n.data.subscription_count),
                            this.emit("pusher:subscription_count", n.data);
                    }
                    subscribe() {
                        this.subscribed ||
                            ((this.subscriptionPending = !0),
                            (this.subscriptionCancelled = !1),
                            this.authorize(
                                this.pusher.connection.socket_id,
                                (n, i) => {
                                    n
                                        ? ((this.subscriptionPending = !1),
                                          N.error(n.toString()),
                                          this.emit(
                                              "pusher:subscription_error",
                                              Object.assign(
                                                  {},
                                                  {
                                                      type: "AuthError",
                                                      error: n.message,
                                                  },
                                                  n instanceof W
                                                      ? { status: n.status }
                                                      : {}
                                              )
                                          ))
                                        : this.pusher.send_event(
                                              "pusher:subscribe",
                                              {
                                                  auth: i.auth,
                                                  channel_data: i.channel_data,
                                                  channel: this.name,
                                              }
                                          );
                                }
                            ));
                    }
                    unsubscribe() {
                        (this.subscribed = !1),
                            this.pusher.send_event("pusher:unsubscribe", {
                                channel: this.name,
                            });
                    }
                    cancelSubscription() {
                        this.subscriptionCancelled = !0;
                    }
                    reinstateSubscription() {
                        this.subscriptionCancelled = !1;
                    }
                }
                class xt extends wt {
                    authorize(n, i) {
                        return this.pusher.config.channelAuthorizer(
                            { channelName: this.name, socketId: n },
                            i
                        );
                    }
                }
                class ks {
                    constructor() {
                        this.reset();
                    }
                    get(n) {
                        return Object.prototype.hasOwnProperty.call(
                            this.members,
                            n
                        )
                            ? { id: n, info: this.members[n] }
                            : null;
                    }
                    each(n) {
                        ne(this.members, (i, l) => {
                            n(this.get(l));
                        });
                    }
                    setMyID(n) {
                        this.myID = n;
                    }
                    onSubscription(n) {
                        (this.members = n.presence.hash),
                            (this.count = n.presence.count),
                            (this.me = this.get(this.myID));
                    }
                    addMember(n) {
                        return (
                            this.get(n.user_id) === null && this.count++,
                            (this.members[n.user_id] = n.user_info),
                            this.get(n.user_id)
                        );
                    }
                    removeMember(n) {
                        var i = this.get(n.user_id);
                        return (
                            i && (delete this.members[n.user_id], this.count--),
                            i
                        );
                    }
                    reset() {
                        (this.members = {}),
                            (this.count = 0),
                            (this.myID = null),
                            (this.me = null);
                    }
                }
                var Ts = function (o, n, i, l) {
                    function h(g) {
                        return g instanceof i
                            ? g
                            : new i(function (b) {
                                  b(g);
                              });
                    }
                    return new (i || (i = Promise))(function (g, b) {
                        function S(R) {
                            try {
                                O(l.next(R));
                            } catch (D) {
                                b(D);
                            }
                        }
                        function T(R) {
                            try {
                                O(l.throw(R));
                            } catch (D) {
                                b(D);
                            }
                        }
                        function O(R) {
                            R.done ? g(R.value) : h(R.value).then(S, T);
                        }
                        O((l = l.apply(o, n || [])).next());
                    });
                };
                class Es extends xt {
                    constructor(n, i) {
                        super(n, i), (this.members = new ks());
                    }
                    authorize(n, i) {
                        super.authorize(n, (l, h) =>
                            Ts(this, void 0, void 0, function* () {
                                if (!l)
                                    if (((h = h), h.channel_data != null)) {
                                        var g = JSON.parse(h.channel_data);
                                        this.members.setMyID(g.user_id);
                                    } else if (
                                        (yield this.pusher.user
                                            .signinDonePromise,
                                        this.pusher.user.user_data != null)
                                    )
                                        this.members.setMyID(
                                            this.pusher.user.user_data.id
                                        );
                                    else {
                                        let b = A.buildLogSuffix(
                                            "authorizationEndpoint"
                                        );
                                        N.error(
                                            `Invalid auth response for channel '${this.name}', expected 'channel_data' field. ${b}, or the user should be signed in.`
                                        ),
                                            i("Invalid auth response");
                                        return;
                                    }
                                i(l, h);
                            })
                        );
                    }
                    handleEvent(n) {
                        var i = n.event;
                        if (i.indexOf("pusher_internal:") === 0)
                            this.handleInternalEvent(n);
                        else {
                            var l = n.data,
                                h = {};
                            n.user_id && (h.user_id = n.user_id),
                                this.emit(i, l, h);
                        }
                    }
                    handleInternalEvent(n) {
                        var i = n.event,
                            l = n.data;
                        switch (i) {
                            case "pusher_internal:subscription_succeeded":
                                this.handleSubscriptionSucceededEvent(n);
                                break;
                            case "pusher_internal:subscription_count":
                                this.handleSubscriptionCountEvent(n);
                                break;
                            case "pusher_internal:member_added":
                                var h = this.members.addMember(l);
                                this.emit("pusher:member_added", h);
                                break;
                            case "pusher_internal:member_removed":
                                var g = this.members.removeMember(l);
                                g && this.emit("pusher:member_removed", g);
                                break;
                        }
                    }
                    handleSubscriptionSucceededEvent(n) {
                        (this.subscriptionPending = !1),
                            (this.subscribed = !0),
                            this.subscriptionCancelled
                                ? this.pusher.unsubscribe(this.name)
                                : (this.members.onSubscription(n.data),
                                  this.emit(
                                      "pusher:subscription_succeeded",
                                      this.members
                                  ));
                    }
                    disconnect() {
                        this.members.reset(), super.disconnect();
                    }
                }
                var Ps = a(1),
                    St = a(0);
                class As extends xt {
                    constructor(n, i, l) {
                        super(n, i), (this.key = null), (this.nacl = l);
                    }
                    authorize(n, i) {
                        super.authorize(n, (l, h) => {
                            if (l) {
                                i(l, h);
                                return;
                            }
                            let g = h.shared_secret;
                            if (!g) {
                                i(
                                    new Error(
                                        `No shared_secret key in auth payload for encrypted channel: ${this.name}`
                                    ),
                                    null
                                );
                                return;
                            }
                            (this.key = Object(St.decode)(g)),
                                delete h.shared_secret,
                                i(null, h);
                        });
                    }
                    trigger(n, i) {
                        throw new j(
                            "Client events are not currently supported for encrypted channels"
                        );
                    }
                    handleEvent(n) {
                        var i = n.event,
                            l = n.data;
                        if (
                            i.indexOf("pusher_internal:") === 0 ||
                            i.indexOf("pusher:") === 0
                        ) {
                            super.handleEvent(n);
                            return;
                        }
                        this.handleEncryptedEvent(i, l);
                    }
                    handleEncryptedEvent(n, i) {
                        if (!this.key) {
                            N.debug(
                                "Received encrypted event before key has been retrieved from the authEndpoint"
                            );
                            return;
                        }
                        if (!i.ciphertext || !i.nonce) {
                            N.error(
                                "Unexpected format for encrypted event, expected object with `ciphertext` and `nonce` fields, got: " +
                                    i
                            );
                            return;
                        }
                        let l = Object(St.decode)(i.ciphertext);
                        if (l.length < this.nacl.secretbox.overheadLength) {
                            N.error(
                                `Expected encrypted event ciphertext length to be ${this.nacl.secretbox.overheadLength}, got: ${l.length}`
                            );
                            return;
                        }
                        let h = Object(St.decode)(i.nonce);
                        if (h.length < this.nacl.secretbox.nonceLength) {
                            N.error(
                                `Expected encrypted event nonce length to be ${this.nacl.secretbox.nonceLength}, got: ${h.length}`
                            );
                            return;
                        }
                        let g = this.nacl.secretbox.open(l, h, this.key);
                        if (g === null) {
                            N.debug(
                                "Failed to decrypt an event, probably because it was encrypted with a different key. Fetching a new key from the authEndpoint..."
                            ),
                                this.authorize(
                                    this.pusher.connection.socket_id,
                                    (b, S) => {
                                        if (b) {
                                            N.error(
                                                `Failed to make a request to the authEndpoint: ${S}. Unable to fetch new key, so dropping encrypted event`
                                            );
                                            return;
                                        }
                                        if (
                                            ((g = this.nacl.secretbox.open(
                                                l,
                                                h,
                                                this.key
                                            )),
                                            g === null)
                                        ) {
                                            N.error(
                                                "Failed to decrypt event with new key. Dropping encrypted event"
                                            );
                                            return;
                                        }
                                        this.emit(n, this.getDataToEmit(g));
                                    }
                                );
                            return;
                        }
                        this.emit(n, this.getDataToEmit(g));
                    }
                    getDataToEmit(n) {
                        let i = Object(Ps.decode)(n);
                        try {
                            return JSON.parse(i);
                        } catch {
                            return i;
                        }
                    }
                }
                class Os extends re {
                    constructor(n, i) {
                        super(),
                            (this.state = "initialized"),
                            (this.connection = null),
                            (this.key = n),
                            (this.options = i),
                            (this.timeline = this.options.timeline),
                            (this.usingTLS = this.options.useTLS),
                            (this.errorCallbacks = this.buildErrorCallbacks()),
                            (this.connectionCallbacks =
                                this.buildConnectionCallbacks(
                                    this.errorCallbacks
                                )),
                            (this.handshakeCallbacks =
                                this.buildHandshakeCallbacks(
                                    this.errorCallbacks
                                ));
                        var l = E.getNetwork();
                        l.bind("online", () => {
                            this.timeline.info({ netinfo: "online" }),
                                (this.state === "connecting" ||
                                    this.state === "unavailable") &&
                                    this.retryIn(0);
                        }),
                            l.bind("offline", () => {
                                this.timeline.info({ netinfo: "offline" }),
                                    this.connection && this.sendActivityCheck();
                            }),
                            this.updateStrategy();
                    }
                    switchCluster(n) {
                        (this.key = n), this.updateStrategy(), this.retryIn(0);
                    }
                    connect() {
                        if (!(this.connection || this.runner)) {
                            if (!this.strategy.isSupported()) {
                                this.updateState("failed");
                                return;
                            }
                            this.updateState("connecting"),
                                this.startConnecting(),
                                this.setUnavailableTimer();
                        }
                    }
                    send(n) {
                        return this.connection ? this.connection.send(n) : !1;
                    }
                    send_event(n, i, l) {
                        return this.connection
                            ? this.connection.send_event(n, i, l)
                            : !1;
                    }
                    disconnect() {
                        this.disconnectInternally(),
                            this.updateState("disconnected");
                    }
                    isUsingTLS() {
                        return this.usingTLS;
                    }
                    startConnecting() {
                        var n = (i, l) => {
                            i
                                ? (this.runner = this.strategy.connect(0, n))
                                : l.action === "error"
                                ? (this.emit("error", {
                                      type: "HandshakeError",
                                      error: l.error,
                                  }),
                                  this.timeline.error({
                                      handshakeError: l.error,
                                  }))
                                : (this.abortConnecting(),
                                  this.handshakeCallbacks[l.action](l));
                        };
                        this.runner = this.strategy.connect(0, n);
                    }
                    abortConnecting() {
                        this.runner &&
                            (this.runner.abort(), (this.runner = null));
                    }
                    disconnectInternally() {
                        if (
                            (this.abortConnecting(),
                            this.clearRetryTimer(),
                            this.clearUnavailableTimer(),
                            this.connection)
                        ) {
                            var n = this.abandonConnection();
                            n.close();
                        }
                    }
                    updateStrategy() {
                        this.strategy = this.options.getStrategy({
                            key: this.key,
                            timeline: this.timeline,
                            useTLS: this.usingTLS,
                        });
                    }
                    retryIn(n) {
                        this.timeline.info({ action: "retry", delay: n }),
                            n > 0 &&
                                this.emit("connecting_in", Math.round(n / 1e3)),
                            (this.retryTimer = new le(n || 0, () => {
                                this.disconnectInternally(), this.connect();
                            }));
                    }
                    clearRetryTimer() {
                        this.retryTimer &&
                            (this.retryTimer.ensureAborted(),
                            (this.retryTimer = null));
                    }
                    setUnavailableTimer() {
                        this.unavailableTimer = new le(
                            this.options.unavailableTimeout,
                            () => {
                                this.updateState("unavailable");
                            }
                        );
                    }
                    clearUnavailableTimer() {
                        this.unavailableTimer &&
                            this.unavailableTimer.ensureAborted();
                    }
                    sendActivityCheck() {
                        this.stopActivityCheck(),
                            this.connection.ping(),
                            (this.activityTimer = new le(
                                this.options.pongTimeout,
                                () => {
                                    this.timeline.error({
                                        pong_timed_out:
                                            this.options.pongTimeout,
                                    }),
                                        this.retryIn(0);
                                }
                            ));
                    }
                    resetActivityCheck() {
                        this.stopActivityCheck(),
                            this.connection &&
                                !this.connection.handlesActivityChecks() &&
                                (this.activityTimer = new le(
                                    this.activityTimeout,
                                    () => {
                                        this.sendActivityCheck();
                                    }
                                ));
                    }
                    stopActivityCheck() {
                        this.activityTimer &&
                            this.activityTimer.ensureAborted();
                    }
                    buildConnectionCallbacks(n) {
                        return X({}, n, {
                            message: (i) => {
                                this.resetActivityCheck(),
                                    this.emit("message", i);
                            },
                            ping: () => {
                                this.send_event("pusher:pong", {});
                            },
                            activity: () => {
                                this.resetActivityCheck();
                            },
                            error: (i) => {
                                this.emit("error", i);
                            },
                            closed: () => {
                                this.abandonConnection(),
                                    this.shouldRetry() && this.retryIn(1e3);
                            },
                        });
                    }
                    buildHandshakeCallbacks(n) {
                        return X({}, n, {
                            connected: (i) => {
                                (this.activityTimeout = Math.min(
                                    this.options.activityTimeout,
                                    i.activityTimeout,
                                    i.connection.activityTimeout || 1 / 0
                                )),
                                    this.clearUnavailableTimer(),
                                    this.setConnection(i.connection),
                                    (this.socket_id = this.connection.id),
                                    this.updateState("connected", {
                                        socket_id: this.socket_id,
                                    });
                            },
                        });
                    }
                    buildErrorCallbacks() {
                        let n = (i) => (l) => {
                            l.error &&
                                this.emit("error", {
                                    type: "WebSocketError",
                                    error: l.error,
                                }),
                                i(l);
                        };
                        return {
                            tls_only: n(() => {
                                (this.usingTLS = !0),
                                    this.updateStrategy(),
                                    this.retryIn(0);
                            }),
                            refused: n(() => {
                                this.disconnect();
                            }),
                            backoff: n(() => {
                                this.retryIn(1e3);
                            }),
                            retry: n(() => {
                                this.retryIn(0);
                            }),
                        };
                    }
                    setConnection(n) {
                        this.connection = n;
                        for (var i in this.connectionCallbacks)
                            this.connection.bind(
                                i,
                                this.connectionCallbacks[i]
                            );
                        this.resetActivityCheck();
                    }
                    abandonConnection() {
                        if (this.connection) {
                            this.stopActivityCheck();
                            for (var n in this.connectionCallbacks)
                                this.connection.unbind(
                                    n,
                                    this.connectionCallbacks[n]
                                );
                            var i = this.connection;
                            return (this.connection = null), i;
                        }
                    }
                    updateState(n, i) {
                        var l = this.state;
                        if (((this.state = n), l !== n)) {
                            var h = n;
                            h === "connected" &&
                                (h += " with new socket ID " + i.socket_id),
                                N.debug("State changed", l + " -> " + h),
                                this.timeline.info({ state: n, params: i }),
                                this.emit("state_change", {
                                    previous: l,
                                    current: n,
                                }),
                                this.emit(n, i);
                        }
                    }
                    shouldRetry() {
                        return (
                            this.state === "connecting" ||
                            this.state === "connected"
                        );
                    }
                }
                class Is {
                    constructor() {
                        this.channels = {};
                    }
                    add(n, i) {
                        return (
                            this.channels[n] || (this.channels[n] = Rs(n, i)),
                            this.channels[n]
                        );
                    }
                    all() {
                        return Wi(this.channels);
                    }
                    find(n) {
                        return this.channels[n];
                    }
                    remove(n) {
                        var i = this.channels[n];
                        return delete this.channels[n], i;
                    }
                    disconnect() {
                        ne(this.channels, function (n) {
                            n.disconnect();
                        });
                    }
                }
                function Rs(o, n) {
                    if (o.indexOf("private-encrypted-") === 0) {
                        if (n.config.nacl)
                            return ie.createEncryptedChannel(
                                o,
                                n,
                                n.config.nacl
                            );
                        let i =
                                "Tried to subscribe to a private-encrypted- channel but no nacl implementation available",
                            l = A.buildLogSuffix("encryptedChannelSupport");
                        throw new j(`${i}. ${l}`);
                    } else {
                        if (o.indexOf("private-") === 0)
                            return ie.createPrivateChannel(o, n);
                        if (o.indexOf("presence-") === 0)
                            return ie.createPresenceChannel(o, n);
                        if (o.indexOf("#") === 0)
                            throw new v(
                                'Cannot create a channel with name "' + o + '".'
                            );
                        return ie.createChannel(o, n);
                    }
                }
                var Ls = {
                        createChannels() {
                            return new Is();
                        },
                        createConnectionManager(o, n) {
                            return new Os(o, n);
                        },
                        createChannel(o, n) {
                            return new wt(o, n);
                        },
                        createPrivateChannel(o, n) {
                            return new xt(o, n);
                        },
                        createPresenceChannel(o, n) {
                            return new Es(o, n);
                        },
                        createEncryptedChannel(o, n, i) {
                            return new As(o, n, i);
                        },
                        createTimelineSender(o, n) {
                            return new Cs(o, n);
                        },
                        createHandshake(o, n) {
                            return new Ss(o, n);
                        },
                        createAssistantToTheTransportManager(o, n, i) {
                            return new ws(o, n, i);
                        },
                    },
                    ie = Ls;
                class qn {
                    constructor(n) {
                        (this.options = n || {}),
                            (this.livesLeft = this.options.lives || 1 / 0);
                    }
                    getAssistant(n) {
                        return ie.createAssistantToTheTransportManager(
                            this,
                            n,
                            {
                                minPingDelay: this.options.minPingDelay,
                                maxPingDelay: this.options.maxPingDelay,
                            }
                        );
                    }
                    isAlive() {
                        return this.livesLeft > 0;
                    }
                    reportDeath() {
                        this.livesLeft -= 1;
                    }
                }
                class fe {
                    constructor(n, i) {
                        (this.strategies = n),
                            (this.loop = !!i.loop),
                            (this.failFast = !!i.failFast),
                            (this.timeout = i.timeout),
                            (this.timeoutLimit = i.timeoutLimit);
                    }
                    isSupported() {
                        return In(this.strategies, z.method("isSupported"));
                    }
                    connect(n, i) {
                        var l = this.strategies,
                            h = 0,
                            g = this.timeout,
                            b = null,
                            S = (T, O) => {
                                O
                                    ? i(null, O)
                                    : ((h = h + 1),
                                      this.loop && (h = h % l.length),
                                      h < l.length
                                          ? (g &&
                                                ((g = g * 2),
                                                this.timeoutLimit &&
                                                    (g = Math.min(
                                                        g,
                                                        this.timeoutLimit
                                                    ))),
                                            (b = this.tryStrategy(
                                                l[h],
                                                n,
                                                {
                                                    timeout: g,
                                                    failFast: this.failFast,
                                                },
                                                S
                                            )))
                                          : i(!0));
                            };
                        return (
                            (b = this.tryStrategy(
                                l[h],
                                n,
                                { timeout: g, failFast: this.failFast },
                                S
                            )),
                            {
                                abort: function () {
                                    b.abort();
                                },
                                forceMinPriority: function (T) {
                                    (n = T), b && b.forceMinPriority(T);
                                },
                            }
                        );
                    }
                    tryStrategy(n, i, l, h) {
                        var g = null,
                            b = null;
                        return (
                            l.timeout > 0 &&
                                (g = new le(l.timeout, function () {
                                    b.abort(), h(!0);
                                })),
                            (b = n.connect(i, function (S, T) {
                                (S && g && g.isRunning() && !l.failFast) ||
                                    (g && g.ensureAborted(), h(S, T));
                            })),
                            {
                                abort: function () {
                                    g && g.ensureAborted(), b.abort();
                                },
                                forceMinPriority: function (S) {
                                    b.forceMinPriority(S);
                                },
                            }
                        );
                    }
                }
                class Ct {
                    constructor(n) {
                        this.strategies = n;
                    }
                    isSupported() {
                        return In(this.strategies, z.method("isSupported"));
                    }
                    connect(n, i) {
                        return js(this.strategies, n, function (l, h) {
                            return function (g, b) {
                                if (((h[l].error = g), g)) {
                                    Ns(h) && i(!0);
                                    return;
                                }
                                Ie(h, function (S) {
                                    S.forceMinPriority(b.transport.priority);
                                }),
                                    i(null, b);
                            };
                        });
                    }
                }
                function js(o, n, i) {
                    var l = Pn(o, function (h, g, b, S) {
                        return h.connect(n, i(g, S));
                    });
                    return {
                        abort: function () {
                            Ie(l, Ms);
                        },
                        forceMinPriority: function (h) {
                            Ie(l, function (g) {
                                g.forceMinPriority(h);
                            });
                        },
                    };
                }
                function Ns(o) {
                    return Ji(o, function (n) {
                        return !!n.error;
                    });
                }
                function Ms(o) {
                    !o.error && !o.aborted && (o.abort(), (o.aborted = !0));
                }
                class Ds {
                    constructor(n, i, l) {
                        (this.strategy = n),
                            (this.transports = i),
                            (this.ttl = l.ttl || 1800 * 1e3),
                            (this.usingTLS = l.useTLS),
                            (this.timeline = l.timeline);
                    }
                    isSupported() {
                        return this.strategy.isSupported();
                    }
                    connect(n, i) {
                        var l = this.usingTLS,
                            h = qs(l),
                            g = h && h.cacheSkipCount ? h.cacheSkipCount : 0,
                            b = [this.strategy];
                        if (h && h.timestamp + this.ttl >= z.now()) {
                            var S = this.transports[h.transport];
                            S &&
                                (["ws", "wss"].includes(h.transport) || g > 3
                                    ? (this.timeline.info({
                                          cached: !0,
                                          transport: h.transport,
                                          latency: h.latency,
                                      }),
                                      b.push(
                                          new fe([S], {
                                              timeout: h.latency * 2 + 1e3,
                                              failFast: !0,
                                          })
                                      ))
                                    : g++);
                        }
                        var T = z.now(),
                            O = b.pop().connect(n, function R(D, Qe) {
                                D
                                    ? (Hn(l),
                                      b.length > 0
                                          ? ((T = z.now()),
                                            (O = b.pop().connect(n, R)))
                                          : i(D))
                                    : (Hs(l, Qe.transport.name, z.now() - T, g),
                                      i(null, Qe));
                            });
                        return {
                            abort: function () {
                                O.abort();
                            },
                            forceMinPriority: function (R) {
                                (n = R), O && O.forceMinPriority(R);
                            },
                        };
                    }
                }
                function kt(o) {
                    return "pusherTransport" + (o ? "TLS" : "NonTLS");
                }
                function qs(o) {
                    var n = E.getLocalStorage();
                    if (n)
                        try {
                            var i = n[kt(o)];
                            if (i) return JSON.parse(i);
                        } catch {
                            Hn(o);
                        }
                    return null;
                }
                function Hs(o, n, i, l) {
                    var h = E.getLocalStorage();
                    if (h)
                        try {
                            h[kt(o)] = Ke({
                                timestamp: z.now(),
                                transport: n,
                                latency: i,
                                cacheSkipCount: l,
                            });
                        } catch {}
                }
                function Hn(o) {
                    var n = E.getLocalStorage();
                    if (n)
                        try {
                            delete n[kt(o)];
                        } catch {}
                }
                class Ve {
                    constructor(n, { delay: i }) {
                        (this.strategy = n), (this.options = { delay: i });
                    }
                    isSupported() {
                        return this.strategy.isSupported();
                    }
                    connect(n, i) {
                        var l = this.strategy,
                            h,
                            g = new le(this.options.delay, function () {
                                h = l.connect(n, i);
                            });
                        return {
                            abort: function () {
                                g.ensureAborted(), h && h.abort();
                            },
                            forceMinPriority: function (b) {
                                (n = b), h && h.forceMinPriority(b);
                            },
                        };
                    }
                }
                class Re {
                    constructor(n, i, l) {
                        (this.test = n),
                            (this.trueBranch = i),
                            (this.falseBranch = l);
                    }
                    isSupported() {
                        var n = this.test()
                            ? this.trueBranch
                            : this.falseBranch;
                        return n.isSupported();
                    }
                    connect(n, i) {
                        var l = this.test()
                            ? this.trueBranch
                            : this.falseBranch;
                        return l.connect(n, i);
                    }
                }
                class $s {
                    constructor(n) {
                        this.strategy = n;
                    }
                    isSupported() {
                        return this.strategy.isSupported();
                    }
                    connect(n, i) {
                        var l = this.strategy.connect(n, function (h, g) {
                            g && l.abort(), i(h, g);
                        });
                        return l;
                    }
                }
                function Le(o) {
                    return function () {
                        return o.isSupported();
                    };
                }
                var Fs = function (o, n, i) {
                        var l = {};
                        function h(Yn, Fo, Uo, zo, Bo) {
                            var Zn = i(o, Yn, Fo, Uo, zo, Bo);
                            return (l[Yn] = Zn), Zn;
                        }
                        var g = Object.assign({}, n, {
                                hostNonTLS: o.wsHost + ":" + o.wsPort,
                                hostTLS: o.wsHost + ":" + o.wssPort,
                                httpPath: o.wsPath,
                            }),
                            b = Object.assign({}, g, { useTLS: !0 }),
                            S = Object.assign({}, n, {
                                hostNonTLS: o.httpHost + ":" + o.httpPort,
                                hostTLS: o.httpHost + ":" + o.httpsPort,
                                httpPath: o.httpPath,
                            }),
                            T = { loop: !0, timeout: 15e3, timeoutLimit: 6e4 },
                            O = new qn({
                                minPingDelay: 1e4,
                                maxPingDelay: o.activityTimeout,
                            }),
                            R = new qn({
                                lives: 2,
                                minPingDelay: 1e4,
                                maxPingDelay: o.activityTimeout,
                            }),
                            D = h("ws", "ws", 3, g, O),
                            Qe = h("wss", "ws", 3, b, O),
                            Mo = h("sockjs", "sockjs", 1, S),
                            Xn = h("xhr_streaming", "xhr_streaming", 1, S, R),
                            Do = h("xdr_streaming", "xdr_streaming", 1, S, R),
                            Kn = h("xhr_polling", "xhr_polling", 1, S),
                            qo = h("xdr_polling", "xdr_polling", 1, S),
                            Jn = new fe([D], T),
                            Ho = new fe([Qe], T),
                            $o = new fe([Mo], T),
                            Vn = new fe([new Re(Le(Xn), Xn, Do)], T),
                            Gn = new fe([new Re(Le(Kn), Kn, qo)], T),
                            Qn = new fe(
                                [
                                    new Re(
                                        Le(Vn),
                                        new Ct([
                                            Vn,
                                            new Ve(Gn, { delay: 4e3 }),
                                        ]),
                                        Gn
                                    ),
                                ],
                                T
                            ),
                            At = new Re(Le(Qn), Qn, $o),
                            Ot;
                        return (
                            n.useTLS
                                ? (Ot = new Ct([
                                      Jn,
                                      new Ve(At, { delay: 2e3 }),
                                  ]))
                                : (Ot = new Ct([
                                      Jn,
                                      new Ve(Ho, { delay: 2e3 }),
                                      new Ve(At, { delay: 5e3 }),
                                  ])),
                            new Ds(new $s(new Re(Le(D), Ot, At)), l, {
                                ttl: 18e5,
                                timeline: n.timeline,
                                useTLS: n.useTLS,
                            })
                        );
                    },
                    Us = Fs,
                    zs = function () {
                        var o = this;
                        o.timeline.info(
                            o.buildTimelineMessage({
                                transport:
                                    o.name + (o.options.useTLS ? "s" : ""),
                            })
                        ),
                            o.hooks.isInitialized()
                                ? o.changeState("initialized")
                                : o.hooks.file
                                ? (o.changeState("initializing"),
                                  w.load(
                                      o.hooks.file,
                                      { useTLS: o.options.useTLS },
                                      function (n, i) {
                                          o.hooks.isInitialized()
                                              ? (o.changeState("initialized"),
                                                i(!0))
                                              : (n && o.onError(n),
                                                o.onClose(),
                                                i(!1));
                                      }
                                  ))
                                : o.onClose();
                    },
                    Bs = {
                        getRequest: function (o) {
                            var n = new window.XDomainRequest();
                            return (
                                (n.ontimeout = function () {
                                    o.emit("error", new x()), o.close();
                                }),
                                (n.onerror = function (i) {
                                    o.emit("error", i), o.close();
                                }),
                                (n.onprogress = function () {
                                    n.responseText &&
                                        n.responseText.length > 0 &&
                                        o.onChunk(200, n.responseText);
                                }),
                                (n.onload = function () {
                                    n.responseText &&
                                        n.responseText.length > 0 &&
                                        o.onChunk(200, n.responseText),
                                        o.emit("finished", 200),
                                        o.close();
                                }),
                                n
                            );
                        },
                        abortRequest: function (o) {
                            (o.ontimeout =
                                o.onerror =
                                o.onprogress =
                                o.onload =
                                    null),
                                o.abort();
                        },
                    },
                    Ws = Bs;
                const Xs = 256 * 1024;
                class Ks extends re {
                    constructor(n, i, l) {
                        super(),
                            (this.hooks = n),
                            (this.method = i),
                            (this.url = l);
                    }
                    start(n) {
                        (this.position = 0),
                            (this.xhr = this.hooks.getRequest(this)),
                            (this.unloader = () => {
                                this.close();
                            }),
                            E.addUnloadListener(this.unloader),
                            this.xhr.open(this.method, this.url, !0),
                            this.xhr.setRequestHeader &&
                                this.xhr.setRequestHeader(
                                    "Content-Type",
                                    "application/json"
                                ),
                            this.xhr.send(n);
                    }
                    close() {
                        this.unloader &&
                            (E.removeUnloadListener(this.unloader),
                            (this.unloader = null)),
                            this.xhr &&
                                (this.hooks.abortRequest(this.xhr),
                                (this.xhr = null));
                    }
                    onChunk(n, i) {
                        for (;;) {
                            var l = this.advanceBuffer(i);
                            if (l) this.emit("chunk", { status: n, data: l });
                            else break;
                        }
                        this.isBufferTooLong(i) && this.emit("buffer_too_long");
                    }
                    advanceBuffer(n) {
                        var i = n.slice(this.position),
                            l = i.indexOf(`
`);
                        return l !== -1
                            ? ((this.position += l + 1), i.slice(0, l))
                            : null;
                    }
                    isBufferTooLong(n) {
                        return this.position === n.length && n.length > Xs;
                    }
                }
                var Tt;
                (function (o) {
                    (o[(o.CONNECTING = 0)] = "CONNECTING"),
                        (o[(o.OPEN = 1)] = "OPEN"),
                        (o[(o.CLOSED = 3)] = "CLOSED");
                })(Tt || (Tt = {}));
                var de = Tt,
                    Js = 1;
                class Vs {
                    constructor(n, i) {
                        (this.hooks = n),
                            (this.session = Fn(1e3) + "/" + Zs(8)),
                            (this.location = Gs(i)),
                            (this.readyState = de.CONNECTING),
                            this.openStream();
                    }
                    send(n) {
                        return this.sendRaw(JSON.stringify([n]));
                    }
                    ping() {
                        this.hooks.sendHeartbeat(this);
                    }
                    close(n, i) {
                        this.onClose(n, i, !0);
                    }
                    sendRaw(n) {
                        if (this.readyState === de.OPEN)
                            try {
                                return (
                                    E.createSocketRequest(
                                        "POST",
                                        $n(Qs(this.location, this.session))
                                    ).start(n),
                                    !0
                                );
                            } catch {
                                return !1;
                            }
                        else return !1;
                    }
                    reconnect() {
                        this.closeStream(), this.openStream();
                    }
                    onClose(n, i, l) {
                        this.closeStream(),
                            (this.readyState = de.CLOSED),
                            this.onclose &&
                                this.onclose({
                                    code: n,
                                    reason: i,
                                    wasClean: l,
                                });
                    }
                    onChunk(n) {
                        if (n.status === 200) {
                            this.readyState === de.OPEN && this.onActivity();
                            var i,
                                l = n.data.slice(0, 1);
                            switch (l) {
                                case "o":
                                    (i = JSON.parse(n.data.slice(1) || "{}")),
                                        this.onOpen(i);
                                    break;
                                case "a":
                                    i = JSON.parse(n.data.slice(1) || "[]");
                                    for (var h = 0; h < i.length; h++)
                                        this.onEvent(i[h]);
                                    break;
                                case "m":
                                    (i = JSON.parse(n.data.slice(1) || "null")),
                                        this.onEvent(i);
                                    break;
                                case "h":
                                    this.hooks.onHeartbeat(this);
                                    break;
                                case "c":
                                    (i = JSON.parse(n.data.slice(1) || "[]")),
                                        this.onClose(i[0], i[1], !0);
                                    break;
                            }
                        }
                    }
                    onOpen(n) {
                        this.readyState === de.CONNECTING
                            ? (n &&
                                  n.hostname &&
                                  (this.location.base = Ys(
                                      this.location.base,
                                      n.hostname
                                  )),
                              (this.readyState = de.OPEN),
                              this.onopen && this.onopen())
                            : this.onClose(1006, "Server lost session", !0);
                    }
                    onEvent(n) {
                        this.readyState === de.OPEN &&
                            this.onmessage &&
                            this.onmessage({ data: n });
                    }
                    onActivity() {
                        this.onactivity && this.onactivity();
                    }
                    onError(n) {
                        this.onerror && this.onerror(n);
                    }
                    openStream() {
                        (this.stream = E.createSocketRequest(
                            "POST",
                            $n(
                                this.hooks.getReceiveURL(
                                    this.location,
                                    this.session
                                )
                            )
                        )),
                            this.stream.bind("chunk", (n) => {
                                this.onChunk(n);
                            }),
                            this.stream.bind("finished", (n) => {
                                this.hooks.onFinished(this, n);
                            }),
                            this.stream.bind("buffer_too_long", () => {
                                this.reconnect();
                            });
                        try {
                            this.stream.start();
                        } catch (n) {
                            z.defer(() => {
                                this.onError(n),
                                    this.onClose(
                                        1006,
                                        "Could not start streaming",
                                        !1
                                    );
                            });
                        }
                    }
                    closeStream() {
                        this.stream &&
                            (this.stream.unbind_all(),
                            this.stream.close(),
                            (this.stream = null));
                    }
                }
                function Gs(o) {
                    var n = /([^\?]*)\/*(\??.*)/.exec(o);
                    return { base: n[1], queryString: n[2] };
                }
                function Qs(o, n) {
                    return o.base + "/" + n + "/xhr_send";
                }
                function $n(o) {
                    var n = o.indexOf("?") === -1 ? "?" : "&";
                    return o + n + "t=" + +new Date() + "&n=" + Js++;
                }
                function Ys(o, n) {
                    var i = /(https?:\/\/)([^\/:]+)((\/|:)?.*)/.exec(o);
                    return i[1] + n + i[3];
                }
                function Fn(o) {
                    return E.randomInt(o);
                }
                function Zs(o) {
                    for (var n = [], i = 0; i < o; i++)
                        n.push(Fn(32).toString(32));
                    return n.join("");
                }
                var eo = Vs,
                    to = {
                        getReceiveURL: function (o, n) {
                            return (
                                o.base +
                                "/" +
                                n +
                                "/xhr_streaming" +
                                o.queryString
                            );
                        },
                        onHeartbeat: function (o) {
                            o.sendRaw("[]");
                        },
                        sendHeartbeat: function (o) {
                            o.sendRaw("[]");
                        },
                        onFinished: function (o, n) {
                            o.onClose(
                                1006,
                                "Connection interrupted (" + n + ")",
                                !1
                            );
                        },
                    },
                    no = to,
                    ro = {
                        getReceiveURL: function (o, n) {
                            return o.base + "/" + n + "/xhr" + o.queryString;
                        },
                        onHeartbeat: function () {},
                        sendHeartbeat: function (o) {
                            o.sendRaw("[]");
                        },
                        onFinished: function (o, n) {
                            n === 200
                                ? o.reconnect()
                                : o.onClose(
                                      1006,
                                      "Connection interrupted (" + n + ")",
                                      !1
                                  );
                        },
                    },
                    so = ro,
                    oo = {
                        getRequest: function (o) {
                            var n = E.getXHRAPI(),
                                i = new n();
                            return (
                                (i.onreadystatechange = i.onprogress =
                                    function () {
                                        switch (i.readyState) {
                                            case 3:
                                                i.responseText &&
                                                    i.responseText.length > 0 &&
                                                    o.onChunk(
                                                        i.status,
                                                        i.responseText
                                                    );
                                                break;
                                            case 4:
                                                i.responseText &&
                                                    i.responseText.length > 0 &&
                                                    o.onChunk(
                                                        i.status,
                                                        i.responseText
                                                    ),
                                                    o.emit(
                                                        "finished",
                                                        i.status
                                                    ),
                                                    o.close();
                                                break;
                                        }
                                    }),
                                i
                            );
                        },
                        abortRequest: function (o) {
                            (o.onreadystatechange = null), o.abort();
                        },
                    },
                    ao = oo,
                    co = {
                        createStreamingSocket(o) {
                            return this.createSocket(no, o);
                        },
                        createPollingSocket(o) {
                            return this.createSocket(so, o);
                        },
                        createSocket(o, n) {
                            return new eo(o, n);
                        },
                        createXHR(o, n) {
                            return this.createRequest(ao, o, n);
                        },
                        createRequest(o, n, i) {
                            return new Ks(o, n, i);
                        },
                    },
                    Un = co;
                Un.createXDR = function (o, n) {
                    return this.createRequest(Ws, o, n);
                };
                var uo = Un,
                    lo = {
                        nextAuthCallbackID: 1,
                        auth_callbacks: {},
                        ScriptReceivers: u,
                        DependenciesReceivers: _,
                        getDefaultStrategy: Us,
                        Transports: bs,
                        transportConnectionInitializer: zs,
                        HTTPFactory: uo,
                        TimelineTransport: ss,
                        getXHRAPI() {
                            return window.XMLHttpRequest;
                        },
                        getWebSocketAPI() {
                            return window.WebSocket || window.MozWebSocket;
                        },
                        setup(o) {
                            window.Pusher = o;
                            var n = () => {
                                this.onDocumentBody(o.ready);
                            };
                            window.JSON ? n() : w.load("json2", {}, n);
                        },
                        getDocument() {
                            return document;
                        },
                        getProtocol() {
                            return this.getDocument().location.protocol;
                        },
                        getAuthorizers() {
                            return { ajax: ee, jsonp: es };
                        },
                        onDocumentBody(o) {
                            document.body
                                ? o()
                                : setTimeout(() => {
                                      this.onDocumentBody(o);
                                  }, 0);
                        },
                        createJSONPRequest(o, n) {
                            return new ns(o, n);
                        },
                        createScriptRequest(o) {
                            return new ts(o);
                        },
                        getLocalStorage() {
                            try {
                                return window.localStorage;
                            } catch {
                                return;
                            }
                        },
                        createXHR() {
                            return this.getXHRAPI()
                                ? this.createXMLHttpRequest()
                                : this.createMicrosoftXHR();
                        },
                        createXMLHttpRequest() {
                            var o = this.getXHRAPI();
                            return new o();
                        },
                        createMicrosoftXHR() {
                            return new ActiveXObject("Microsoft.XMLHTTP");
                        },
                        getNetwork() {
                            return ms;
                        },
                        createWebSocket(o) {
                            var n = this.getWebSocketAPI();
                            return new n(o);
                        },
                        createSocketRequest(o, n) {
                            if (this.isXHRSupported())
                                return this.HTTPFactory.createXHR(o, n);
                            if (this.isXDRSupported(n.indexOf("https:") === 0))
                                return this.HTTPFactory.createXDR(o, n);
                            throw "Cross-origin HTTP requests are not supported";
                        },
                        isXHRSupported() {
                            var o = this.getXHRAPI();
                            return !!o && new o().withCredentials !== void 0;
                        },
                        isXDRSupported(o) {
                            var n = o ? "https:" : "http:",
                                i = this.getProtocol();
                            return !!window.XDomainRequest && i === n;
                        },
                        addUnloadListener(o) {
                            window.addEventListener !== void 0
                                ? window.addEventListener("unload", o, !1)
                                : window.attachEvent !== void 0 &&
                                  window.attachEvent("onunload", o);
                        },
                        removeUnloadListener(o) {
                            window.addEventListener !== void 0
                                ? window.removeEventListener("unload", o, !1)
                                : window.detachEvent !== void 0 &&
                                  window.detachEvent("onunload", o);
                        },
                        randomInt(o) {
                            return Math.floor(
                                (function () {
                                    return (
                                        (
                                            window.crypto || window.msCrypto
                                        ).getRandomValues(
                                            new Uint32Array(1)
                                        )[0] / Math.pow(2, 32)
                                    );
                                })() * o
                            );
                        },
                    },
                    E = lo,
                    Et;
                (function (o) {
                    (o[(o.ERROR = 3)] = "ERROR"),
                        (o[(o.INFO = 6)] = "INFO"),
                        (o[(o.DEBUG = 7)] = "DEBUG");
                })(Et || (Et = {}));
                var Ge = Et;
                class ho {
                    constructor(n, i, l) {
                        (this.key = n),
                            (this.session = i),
                            (this.events = []),
                            (this.options = l || {}),
                            (this.sent = 0),
                            (this.uniqueID = 0);
                    }
                    log(n, i) {
                        n <= this.options.level &&
                            (this.events.push(X({}, i, { timestamp: z.now() })),
                            this.options.limit &&
                                this.events.length > this.options.limit &&
                                this.events.shift());
                    }
                    error(n) {
                        this.log(Ge.ERROR, n);
                    }
                    info(n) {
                        this.log(Ge.INFO, n);
                    }
                    debug(n) {
                        this.log(Ge.DEBUG, n);
                    }
                    isEmpty() {
                        return this.events.length === 0;
                    }
                    send(n, i) {
                        var l = X(
                            {
                                session: this.session,
                                bundle: this.sent + 1,
                                key: this.key,
                                lib: "js",
                                version: this.options.version,
                                cluster: this.options.cluster,
                                features: this.options.features,
                                timeline: this.events,
                            },
                            this.options.params
                        );
                        return (
                            (this.events = []),
                            n(l, (h, g) => {
                                h || this.sent++, i && i(h, g);
                            }),
                            !0
                        );
                    }
                    generateUniqueID() {
                        return this.uniqueID++, this.uniqueID;
                    }
                }
                class fo {
                    constructor(n, i, l, h) {
                        (this.name = n),
                            (this.priority = i),
                            (this.transport = l),
                            (this.options = h || {});
                    }
                    isSupported() {
                        return this.transport.isSupported({
                            useTLS: this.options.useTLS,
                        });
                    }
                    connect(n, i) {
                        if (this.isSupported()) {
                            if (this.priority < n) return zn(new P(), i);
                        } else return zn(new V(), i);
                        var l = !1,
                            h = this.transport.createConnection(
                                this.name,
                                this.priority,
                                this.options.key,
                                this.options
                            ),
                            g = null,
                            b = function () {
                                h.unbind("initialized", b), h.connect();
                            },
                            S = function () {
                                g = ie.createHandshake(h, function (D) {
                                    (l = !0), R(), i(null, D);
                                });
                            },
                            T = function (D) {
                                R(), i(D);
                            },
                            O = function () {
                                R();
                                var D;
                                (D = Ke(h)), i(new I(D));
                            },
                            R = function () {
                                h.unbind("initialized", b),
                                    h.unbind("open", S),
                                    h.unbind("error", T),
                                    h.unbind("closed", O);
                            };
                        return (
                            h.bind("initialized", b),
                            h.bind("open", S),
                            h.bind("error", T),
                            h.bind("closed", O),
                            h.initialize(),
                            {
                                abort: () => {
                                    l || (R(), g ? g.close() : h.close());
                                },
                                forceMinPriority: (D) => {
                                    l ||
                                        (this.priority < D &&
                                            (g ? g.close() : h.close()));
                                },
                            }
                        );
                    }
                }
                function zn(o, n) {
                    return (
                        z.defer(function () {
                            n(o);
                        }),
                        {
                            abort: function () {},
                            forceMinPriority: function () {},
                        }
                    );
                }
                const { Transports: po } = E;
                var go = function (o, n, i, l, h, g) {
                        var b = po[i];
                        if (!b) throw new F(i);
                        var S =
                                (!o.enabledTransports ||
                                    Tn(o.enabledTransports, n) !== -1) &&
                                (!o.disabledTransports ||
                                    Tn(o.disabledTransports, n) === -1),
                            T;
                        return (
                            S
                                ? ((h = Object.assign(
                                      { ignoreNullOrigin: o.ignoreNullOrigin },
                                      h
                                  )),
                                  (T = new fo(
                                      n,
                                      l,
                                      g ? g.getAssistant(b) : b,
                                      h
                                  )))
                                : (T = vo),
                            T
                        );
                    },
                    vo = {
                        isSupported: function () {
                            return !1;
                        },
                        connect: function (o, n) {
                            var i = z.defer(function () {
                                n(new V());
                            });
                            return {
                                abort: function () {
                                    i.ensureAborted();
                                },
                                forceMinPriority: function () {},
                            };
                        },
                    };
                function _o(o) {
                    if (o == null) throw "You must pass an options object";
                    if (o.cluster == null)
                        throw "Options object must provide a cluster";
                    "disableStats" in o &&
                        N.warn(
                            "The disableStats option is deprecated in favor of enableStats"
                        );
                }
                const bo = (o, n) => {
                    var i = "socket_id=" + encodeURIComponent(o.socketId);
                    for (var l in n.params)
                        i +=
                            "&" +
                            encodeURIComponent(l) +
                            "=" +
                            encodeURIComponent(n.params[l]);
                    if (n.paramsProvider != null) {
                        let h = n.paramsProvider();
                        for (var l in h)
                            i +=
                                "&" +
                                encodeURIComponent(l) +
                                "=" +
                                encodeURIComponent(h[l]);
                    }
                    return i;
                };
                var yo = (o) => {
                    if (typeof E.getAuthorizers()[o.transport] > "u")
                        throw `'${o.transport}' is not a recognized auth transport`;
                    return (n, i) => {
                        const l = bo(n, o);
                        E.getAuthorizers()[o.transport](
                            E,
                            l,
                            o,
                            k.UserAuthentication,
                            i
                        );
                    };
                };
                const mo = (o, n) => {
                    var i = "socket_id=" + encodeURIComponent(o.socketId);
                    i += "&channel_name=" + encodeURIComponent(o.channelName);
                    for (var l in n.params)
                        i +=
                            "&" +
                            encodeURIComponent(l) +
                            "=" +
                            encodeURIComponent(n.params[l]);
                    if (n.paramsProvider != null) {
                        let h = n.paramsProvider();
                        for (var l in h)
                            i +=
                                "&" +
                                encodeURIComponent(l) +
                                "=" +
                                encodeURIComponent(h[l]);
                    }
                    return i;
                };
                var wo = (o) => {
                    if (typeof E.getAuthorizers()[o.transport] > "u")
                        throw `'${o.transport}' is not a recognized auth transport`;
                    return (n, i) => {
                        const l = mo(n, o);
                        E.getAuthorizers()[o.transport](
                            E,
                            l,
                            o,
                            k.ChannelAuthorization,
                            i
                        );
                    };
                };
                const xo = (o, n, i) => {
                    const l = {
                        authTransport: n.transport,
                        authEndpoint: n.endpoint,
                        auth: { params: n.params, headers: n.headers },
                    };
                    return (h, g) => {
                        const b = o.channel(h.channelName);
                        i(b, l).authorize(h.socketId, g);
                    };
                };
                function Bn(o, n) {
                    let i = {
                        activityTimeout: o.activityTimeout || d.activityTimeout,
                        cluster: o.cluster,
                        httpPath: o.httpPath || d.httpPath,
                        httpPort: o.httpPort || d.httpPort,
                        httpsPort: o.httpsPort || d.httpsPort,
                        pongTimeout: o.pongTimeout || d.pongTimeout,
                        statsHost: o.statsHost || d.stats_host,
                        unavailableTimeout:
                            o.unavailableTimeout || d.unavailableTimeout,
                        wsPath: o.wsPath || d.wsPath,
                        wsPort: o.wsPort || d.wsPort,
                        wssPort: o.wssPort || d.wssPort,
                        enableStats: Eo(o),
                        httpHost: So(o),
                        useTLS: To(o),
                        wsHost: Co(o),
                        userAuthenticator: Po(o),
                        channelAuthorizer: Oo(o, n),
                    };
                    return (
                        "disabledTransports" in o &&
                            (i.disabledTransports = o.disabledTransports),
                        "enabledTransports" in o &&
                            (i.enabledTransports = o.enabledTransports),
                        "ignoreNullOrigin" in o &&
                            (i.ignoreNullOrigin = o.ignoreNullOrigin),
                        "timelineParams" in o &&
                            (i.timelineParams = o.timelineParams),
                        "nacl" in o && (i.nacl = o.nacl),
                        i
                    );
                }
                function So(o) {
                    return o.httpHost
                        ? o.httpHost
                        : o.cluster
                        ? `sockjs-${o.cluster}.pusher.com`
                        : d.httpHost;
                }
                function Co(o) {
                    return o.wsHost ? o.wsHost : ko(o.cluster);
                }
                function ko(o) {
                    return `ws-${o}.pusher.com`;
                }
                function To(o) {
                    return E.getProtocol() === "https:"
                        ? !0
                        : o.forceTLS !== !1;
                }
                function Eo(o) {
                    return "enableStats" in o
                        ? o.enableStats
                        : "disableStats" in o
                        ? !o.disableStats
                        : !1;
                }
                const Wn = (o) =>
                    "customHandler" in o && o.customHandler != null;
                function Po(o) {
                    const n = Object.assign(
                        Object.assign({}, d.userAuthentication),
                        o.userAuthentication
                    );
                    return Wn(n) ? n.customHandler : yo(n);
                }
                function Ao(o, n) {
                    let i;
                    if ("channelAuthorization" in o)
                        i = Object.assign(
                            Object.assign({}, d.channelAuthorization),
                            o.channelAuthorization
                        );
                    else if (
                        ((i = {
                            transport: o.authTransport || d.authTransport,
                            endpoint: o.authEndpoint || d.authEndpoint,
                        }),
                        "auth" in o &&
                            ("params" in o.auth && (i.params = o.auth.params),
                            "headers" in o.auth &&
                                (i.headers = o.auth.headers)),
                        "authorizer" in o)
                    )
                        return { customHandler: xo(n, i, o.authorizer) };
                    return i;
                }
                function Oo(o, n) {
                    const i = Ao(o, n);
                    return Wn(i) ? i.customHandler : wo(i);
                }
                class Io extends re {
                    constructor(n) {
                        super(function (i, l) {
                            N.debug(
                                `No callbacks on watchlist events for ${i}`
                            );
                        }),
                            (this.pusher = n),
                            this.bindWatchlistInternalEvent();
                    }
                    handleEvent(n) {
                        n.data.events.forEach((i) => {
                            this.emit(i.name, i);
                        });
                    }
                    bindWatchlistInternalEvent() {
                        this.pusher.connection.bind("message", (n) => {
                            var i = n.event;
                            i === "pusher_internal:watchlist_events" &&
                                this.handleEvent(n);
                        });
                    }
                }
                function Ro() {
                    let o, n;
                    return {
                        promise: new Promise((l, h) => {
                            (o = l), (n = h);
                        }),
                        resolve: o,
                        reject: n,
                    };
                }
                var Lo = Ro;
                class jo extends re {
                    constructor(n) {
                        super(function (i, l) {
                            N.debug("No callbacks on user for " + i);
                        }),
                            (this.signin_requested = !1),
                            (this.user_data = null),
                            (this.serverToUserChannel = null),
                            (this.signinDonePromise = null),
                            (this._signinDoneResolve = null),
                            (this._onAuthorize = (i, l) => {
                                if (i) {
                                    N.warn(`Error during signin: ${i}`),
                                        this._cleanup();
                                    return;
                                }
                                this.pusher.send_event("pusher:signin", {
                                    auth: l.auth,
                                    user_data: l.user_data,
                                });
                            }),
                            (this.pusher = n),
                            this.pusher.connection.bind(
                                "state_change",
                                ({ previous: i, current: l }) => {
                                    i !== "connected" &&
                                        l === "connected" &&
                                        this._signin(),
                                        i === "connected" &&
                                            l !== "connected" &&
                                            (this._cleanup(),
                                            this._newSigninPromiseIfNeeded());
                                }
                            ),
                            (this.watchlist = new Io(n)),
                            this.pusher.connection.bind("message", (i) => {
                                var l = i.event;
                                l === "pusher:signin_success" &&
                                    this._onSigninSuccess(i.data),
                                    this.serverToUserChannel &&
                                        this.serverToUserChannel.name ===
                                            i.channel &&
                                        this.serverToUserChannel.handleEvent(i);
                            });
                    }
                    signin() {
                        this.signin_requested ||
                            ((this.signin_requested = !0), this._signin());
                    }
                    _signin() {
                        this.signin_requested &&
                            (this._newSigninPromiseIfNeeded(),
                            this.pusher.connection.state === "connected" &&
                                this.pusher.config.userAuthenticator(
                                    {
                                        socketId:
                                            this.pusher.connection.socket_id,
                                    },
                                    this._onAuthorize
                                ));
                    }
                    _onSigninSuccess(n) {
                        try {
                            this.user_data = JSON.parse(n.user_data);
                        } catch {
                            N.error(
                                `Failed parsing user data after signin: ${n.user_data}`
                            ),
                                this._cleanup();
                            return;
                        }
                        if (
                            typeof this.user_data.id != "string" ||
                            this.user_data.id === ""
                        ) {
                            N.error(
                                `user_data doesn't contain an id. user_data: ${this.user_data}`
                            ),
                                this._cleanup();
                            return;
                        }
                        this._signinDoneResolve(), this._subscribeChannels();
                    }
                    _subscribeChannels() {
                        const n = (i) => {
                            i.subscriptionPending && i.subscriptionCancelled
                                ? i.reinstateSubscription()
                                : !i.subscriptionPending &&
                                  this.pusher.connection.state ===
                                      "connected" &&
                                  i.subscribe();
                        };
                        (this.serverToUserChannel = new wt(
                            `#server-to-user-${this.user_data.id}`,
                            this.pusher
                        )),
                            this.serverToUserChannel.bind_global((i, l) => {
                                i.indexOf("pusher_internal:") === 0 ||
                                    i.indexOf("pusher:") === 0 ||
                                    this.emit(i, l);
                            }),
                            n(this.serverToUserChannel);
                    }
                    _cleanup() {
                        (this.user_data = null),
                            this.serverToUserChannel &&
                                (this.serverToUserChannel.unbind_all(),
                                this.serverToUserChannel.disconnect(),
                                (this.serverToUserChannel = null)),
                            this.signin_requested && this._signinDoneResolve();
                    }
                    _newSigninPromiseIfNeeded() {
                        if (
                            !this.signin_requested ||
                            (this.signinDonePromise &&
                                !this.signinDonePromise.done)
                        )
                            return;
                        const { promise: n, resolve: i, reject: l } = Lo();
                        n.done = !1;
                        const h = () => {
                            n.done = !0;
                        };
                        n.then(h).catch(h),
                            (this.signinDonePromise = n),
                            (this._signinDoneResolve = i);
                    }
                }
                class U {
                    static ready() {
                        U.isReady = !0;
                        for (var n = 0, i = U.instances.length; n < i; n++)
                            U.instances[n].connect();
                    }
                    static getClientFeatures() {
                        return En(
                            On({ ws: E.Transports.ws }, function (n) {
                                return n.isSupported({});
                            })
                        );
                    }
                    constructor(n, i) {
                        No(n),
                            _o(i),
                            (this.key = n),
                            (this.options = i),
                            (this.config = Bn(this.options, this)),
                            (this.channels = ie.createChannels()),
                            (this.global_emitter = new re()),
                            (this.sessionID = E.randomInt(1e9)),
                            (this.timeline = new ho(this.key, this.sessionID, {
                                cluster: this.config.cluster,
                                features: U.getClientFeatures(),
                                params: this.config.timelineParams || {},
                                limit: 50,
                                level: Ge.INFO,
                                version: d.VERSION,
                            })),
                            this.config.enableStats &&
                                (this.timelineSender = ie.createTimelineSender(
                                    this.timeline,
                                    {
                                        host: this.config.statsHost,
                                        path:
                                            "/timeline/v2/" +
                                            E.TimelineTransport.name,
                                    }
                                ));
                        var l = (h) => E.getDefaultStrategy(this.config, h, go);
                        (this.connection = ie.createConnectionManager(
                            this.key,
                            {
                                getStrategy: l,
                                timeline: this.timeline,
                                activityTimeout: this.config.activityTimeout,
                                pongTimeout: this.config.pongTimeout,
                                unavailableTimeout:
                                    this.config.unavailableTimeout,
                                useTLS: !!this.config.useTLS,
                            }
                        )),
                            this.connection.bind("connected", () => {
                                this.subscribeAll(),
                                    this.timelineSender &&
                                        this.timelineSender.send(
                                            this.connection.isUsingTLS()
                                        );
                            }),
                            this.connection.bind("message", (h) => {
                                var g = h.event,
                                    b = g.indexOf("pusher_internal:") === 0;
                                if (h.channel) {
                                    var S = this.channel(h.channel);
                                    S && S.handleEvent(h);
                                }
                                b || this.global_emitter.emit(h.event, h.data);
                            }),
                            this.connection.bind("connecting", () => {
                                this.channels.disconnect();
                            }),
                            this.connection.bind("disconnected", () => {
                                this.channels.disconnect();
                            }),
                            this.connection.bind("error", (h) => {
                                N.warn(h);
                            }),
                            U.instances.push(this),
                            this.timeline.info({
                                instances: U.instances.length,
                            }),
                            (this.user = new jo(this)),
                            U.isReady && this.connect();
                    }
                    switchCluster(n) {
                        const { appKey: i, cluster: l } = n;
                        (this.key = i),
                            (this.options = Object.assign(
                                Object.assign({}, this.options),
                                { cluster: l }
                            )),
                            (this.config = Bn(this.options, this)),
                            this.connection.switchCluster(this.key);
                    }
                    channel(n) {
                        return this.channels.find(n);
                    }
                    allChannels() {
                        return this.channels.all();
                    }
                    connect() {
                        if (
                            (this.connection.connect(),
                            this.timelineSender && !this.timelineSenderTimer)
                        ) {
                            var n = this.connection.isUsingTLS(),
                                i = this.timelineSender;
                            this.timelineSenderTimer = new Ui(6e4, function () {
                                i.send(n);
                            });
                        }
                    }
                    disconnect() {
                        this.connection.disconnect(),
                            this.timelineSenderTimer &&
                                (this.timelineSenderTimer.ensureAborted(),
                                (this.timelineSenderTimer = null));
                    }
                    bind(n, i, l) {
                        return this.global_emitter.bind(n, i, l), this;
                    }
                    unbind(n, i, l) {
                        return this.global_emitter.unbind(n, i, l), this;
                    }
                    bind_global(n) {
                        return this.global_emitter.bind_global(n), this;
                    }
                    unbind_global(n) {
                        return this.global_emitter.unbind_global(n), this;
                    }
                    unbind_all(n) {
                        return this.global_emitter.unbind_all(), this;
                    }
                    subscribeAll() {
                        var n;
                        for (n in this.channels.channels)
                            this.channels.channels.hasOwnProperty(n) &&
                                this.subscribe(n);
                    }
                    subscribe(n) {
                        var i = this.channels.add(n, this);
                        return (
                            i.subscriptionPending && i.subscriptionCancelled
                                ? i.reinstateSubscription()
                                : !i.subscriptionPending &&
                                  this.connection.state === "connected" &&
                                  i.subscribe(),
                            i
                        );
                    }
                    unsubscribe(n) {
                        var i = this.channels.find(n);
                        i && i.subscriptionPending
                            ? i.cancelSubscription()
                            : ((i = this.channels.remove(n)),
                              i && i.subscribed && i.unsubscribe());
                    }
                    send_event(n, i, l) {
                        return this.connection.send_event(n, i, l);
                    }
                    shouldUseTLS() {
                        return this.config.useTLS;
                    }
                    signin() {
                        this.user.signin();
                    }
                }
                (U.instances = []),
                    (U.isReady = !1),
                    (U.logToConsole = !1),
                    (U.Runtime = E),
                    (U.ScriptReceivers = E.ScriptReceivers),
                    (U.DependenciesReceivers = E.DependenciesReceivers),
                    (U.auth_callbacks = E.auth_callbacks);
                var Pt = (s.default = U);
                function No(o) {
                    if (o == null)
                        throw "You must pass your app key when you instantiate Pusher.";
                }
                E.setup(U);
            },
        ]);
    });
})(wr);
var ia = wr.exports;
const sa = ra(ia);
window.Pusher = sa;
window.Echo = new na({
    broadcaster: "pusher",
    key: "adadb8e8c491818d6a8f",
    cluster: "eu",
    forceTLS: !0,
});
var Dt = !1,
    qt = !1,
    ve = [],
    Ht = -1;
function oa(e) {
    aa(e);
}
function aa(e) {
    ve.includes(e) || ve.push(e), ua();
}
function ca(e) {
    let t = ve.indexOf(e);
    t !== -1 && t > Ht && ve.splice(t, 1);
}
function ua() {
    !qt && !Dt && ((Dt = !0), queueMicrotask(la));
}
function la() {
    (Dt = !1), (qt = !0);
    for (let e = 0; e < ve.length; e++) ve[e](), (Ht = e);
    (ve.length = 0), (Ht = -1), (qt = !1);
}
var ke,
    we,
    Te,
    xr,
    $t = !0;
function ha(e) {
    ($t = !1), e(), ($t = !0);
}
function fa(e) {
    (ke = e.reactive),
        (Te = e.release),
        (we = (t) =>
            e.effect(t, {
                scheduler: (r) => {
                    $t ? oa(r) : r();
                },
            })),
        (xr = e.raw);
}
function nr(e) {
    we = e;
}
function da(e) {
    let t = () => {};
    return [
        (s) => {
            let a = we(s);
            return (
                e._x_effects ||
                    ((e._x_effects = new Set()),
                    (e._x_runEffects = () => {
                        e._x_effects.forEach((c) => c());
                    })),
                e._x_effects.add(a),
                (t = () => {
                    a !== void 0 && (e._x_effects.delete(a), Te(a));
                }),
                a
            );
        },
        () => {
            t();
        },
    ];
}
function Sr(e, t) {
    let r = !0,
        s,
        a = we(() => {
            let c = e();
            JSON.stringify(c),
                r
                    ? (s = c)
                    : queueMicrotask(() => {
                          t(c, s), (s = c);
                      }),
                (r = !1);
        });
    return () => Te(a);
}
var Cr = [],
    kr = [],
    Tr = [];
function pa(e) {
    Tr.push(e);
}
function rn(e, t) {
    typeof t == "function"
        ? (e._x_cleanups || (e._x_cleanups = []), e._x_cleanups.push(t))
        : ((t = e), kr.push(t));
}
function Er(e) {
    Cr.push(e);
}
function Pr(e, t, r) {
    e._x_attributeCleanups || (e._x_attributeCleanups = {}),
        e._x_attributeCleanups[t] || (e._x_attributeCleanups[t] = []),
        e._x_attributeCleanups[t].push(r);
}
function Ar(e, t) {
    e._x_attributeCleanups &&
        Object.entries(e._x_attributeCleanups).forEach(([r, s]) => {
            (t === void 0 || t.includes(r)) &&
                (s.forEach((a) => a()), delete e._x_attributeCleanups[r]);
        });
}
function ga(e) {
    var t, r;
    for (
        (t = e._x_effects) == null || t.forEach(ca);
        (r = e._x_cleanups) != null && r.length;

    )
        e._x_cleanups.pop()();
}
var sn = new MutationObserver(un),
    on = !1;
function an() {
    sn.observe(document, {
        subtree: !0,
        childList: !0,
        attributes: !0,
        attributeOldValue: !0,
    }),
        (on = !0);
}
function Or() {
    va(), sn.disconnect(), (on = !1);
}
var je = [];
function va() {
    let e = sn.takeRecords();
    je.push(() => e.length > 0 && un(e));
    let t = je.length;
    queueMicrotask(() => {
        if (je.length === t) for (; je.length > 0; ) je.shift()();
    });
}
function M(e) {
    if (!on) return e();
    Or();
    let t = e();
    return an(), t;
}
var cn = !1,
    at = [];
function _a() {
    cn = !0;
}
function ba() {
    (cn = !1), un(at), (at = []);
}
function un(e) {
    if (cn) {
        at = at.concat(e);
        return;
    }
    let t = [],
        r = new Set(),
        s = new Map(),
        a = new Map();
    for (let c = 0; c < e.length; c++)
        if (
            !e[c].target._x_ignoreMutationObserver &&
            (e[c].type === "childList" &&
                (e[c].removedNodes.forEach((u) => {
                    u.nodeType === 1 && u._x_marker && r.add(u);
                }),
                e[c].addedNodes.forEach((u) => {
                    if (u.nodeType === 1) {
                        if (r.has(u)) {
                            r.delete(u);
                            return;
                        }
                        u._x_marker || t.push(u);
                    }
                })),
            e[c].type === "attributes")
        ) {
            let u = e[c].target,
                f = e[c].attributeName,
                d = e[c].oldValue,
                y = () => {
                    s.has(u) || s.set(u, []),
                        s.get(u).push({ name: f, value: u.getAttribute(f) });
                },
                _ = () => {
                    a.has(u) || a.set(u, []), a.get(u).push(f);
                };
            u.hasAttribute(f) && d === null
                ? y()
                : u.hasAttribute(f)
                ? (_(), y())
                : _();
        }
    a.forEach((c, u) => {
        Ar(u, c);
    }),
        s.forEach((c, u) => {
            Cr.forEach((f) => f(u, c));
        });
    for (let c of r) t.some((u) => u.contains(c)) || kr.forEach((u) => u(c));
    for (let c of t) c.isConnected && Tr.forEach((u) => u(c));
    (t = null), (r = null), (s = null), (a = null);
}
function Ir(e) {
    return Be(Se(e));
}
function ze(e, t, r) {
    return (
        (e._x_dataStack = [t, ...Se(r || e)]),
        () => {
            e._x_dataStack = e._x_dataStack.filter((s) => s !== t);
        }
    );
}
function Se(e) {
    return e._x_dataStack
        ? e._x_dataStack
        : typeof ShadowRoot == "function" && e instanceof ShadowRoot
        ? Se(e.host)
        : e.parentNode
        ? Se(e.parentNode)
        : [];
}
function Be(e) {
    return new Proxy({ objects: e }, ya);
}
var ya = {
    ownKeys({ objects: e }) {
        return Array.from(new Set(e.flatMap((t) => Object.keys(t))));
    },
    has({ objects: e }, t) {
        return t == Symbol.unscopables
            ? !1
            : e.some(
                  (r) =>
                      Object.prototype.hasOwnProperty.call(r, t) ||
                      Reflect.has(r, t)
              );
    },
    get({ objects: e }, t, r) {
        return t == "toJSON"
            ? ma
            : Reflect.get(e.find((s) => Reflect.has(s, t)) || {}, t, r);
    },
    set({ objects: e }, t, r, s) {
        const a =
                e.find((u) => Object.prototype.hasOwnProperty.call(u, t)) ||
                e[e.length - 1],
            c = Object.getOwnPropertyDescriptor(a, t);
        return c != null && c.set && c != null && c.get
            ? c.set.call(s, r) || !0
            : Reflect.set(a, t, r);
    },
};
function ma() {
    return Reflect.ownKeys(this).reduce(
        (t, r) => ((t[r] = Reflect.get(this, r)), t),
        {}
    );
}
function Rr(e) {
    let t = (s) => typeof s == "object" && !Array.isArray(s) && s !== null,
        r = (s, a = "") => {
            Object.entries(Object.getOwnPropertyDescriptors(s)).forEach(
                ([c, { value: u, enumerable: f }]) => {
                    if (
                        f === !1 ||
                        u === void 0 ||
                        (typeof u == "object" && u !== null && u.__v_skip)
                    )
                        return;
                    let d = a === "" ? c : `${a}.${c}`;
                    typeof u == "object" && u !== null && u._x_interceptor
                        ? (s[c] = u.initialize(e, d, c))
                        : t(u) && u !== s && !(u instanceof Element) && r(u, d);
                }
            );
        };
    return r(e);
}
function Lr(e, t = () => {}) {
    let r = {
        initialValue: void 0,
        _x_interceptor: !0,
        initialize(s, a, c) {
            return e(
                this.initialValue,
                () => wa(s, a),
                (u) => Ft(s, a, u),
                a,
                c
            );
        },
    };
    return (
        t(r),
        (s) => {
            if (typeof s == "object" && s !== null && s._x_interceptor) {
                let a = r.initialize.bind(r);
                r.initialize = (c, u, f) => {
                    let d = s.initialize(c, u, f);
                    return (r.initialValue = d), a(c, u, f);
                };
            } else r.initialValue = s;
            return r;
        }
    );
}
function wa(e, t) {
    return t.split(".").reduce((r, s) => r[s], e);
}
function Ft(e, t, r) {
    if ((typeof t == "string" && (t = t.split(".")), t.length === 1))
        e[t[0]] = r;
    else {
        if (t.length === 0) throw error;
        return e[t[0]] || (e[t[0]] = {}), Ft(e[t[0]], t.slice(1), r);
    }
}
var jr = {};
function Z(e, t) {
    jr[e] = t;
}
function Ut(e, t) {
    let r = xa(t);
    return (
        Object.entries(jr).forEach(([s, a]) => {
            Object.defineProperty(e, `$${s}`, {
                get() {
                    return a(t, r);
                },
                enumerable: !1,
            });
        }),
        e
    );
}
function xa(e) {
    let [t, r] = $r(e),
        s = { interceptor: Lr, ...t };
    return rn(e, r), s;
}
function Sa(e, t, r, ...s) {
    try {
        return r(...s);
    } catch (a) {
        Ue(a, e, t);
    }
}
function Ue(e, t, r = void 0) {
    (e = Object.assign(e ?? { message: "No error message given." }, {
        el: t,
        expression: r,
    })),
        console.warn(
            `Alpine Expression Error: ${e.message}

${
    r
        ? 'Expression: "' +
          r +
          `"

`
        : ""
}`,
            t
        ),
        setTimeout(() => {
            throw e;
        }, 0);
}
var rt = !0;
function Nr(e) {
    let t = rt;
    rt = !1;
    let r = e();
    return (rt = t), r;
}
function _e(e, t, r = {}) {
    let s;
    return B(e, t)((a) => (s = a), r), s;
}
function B(...e) {
    return Mr(...e);
}
var Mr = Dr;
function Ca(e) {
    Mr = e;
}
function Dr(e, t) {
    let r = {};
    Ut(r, e);
    let s = [r, ...Se(e)],
        a = typeof t == "function" ? ka(s, t) : Ea(s, t, e);
    return Sa.bind(null, e, t, a);
}
function ka(e, t) {
    return (r = () => {}, { scope: s = {}, params: a = [] } = {}) => {
        let c = t.apply(Be([s, ...e]), a);
        ct(r, c);
    };
}
var It = {};
function Ta(e, t) {
    if (It[e]) return It[e];
    let r = Object.getPrototypeOf(async function () {}).constructor,
        s =
            /^[\n\s]*if.*\(.*\)/.test(e.trim()) ||
            /^(let|const)\s/.test(e.trim())
                ? `(async()=>{ ${e} })()`
                : e,
        c = (() => {
            try {
                let u = new r(
                    ["__self", "scope"],
                    `with (scope) { __self.result = ${s} }; __self.finished = true; return __self.result;`
                );
                return (
                    Object.defineProperty(u, "name", {
                        value: `[Alpine] ${e}`,
                    }),
                    u
                );
            } catch (u) {
                return Ue(u, t, e), Promise.resolve();
            }
        })();
    return (It[e] = c), c;
}
function Ea(e, t, r) {
    let s = Ta(t, r);
    return (a = () => {}, { scope: c = {}, params: u = [] } = {}) => {
        (s.result = void 0), (s.finished = !1);
        let f = Be([c, ...e]);
        if (typeof s == "function") {
            let d = s(s, f).catch((y) => Ue(y, r, t));
            s.finished
                ? (ct(a, s.result, f, u, r), (s.result = void 0))
                : d
                      .then((y) => {
                          ct(a, y, f, u, r);
                      })
                      .catch((y) => Ue(y, r, t))
                      .finally(() => (s.result = void 0));
        }
    };
}
function ct(e, t, r, s, a) {
    if (rt && typeof t == "function") {
        let c = t.apply(r, s);
        c instanceof Promise
            ? c.then((u) => ct(e, u, r, s)).catch((u) => Ue(u, a, t))
            : e(c);
    } else
        typeof t == "object" && t instanceof Promise
            ? t.then((c) => e(c))
            : e(t);
}
var ln = "x-";
function Ee(e = "") {
    return ln + e;
}
function Pa(e) {
    ln = e;
}
var ut = {};
function q(e, t) {
    return (
        (ut[e] = t),
        {
            before(r) {
                if (!ut[r]) {
                    console.warn(
                        String.raw`Cannot find directive \`${r}\`. \`${e}\` will use the default order of execution`
                    );
                    return;
                }
                const s = ge.indexOf(r);
                ge.splice(s >= 0 ? s : ge.indexOf("DEFAULT"), 0, e);
            },
        }
    );
}
function Aa(e) {
    return Object.keys(ut).includes(e);
}
function hn(e, t, r) {
    if (((t = Array.from(t)), e._x_virtualDirectives)) {
        let c = Object.entries(e._x_virtualDirectives).map(([f, d]) => ({
                name: f,
                value: d,
            })),
            u = qr(c);
        (c = c.map((f) =>
            u.find((d) => d.name === f.name)
                ? { name: `x-bind:${f.name}`, value: `"${f.value}"` }
                : f
        )),
            (t = t.concat(c));
    }
    let s = {};
    return t
        .map(zr((c, u) => (s[c] = u)))
        .filter(Wr)
        .map(Ra(s, r))
        .sort(La)
        .map((c) => Ia(e, c));
}
function qr(e) {
    return Array.from(e)
        .map(zr())
        .filter((t) => !Wr(t));
}
var zt = !1,
    De = new Map(),
    Hr = Symbol();
function Oa(e) {
    zt = !0;
    let t = Symbol();
    (Hr = t), De.set(t, []);
    let r = () => {
            for (; De.get(t).length; ) De.get(t).shift()();
            De.delete(t);
        },
        s = () => {
            (zt = !1), r();
        };
    e(r), s();
}
function $r(e) {
    let t = [],
        r = (f) => t.push(f),
        [s, a] = da(e);
    return (
        t.push(a),
        [
            {
                Alpine: We,
                effect: s,
                cleanup: r,
                evaluateLater: B.bind(B, e),
                evaluate: _e.bind(_e, e),
            },
            () => t.forEach((f) => f()),
        ]
    );
}
function Ia(e, t) {
    let r = () => {},
        s = ut[t.type] || r,
        [a, c] = $r(e);
    Pr(e, t.original, c);
    let u = () => {
        e._x_ignore ||
            e._x_ignoreSelf ||
            (s.inline && s.inline(e, t, a),
            (s = s.bind(s, e, t, a)),
            zt ? De.get(Hr).push(s) : s());
    };
    return (u.runCleanups = c), u;
}
var Fr =
        (e, t) =>
        ({ name: r, value: s }) => (
            r.startsWith(e) && (r = r.replace(e, t)), { name: r, value: s }
        ),
    Ur = (e) => e;
function zr(e = () => {}) {
    return ({ name: t, value: r }) => {
        let { name: s, value: a } = Br.reduce((c, u) => u(c), {
            name: t,
            value: r,
        });
        return s !== t && e(s, t), { name: s, value: a };
    };
}
var Br = [];
function fn(e) {
    Br.push(e);
}
function Wr({ name: e }) {
    return Xr().test(e);
}
var Xr = () => new RegExp(`^${ln}([^:^.]+)\\b`);
function Ra(e, t) {
    return ({ name: r, value: s }) => {
        let a = r.match(Xr()),
            c = r.match(/:([a-zA-Z0-9\-_:]+)/),
            u = r.match(/\.[^.\]]+(?=[^\]]*$)/g) || [],
            f = t || e[r] || r;
        return {
            type: a ? a[1] : null,
            value: c ? c[1] : null,
            modifiers: u.map((d) => d.replace(".", "")),
            expression: s,
            original: f,
        };
    };
}
var Bt = "DEFAULT",
    ge = [
        "ignore",
        "ref",
        "data",
        "id",
        "anchor",
        "bind",
        "init",
        "for",
        "model",
        "modelable",
        "transition",
        "show",
        "if",
        Bt,
        "teleport",
    ];
function La(e, t) {
    let r = ge.indexOf(e.type) === -1 ? Bt : e.type,
        s = ge.indexOf(t.type) === -1 ? Bt : t.type;
    return ge.indexOf(r) - ge.indexOf(s);
}
function He(e, t, r = {}) {
    e.dispatchEvent(
        new CustomEvent(t, {
            detail: r,
            bubbles: !0,
            composed: !0,
            cancelable: !0,
        })
    );
}
function me(e, t) {
    if (typeof ShadowRoot == "function" && e instanceof ShadowRoot) {
        Array.from(e.children).forEach((a) => me(a, t));
        return;
    }
    let r = !1;
    if ((t(e, () => (r = !0)), r)) return;
    let s = e.firstElementChild;
    for (; s; ) me(s, t), (s = s.nextElementSibling);
}
function G(e, ...t) {
    console.warn(`Alpine Warning: ${e}`, ...t);
}
var rr = !1;
function ja() {
    rr &&
        G(
            "Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems."
        ),
        (rr = !0),
        document.body ||
            G(
                "Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?"
            ),
        He(document, "alpine:init"),
        He(document, "alpine:initializing"),
        an(),
        pa((t) => se(t, me)),
        rn((t) => Ae(t)),
        Er((t, r) => {
            hn(t, r).forEach((s) => s());
        });
    let e = (t) => !ht(t.parentElement, !0);
    Array.from(document.querySelectorAll(Vr().join(",")))
        .filter(e)
        .forEach((t) => {
            se(t);
        }),
        He(document, "alpine:initialized"),
        setTimeout(() => {
            qa();
        });
}
var dn = [],
    Kr = [];
function Jr() {
    return dn.map((e) => e());
}
function Vr() {
    return dn.concat(Kr).map((e) => e());
}
function Gr(e) {
    dn.push(e);
}
function Qr(e) {
    Kr.push(e);
}
function ht(e, t = !1) {
    return Pe(e, (r) => {
        if ((t ? Vr() : Jr()).some((a) => r.matches(a))) return !0;
    });
}
function Pe(e, t) {
    if (e) {
        if (t(e)) return e;
        if ((e._x_teleportBack && (e = e._x_teleportBack), !!e.parentElement))
            return Pe(e.parentElement, t);
    }
}
function Na(e) {
    return Jr().some((t) => e.matches(t));
}
var Yr = [];
function Ma(e) {
    Yr.push(e);
}
var Da = 1;
function se(e, t = me, r = () => {}) {
    Pe(e, (s) => s._x_ignore) ||
        Oa(() => {
            t(e, (s, a) => {
                s._x_marker ||
                    (r(s, a),
                    Yr.forEach((c) => c(s, a)),
                    hn(s, s.attributes).forEach((c) => c()),
                    s._x_ignore || (s._x_marker = Da++),
                    s._x_ignore && a());
            });
        });
}
function Ae(e, t = me) {
    t(e, (r) => {
        ga(r), Ar(r), delete r._x_marker;
    });
}
function qa() {
    [
        ["ui", "dialog", ["[x-dialog], [x-popover]"]],
        ["anchor", "anchor", ["[x-anchor]"]],
        ["sort", "sort", ["[x-sort]"]],
    ].forEach(([t, r, s]) => {
        Aa(r) ||
            s.some((a) => {
                if (document.querySelector(a))
                    return G(`found "${a}", but missing ${t} plugin`), !0;
            });
    });
}
var Wt = [],
    pn = !1;
function gn(e = () => {}) {
    return (
        queueMicrotask(() => {
            pn ||
                setTimeout(() => {
                    Xt();
                });
        }),
        new Promise((t) => {
            Wt.push(() => {
                e(), t();
            });
        })
    );
}
function Xt() {
    for (pn = !1; Wt.length; ) Wt.shift()();
}
function Ha() {
    pn = !0;
}
function vn(e, t) {
    return Array.isArray(t)
        ? ir(e, t.join(" "))
        : typeof t == "object" && t !== null
        ? $a(e, t)
        : typeof t == "function"
        ? vn(e, t())
        : ir(e, t);
}
function ir(e, t) {
    let r = (a) =>
            a
                .split(" ")
                .filter((c) => !e.classList.contains(c))
                .filter(Boolean),
        s = (a) => (
            e.classList.add(...a),
            () => {
                e.classList.remove(...a);
            }
        );
    return (t = t === !0 ? (t = "") : t || ""), s(r(t));
}
function $a(e, t) {
    let r = (f) => f.split(" ").filter(Boolean),
        s = Object.entries(t)
            .flatMap(([f, d]) => (d ? r(f) : !1))
            .filter(Boolean),
        a = Object.entries(t)
            .flatMap(([f, d]) => (d ? !1 : r(f)))
            .filter(Boolean),
        c = [],
        u = [];
    return (
        a.forEach((f) => {
            e.classList.contains(f) && (e.classList.remove(f), u.push(f));
        }),
        s.forEach((f) => {
            e.classList.contains(f) || (e.classList.add(f), c.push(f));
        }),
        () => {
            u.forEach((f) => e.classList.add(f)),
                c.forEach((f) => e.classList.remove(f));
        }
    );
}
function ft(e, t) {
    return typeof t == "object" && t !== null ? Fa(e, t) : Ua(e, t);
}
function Fa(e, t) {
    let r = {};
    return (
        Object.entries(t).forEach(([s, a]) => {
            (r[s] = e.style[s]),
                s.startsWith("--") || (s = za(s)),
                e.style.setProperty(s, a);
        }),
        setTimeout(() => {
            e.style.length === 0 && e.removeAttribute("style");
        }),
        () => {
            ft(e, r);
        }
    );
}
function Ua(e, t) {
    let r = e.getAttribute("style", t);
    return (
        e.setAttribute("style", t),
        () => {
            e.setAttribute("style", r || "");
        }
    );
}
function za(e) {
    return e.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
}
function Kt(e, t = () => {}) {
    let r = !1;
    return function () {
        r ? t.apply(this, arguments) : ((r = !0), e.apply(this, arguments));
    };
}
q(
    "transition",
    (e, { value: t, modifiers: r, expression: s }, { evaluate: a }) => {
        typeof s == "function" && (s = a(s)),
            s !== !1 &&
                (!s || typeof s == "boolean" ? Wa(e, r, t) : Ba(e, s, t));
    }
);
function Ba(e, t, r) {
    Zr(e, vn, ""),
        {
            enter: (a) => {
                e._x_transition.enter.during = a;
            },
            "enter-start": (a) => {
                e._x_transition.enter.start = a;
            },
            "enter-end": (a) => {
                e._x_transition.enter.end = a;
            },
            leave: (a) => {
                e._x_transition.leave.during = a;
            },
            "leave-start": (a) => {
                e._x_transition.leave.start = a;
            },
            "leave-end": (a) => {
                e._x_transition.leave.end = a;
            },
        }[r](t);
}
function Wa(e, t, r) {
    Zr(e, ft);
    let s = !t.includes("in") && !t.includes("out") && !r,
        a = s || t.includes("in") || ["enter"].includes(r),
        c = s || t.includes("out") || ["leave"].includes(r);
    t.includes("in") && !s && (t = t.filter((v, x) => x < t.indexOf("out"))),
        t.includes("out") &&
            !s &&
            (t = t.filter((v, x) => x > t.indexOf("out")));
    let u = !t.includes("opacity") && !t.includes("scale"),
        f = u || t.includes("opacity"),
        d = u || t.includes("scale"),
        y = f ? 0 : 1,
        _ = d ? Ne(t, "scale", 95) / 100 : 1,
        w = Ne(t, "delay", 0) / 1e3,
        m = Ne(t, "origin", "center"),
        C = "opacity, transform",
        A = Ne(t, "duration", 150) / 1e3,
        k = Ne(t, "duration", 75) / 1e3,
        p = "cubic-bezier(0.4, 0.0, 0.2, 1)";
    a &&
        ((e._x_transition.enter.during = {
            transformOrigin: m,
            transitionDelay: `${w}s`,
            transitionProperty: C,
            transitionDuration: `${A}s`,
            transitionTimingFunction: p,
        }),
        (e._x_transition.enter.start = {
            opacity: y,
            transform: `scale(${_})`,
        }),
        (e._x_transition.enter.end = { opacity: 1, transform: "scale(1)" })),
        c &&
            ((e._x_transition.leave.during = {
                transformOrigin: m,
                transitionDelay: `${w}s`,
                transitionProperty: C,
                transitionDuration: `${k}s`,
                transitionTimingFunction: p,
            }),
            (e._x_transition.leave.start = {
                opacity: 1,
                transform: "scale(1)",
            }),
            (e._x_transition.leave.end = {
                opacity: y,
                transform: `scale(${_})`,
            }));
}
function Zr(e, t, r = {}) {
    e._x_transition ||
        (e._x_transition = {
            enter: { during: r, start: r, end: r },
            leave: { during: r, start: r, end: r },
            in(s = () => {}, a = () => {}) {
                Jt(
                    e,
                    t,
                    {
                        during: this.enter.during,
                        start: this.enter.start,
                        end: this.enter.end,
                    },
                    s,
                    a
                );
            },
            out(s = () => {}, a = () => {}) {
                Jt(
                    e,
                    t,
                    {
                        during: this.leave.during,
                        start: this.leave.start,
                        end: this.leave.end,
                    },
                    s,
                    a
                );
            },
        });
}
window.Element.prototype._x_toggleAndCascadeWithTransitions = function (
    e,
    t,
    r,
    s
) {
    const a =
        document.visibilityState === "visible"
            ? requestAnimationFrame
            : setTimeout;
    let c = () => a(r);
    if (t) {
        e._x_transition && (e._x_transition.enter || e._x_transition.leave)
            ? e._x_transition.enter &&
              (Object.entries(e._x_transition.enter.during).length ||
                  Object.entries(e._x_transition.enter.start).length ||
                  Object.entries(e._x_transition.enter.end).length)
                ? e._x_transition.in(r)
                : c()
            : e._x_transition
            ? e._x_transition.in(r)
            : c();
        return;
    }
    (e._x_hidePromise = e._x_transition
        ? new Promise((u, f) => {
              e._x_transition.out(
                  () => {},
                  () => u(s)
              ),
                  e._x_transitioning &&
                      e._x_transitioning.beforeCancel(() =>
                          f({ isFromCancelledTransition: !0 })
                      );
          })
        : Promise.resolve(s)),
        queueMicrotask(() => {
            let u = ei(e);
            u
                ? (u._x_hideChildren || (u._x_hideChildren = []),
                  u._x_hideChildren.push(e))
                : a(() => {
                      let f = (d) => {
                          let y = Promise.all([
                              d._x_hidePromise,
                              ...(d._x_hideChildren || []).map(f),
                          ]).then(([_]) => (_ == null ? void 0 : _()));
                          return (
                              delete d._x_hidePromise,
                              delete d._x_hideChildren,
                              y
                          );
                      };
                      f(e).catch((d) => {
                          if (!d.isFromCancelledTransition) throw d;
                      });
                  });
        });
};
function ei(e) {
    let t = e.parentNode;
    if (t) return t._x_hidePromise ? t : ei(t);
}
function Jt(
    e,
    t,
    { during: r, start: s, end: a } = {},
    c = () => {},
    u = () => {}
) {
    if (
        (e._x_transitioning && e._x_transitioning.cancel(),
        Object.keys(r).length === 0 &&
            Object.keys(s).length === 0 &&
            Object.keys(a).length === 0)
    ) {
        c(), u();
        return;
    }
    let f, d, y;
    Xa(e, {
        start() {
            f = t(e, s);
        },
        during() {
            d = t(e, r);
        },
        before: c,
        end() {
            f(), (y = t(e, a));
        },
        after: u,
        cleanup() {
            d(), y();
        },
    });
}
function Xa(e, t) {
    let r,
        s,
        a,
        c = Kt(() => {
            M(() => {
                (r = !0),
                    s || t.before(),
                    a || (t.end(), Xt()),
                    t.after(),
                    e.isConnected && t.cleanup(),
                    delete e._x_transitioning;
            });
        });
    (e._x_transitioning = {
        beforeCancels: [],
        beforeCancel(u) {
            this.beforeCancels.push(u);
        },
        cancel: Kt(function () {
            for (; this.beforeCancels.length; ) this.beforeCancels.shift()();
            c();
        }),
        finish: c,
    }),
        M(() => {
            t.start(), t.during();
        }),
        Ha(),
        requestAnimationFrame(() => {
            if (r) return;
            let u =
                    Number(
                        getComputedStyle(e)
                            .transitionDuration.replace(/,.*/, "")
                            .replace("s", "")
                    ) * 1e3,
                f =
                    Number(
                        getComputedStyle(e)
                            .transitionDelay.replace(/,.*/, "")
                            .replace("s", "")
                    ) * 1e3;
            u === 0 &&
                (u =
                    Number(
                        getComputedStyle(e).animationDuration.replace("s", "")
                    ) * 1e3),
                M(() => {
                    t.before();
                }),
                (s = !0),
                requestAnimationFrame(() => {
                    r ||
                        (M(() => {
                            t.end();
                        }),
                        Xt(),
                        setTimeout(e._x_transitioning.finish, u + f),
                        (a = !0));
                });
        });
}
function Ne(e, t, r) {
    if (e.indexOf(t) === -1) return r;
    const s = e[e.indexOf(t) + 1];
    if (!s || (t === "scale" && isNaN(s))) return r;
    if (t === "duration" || t === "delay") {
        let a = s.match(/([0-9]+)ms/);
        if (a) return a[1];
    }
    return t === "origin" &&
        ["top", "right", "left", "center", "bottom"].includes(
            e[e.indexOf(t) + 2]
        )
        ? [s, e[e.indexOf(t) + 2]].join(" ")
        : s;
}
var ae = !1;
function ue(e, t = () => {}) {
    return (...r) => (ae ? t(...r) : e(...r));
}
function Ka(e) {
    return (...t) => ae && e(...t);
}
var ti = [];
function dt(e) {
    ti.push(e);
}
function Ja(e, t) {
    ti.forEach((r) => r(e, t)),
        (ae = !0),
        ni(() => {
            se(t, (r, s) => {
                s(r, () => {});
            });
        }),
        (ae = !1);
}
var Vt = !1;
function Va(e, t) {
    t._x_dataStack || (t._x_dataStack = e._x_dataStack),
        (ae = !0),
        (Vt = !0),
        ni(() => {
            Ga(t);
        }),
        (ae = !1),
        (Vt = !1);
}
function Ga(e) {
    let t = !1;
    se(e, (s, a) => {
        me(s, (c, u) => {
            if (t && Na(c)) return u();
            (t = !0), a(c, u);
        });
    });
}
function ni(e) {
    let t = we;
    nr((r, s) => {
        let a = t(r);
        return Te(a), () => {};
    }),
        e(),
        nr(t);
}
function ri(e, t, r, s = []) {
    switch (
        (e._x_bindings || (e._x_bindings = ke({})),
        (e._x_bindings[t] = r),
        (t = s.includes("camel") ? ic(t) : t),
        t)
    ) {
        case "value":
            Qa(e, r);
            break;
        case "style":
            Za(e, r);
            break;
        case "class":
            Ya(e, r);
            break;
        case "selected":
        case "checked":
            ec(e, t, r);
            break;
        default:
            ii(e, t, r);
            break;
    }
}
function Qa(e, t) {
    if (ai(e))
        e.attributes.value === void 0 && (e.value = t),
            window.fromModel &&
                (typeof t == "boolean"
                    ? (e.checked = it(e.value) === t)
                    : (e.checked = sr(e.value, t)));
    else if (_n(e))
        Number.isInteger(t)
            ? (e.value = t)
            : !Array.isArray(t) &&
              typeof t != "boolean" &&
              ![null, void 0].includes(t)
            ? (e.value = String(t))
            : Array.isArray(t)
            ? (e.checked = t.some((r) => sr(r, e.value)))
            : (e.checked = !!t);
    else if (e.tagName === "SELECT") rc(e, t);
    else {
        if (e.value === t) return;
        e.value = t === void 0 ? "" : t;
    }
}
function Ya(e, t) {
    e._x_undoAddedClasses && e._x_undoAddedClasses(),
        (e._x_undoAddedClasses = vn(e, t));
}
function Za(e, t) {
    e._x_undoAddedStyles && e._x_undoAddedStyles(),
        (e._x_undoAddedStyles = ft(e, t));
}
function ec(e, t, r) {
    ii(e, t, r), nc(e, t, r);
}
function ii(e, t, r) {
    [null, void 0, !1].includes(r) && oc(t)
        ? e.removeAttribute(t)
        : (si(t) && (r = t), tc(e, t, r));
}
function tc(e, t, r) {
    e.getAttribute(t) != r && e.setAttribute(t, r);
}
function nc(e, t, r) {
    e[t] !== r && (e[t] = r);
}
function rc(e, t) {
    const r = [].concat(t).map((s) => s + "");
    Array.from(e.options).forEach((s) => {
        s.selected = r.includes(s.value);
    });
}
function ic(e) {
    return e.toLowerCase().replace(/-(\w)/g, (t, r) => r.toUpperCase());
}
function sr(e, t) {
    return e == t;
}
function it(e) {
    return [1, "1", "true", "on", "yes", !0].includes(e)
        ? !0
        : [0, "0", "false", "off", "no", !1].includes(e)
        ? !1
        : e
        ? !!e
        : null;
}
var sc = new Set([
    "allowfullscreen",
    "async",
    "autofocus",
    "autoplay",
    "checked",
    "controls",
    "default",
    "defer",
    "disabled",
    "formnovalidate",
    "inert",
    "ismap",
    "itemscope",
    "loop",
    "multiple",
    "muted",
    "nomodule",
    "novalidate",
    "open",
    "playsinline",
    "readonly",
    "required",
    "reversed",
    "selected",
    "shadowrootclonable",
    "shadowrootdelegatesfocus",
    "shadowrootserializable",
]);
function si(e) {
    return sc.has(e);
}
function oc(e) {
    return ![
        "aria-pressed",
        "aria-checked",
        "aria-expanded",
        "aria-selected",
    ].includes(e);
}
function ac(e, t, r) {
    return e._x_bindings && e._x_bindings[t] !== void 0
        ? e._x_bindings[t]
        : oi(e, t, r);
}
function cc(e, t, r, s = !0) {
    if (e._x_bindings && e._x_bindings[t] !== void 0) return e._x_bindings[t];
    if (e._x_inlineBindings && e._x_inlineBindings[t] !== void 0) {
        let a = e._x_inlineBindings[t];
        return (a.extract = s), Nr(() => _e(e, a.expression));
    }
    return oi(e, t, r);
}
function oi(e, t, r) {
    let s = e.getAttribute(t);
    return s === null
        ? typeof r == "function"
            ? r()
            : r
        : s === ""
        ? !0
        : si(t)
        ? !![t, "true"].includes(s)
        : s;
}
function _n(e) {
    return (
        e.type === "checkbox" ||
        e.localName === "ui-checkbox" ||
        e.localName === "ui-switch"
    );
}
function ai(e) {
    return e.type === "radio" || e.localName === "ui-radio";
}
function ci(e, t) {
    var r;
    return function () {
        var s = this,
            a = arguments,
            c = function () {
                (r = null), e.apply(s, a);
            };
        clearTimeout(r), (r = setTimeout(c, t));
    };
}
function ui(e, t) {
    let r;
    return function () {
        let s = this,
            a = arguments;
        r || (e.apply(s, a), (r = !0), setTimeout(() => (r = !1), t));
    };
}
function li({ get: e, set: t }, { get: r, set: s }) {
    let a = !0,
        c,
        u = we(() => {
            let f = e(),
                d = r();
            if (a) s(Rt(f)), (a = !1);
            else {
                let y = JSON.stringify(f),
                    _ = JSON.stringify(d);
                y !== c ? s(Rt(f)) : y !== _ && t(Rt(d));
            }
            (c = JSON.stringify(e())), JSON.stringify(r());
        });
    return () => {
        Te(u);
    };
}
function Rt(e) {
    return typeof e == "object" ? JSON.parse(JSON.stringify(e)) : e;
}
function uc(e) {
    (Array.isArray(e) ? e : [e]).forEach((r) => r(We));
}
var pe = {},
    or = !1;
function lc(e, t) {
    if ((or || ((pe = ke(pe)), (or = !0)), t === void 0)) return pe[e];
    (pe[e] = t),
        Rr(pe[e]),
        typeof t == "object" &&
            t !== null &&
            t.hasOwnProperty("init") &&
            typeof t.init == "function" &&
            pe[e].init();
}
function hc() {
    return pe;
}
var hi = {};
function fc(e, t) {
    let r = typeof t != "function" ? () => t : t;
    return e instanceof Element ? fi(e, r()) : ((hi[e] = r), () => {});
}
function dc(e) {
    return (
        Object.entries(hi).forEach(([t, r]) => {
            Object.defineProperty(e, t, {
                get() {
                    return (...s) => r(...s);
                },
            });
        }),
        e
    );
}
function fi(e, t, r) {
    let s = [];
    for (; s.length; ) s.pop()();
    let a = Object.entries(t).map(([u, f]) => ({ name: u, value: f })),
        c = qr(a);
    return (
        (a = a.map((u) =>
            c.find((f) => f.name === u.name)
                ? { name: `x-bind:${u.name}`, value: `"${u.value}"` }
                : u
        )),
        hn(e, a, r).map((u) => {
            s.push(u.runCleanups), u();
        }),
        () => {
            for (; s.length; ) s.pop()();
        }
    );
}
var di = {};
function pc(e, t) {
    di[e] = t;
}
function gc(e, t) {
    return (
        Object.entries(di).forEach(([r, s]) => {
            Object.defineProperty(e, r, {
                get() {
                    return (...a) => s.bind(t)(...a);
                },
                enumerable: !1,
            });
        }),
        e
    );
}
var vc = {
        get reactive() {
            return ke;
        },
        get release() {
            return Te;
        },
        get effect() {
            return we;
        },
        get raw() {
            return xr;
        },
        version: "3.14.7",
        flushAndStopDeferringMutations: ba,
        dontAutoEvaluateFunctions: Nr,
        disableEffectScheduling: ha,
        startObservingMutations: an,
        stopObservingMutations: Or,
        setReactivityEngine: fa,
        onAttributeRemoved: Pr,
        onAttributesAdded: Er,
        closestDataStack: Se,
        skipDuringClone: ue,
        onlyDuringClone: Ka,
        addRootSelector: Gr,
        addInitSelector: Qr,
        interceptClone: dt,
        addScopeToNode: ze,
        deferMutations: _a,
        mapAttributes: fn,
        evaluateLater: B,
        interceptInit: Ma,
        setEvaluator: Ca,
        mergeProxies: Be,
        extractProp: cc,
        findClosest: Pe,
        onElRemoved: rn,
        closestRoot: ht,
        destroyTree: Ae,
        interceptor: Lr,
        transition: Jt,
        setStyles: ft,
        mutateDom: M,
        directive: q,
        entangle: li,
        throttle: ui,
        debounce: ci,
        evaluate: _e,
        initTree: se,
        nextTick: gn,
        prefixed: Ee,
        prefix: Pa,
        plugin: uc,
        magic: Z,
        store: lc,
        start: ja,
        clone: Va,
        cloneNode: Ja,
        bound: ac,
        $data: Ir,
        watch: Sr,
        walk: me,
        data: pc,
        bind: fc,
    },
    We = vc;
function _c(e, t) {
    const r = Object.create(null),
        s = e.split(",");
    for (let a = 0; a < s.length; a++) r[s[a]] = !0;
    return (a) => !!r[a];
}
var bc = Object.freeze({}),
    yc = Object.prototype.hasOwnProperty,
    pt = (e, t) => yc.call(e, t),
    be = Array.isArray,
    $e = (e) => pi(e) === "[object Map]",
    mc = (e) => typeof e == "string",
    bn = (e) => typeof e == "symbol",
    gt = (e) => e !== null && typeof e == "object",
    wc = Object.prototype.toString,
    pi = (e) => wc.call(e),
    gi = (e) => pi(e).slice(8, -1),
    yn = (e) =>
        mc(e) && e !== "NaN" && e[0] !== "-" && "" + parseInt(e, 10) === e,
    xc = (e) => {
        const t = Object.create(null);
        return (r) => t[r] || (t[r] = e(r));
    },
    Sc = xc((e) => e.charAt(0).toUpperCase() + e.slice(1)),
    vi = (e, t) => e !== t && (e === e || t === t),
    Gt = new WeakMap(),
    Me = [],
    te,
    ye = Symbol("iterate"),
    Qt = Symbol("Map key iterate");
function Cc(e) {
    return e && e._isEffect === !0;
}
function kc(e, t = bc) {
    Cc(e) && (e = e.raw);
    const r = Pc(e, t);
    return t.lazy || r(), r;
}
function Tc(e) {
    e.active &&
        (_i(e), e.options.onStop && e.options.onStop(), (e.active = !1));
}
var Ec = 0;
function Pc(e, t) {
    const r = function () {
        if (!r.active) return e();
        if (!Me.includes(r)) {
            _i(r);
            try {
                return Oc(), Me.push(r), (te = r), e();
            } finally {
                Me.pop(), bi(), (te = Me[Me.length - 1]);
            }
        }
    };
    return (
        (r.id = Ec++),
        (r.allowRecurse = !!t.allowRecurse),
        (r._isEffect = !0),
        (r.active = !0),
        (r.raw = e),
        (r.deps = []),
        (r.options = t),
        r
    );
}
function _i(e) {
    const { deps: t } = e;
    if (t.length) {
        for (let r = 0; r < t.length; r++) t[r].delete(e);
        t.length = 0;
    }
}
var Ce = !0,
    mn = [];
function Ac() {
    mn.push(Ce), (Ce = !1);
}
function Oc() {
    mn.push(Ce), (Ce = !0);
}
function bi() {
    const e = mn.pop();
    Ce = e === void 0 ? !0 : e;
}
function Y(e, t, r) {
    if (!Ce || te === void 0) return;
    let s = Gt.get(e);
    s || Gt.set(e, (s = new Map()));
    let a = s.get(r);
    a || s.set(r, (a = new Set())),
        a.has(te) ||
            (a.add(te),
            te.deps.push(a),
            te.options.onTrack &&
                te.options.onTrack({ effect: te, target: e, type: t, key: r }));
}
function ce(e, t, r, s, a, c) {
    const u = Gt.get(e);
    if (!u) return;
    const f = new Set(),
        d = (_) => {
            _ &&
                _.forEach((w) => {
                    (w !== te || w.allowRecurse) && f.add(w);
                });
        };
    if (t === "clear") u.forEach(d);
    else if (r === "length" && be(e))
        u.forEach((_, w) => {
            (w === "length" || w >= s) && d(_);
        });
    else
        switch ((r !== void 0 && d(u.get(r)), t)) {
            case "add":
                be(e)
                    ? yn(r) && d(u.get("length"))
                    : (d(u.get(ye)), $e(e) && d(u.get(Qt)));
                break;
            case "delete":
                be(e) || (d(u.get(ye)), $e(e) && d(u.get(Qt)));
                break;
            case "set":
                $e(e) && d(u.get(ye));
                break;
        }
    const y = (_) => {
        _.options.onTrigger &&
            _.options.onTrigger({
                effect: _,
                target: e,
                key: r,
                type: t,
                newValue: s,
                oldValue: a,
                oldTarget: c,
            }),
            _.options.scheduler ? _.options.scheduler(_) : _();
    };
    f.forEach(y);
}
var Ic = _c("__proto__,__v_isRef,__isVue"),
    yi = new Set(
        Object.getOwnPropertyNames(Symbol)
            .map((e) => Symbol[e])
            .filter(bn)
    ),
    Rc = mi(),
    Lc = mi(!0),
    ar = jc();
function jc() {
    const e = {};
    return (
        ["includes", "indexOf", "lastIndexOf"].forEach((t) => {
            e[t] = function (...r) {
                const s = L(this);
                for (let c = 0, u = this.length; c < u; c++)
                    Y(s, "get", c + "");
                const a = s[t](...r);
                return a === -1 || a === !1 ? s[t](...r.map(L)) : a;
            };
        }),
        ["push", "pop", "shift", "unshift", "splice"].forEach((t) => {
            e[t] = function (...r) {
                Ac();
                const s = L(this)[t].apply(this, r);
                return bi(), s;
            };
        }),
        e
    );
}
function mi(e = !1, t = !1) {
    return function (s, a, c) {
        if (a === "__v_isReactive") return !e;
        if (a === "__v_isReadonly") return e;
        if (a === "__v_raw" && c === (e ? (t ? Jc : Ci) : t ? Kc : Si).get(s))
            return s;
        const u = be(s);
        if (!e && u && pt(ar, a)) return Reflect.get(ar, a, c);
        const f = Reflect.get(s, a, c);
        return (bn(a) ? yi.has(a) : Ic(a)) || (e || Y(s, "get", a), t)
            ? f
            : Yt(f)
            ? !u || !yn(a)
                ? f.value
                : f
            : gt(f)
            ? e
                ? ki(f)
                : Cn(f)
            : f;
    };
}
var Nc = Mc();
function Mc(e = !1) {
    return function (r, s, a, c) {
        let u = r[s];
        if (!e && ((a = L(a)), (u = L(u)), !be(r) && Yt(u) && !Yt(a)))
            return (u.value = a), !0;
        const f = be(r) && yn(s) ? Number(s) < r.length : pt(r, s),
            d = Reflect.set(r, s, a, c);
        return (
            r === L(c) &&
                (f ? vi(a, u) && ce(r, "set", s, a, u) : ce(r, "add", s, a)),
            d
        );
    };
}
function Dc(e, t) {
    const r = pt(e, t),
        s = e[t],
        a = Reflect.deleteProperty(e, t);
    return a && r && ce(e, "delete", t, void 0, s), a;
}
function qc(e, t) {
    const r = Reflect.has(e, t);
    return (!bn(t) || !yi.has(t)) && Y(e, "has", t), r;
}
function Hc(e) {
    return Y(e, "iterate", be(e) ? "length" : ye), Reflect.ownKeys(e);
}
var $c = { get: Rc, set: Nc, deleteProperty: Dc, has: qc, ownKeys: Hc },
    Fc = {
        get: Lc,
        set(e, t) {
            return (
                console.warn(
                    `Set operation on key "${String(
                        t
                    )}" failed: target is readonly.`,
                    e
                ),
                !0
            );
        },
        deleteProperty(e, t) {
            return (
                console.warn(
                    `Delete operation on key "${String(
                        t
                    )}" failed: target is readonly.`,
                    e
                ),
                !0
            );
        },
    },
    wn = (e) => (gt(e) ? Cn(e) : e),
    xn = (e) => (gt(e) ? ki(e) : e),
    Sn = (e) => e,
    vt = (e) => Reflect.getPrototypeOf(e);
function Ye(e, t, r = !1, s = !1) {
    e = e.__v_raw;
    const a = L(e),
        c = L(t);
    t !== c && !r && Y(a, "get", t), !r && Y(a, "get", c);
    const { has: u } = vt(a),
        f = s ? Sn : r ? xn : wn;
    if (u.call(a, t)) return f(e.get(t));
    if (u.call(a, c)) return f(e.get(c));
    e !== a && e.get(t);
}
function Ze(e, t = !1) {
    const r = this.__v_raw,
        s = L(r),
        a = L(e);
    return (
        e !== a && !t && Y(s, "has", e),
        !t && Y(s, "has", a),
        e === a ? r.has(e) : r.has(e) || r.has(a)
    );
}
function et(e, t = !1) {
    return (
        (e = e.__v_raw), !t && Y(L(e), "iterate", ye), Reflect.get(e, "size", e)
    );
}
function cr(e) {
    e = L(e);
    const t = L(this);
    return vt(t).has.call(t, e) || (t.add(e), ce(t, "add", e, e)), this;
}
function ur(e, t) {
    t = L(t);
    const r = L(this),
        { has: s, get: a } = vt(r);
    let c = s.call(r, e);
    c ? xi(r, s, e) : ((e = L(e)), (c = s.call(r, e)));
    const u = a.call(r, e);
    return (
        r.set(e, t),
        c ? vi(t, u) && ce(r, "set", e, t, u) : ce(r, "add", e, t),
        this
    );
}
function lr(e) {
    const t = L(this),
        { has: r, get: s } = vt(t);
    let a = r.call(t, e);
    a ? xi(t, r, e) : ((e = L(e)), (a = r.call(t, e)));
    const c = s ? s.call(t, e) : void 0,
        u = t.delete(e);
    return a && ce(t, "delete", e, void 0, c), u;
}
function hr() {
    const e = L(this),
        t = e.size !== 0,
        r = $e(e) ? new Map(e) : new Set(e),
        s = e.clear();
    return t && ce(e, "clear", void 0, void 0, r), s;
}
function tt(e, t) {
    return function (s, a) {
        const c = this,
            u = c.__v_raw,
            f = L(u),
            d = t ? Sn : e ? xn : wn;
        return (
            !e && Y(f, "iterate", ye),
            u.forEach((y, _) => s.call(a, d(y), d(_), c))
        );
    };
}
function nt(e, t, r) {
    return function (...s) {
        const a = this.__v_raw,
            c = L(a),
            u = $e(c),
            f = e === "entries" || (e === Symbol.iterator && u),
            d = e === "keys" && u,
            y = a[e](...s),
            _ = r ? Sn : t ? xn : wn;
        return (
            !t && Y(c, "iterate", d ? Qt : ye),
            {
                next() {
                    const { value: w, done: m } = y.next();
                    return m
                        ? { value: w, done: m }
                        : { value: f ? [_(w[0]), _(w[1])] : _(w), done: m };
                },
                [Symbol.iterator]() {
                    return this;
                },
            }
        );
    };
}
function oe(e) {
    return function (...t) {
        {
            const r = t[0] ? `on key "${t[0]}" ` : "";
            console.warn(
                `${Sc(e)} operation ${r}failed: target is readonly.`,
                L(this)
            );
        }
        return e === "delete" ? !1 : this;
    };
}
function Uc() {
    const e = {
            get(c) {
                return Ye(this, c);
            },
            get size() {
                return et(this);
            },
            has: Ze,
            add: cr,
            set: ur,
            delete: lr,
            clear: hr,
            forEach: tt(!1, !1),
        },
        t = {
            get(c) {
                return Ye(this, c, !1, !0);
            },
            get size() {
                return et(this);
            },
            has: Ze,
            add: cr,
            set: ur,
            delete: lr,
            clear: hr,
            forEach: tt(!1, !0),
        },
        r = {
            get(c) {
                return Ye(this, c, !0);
            },
            get size() {
                return et(this, !0);
            },
            has(c) {
                return Ze.call(this, c, !0);
            },
            add: oe("add"),
            set: oe("set"),
            delete: oe("delete"),
            clear: oe("clear"),
            forEach: tt(!0, !1),
        },
        s = {
            get(c) {
                return Ye(this, c, !0, !0);
            },
            get size() {
                return et(this, !0);
            },
            has(c) {
                return Ze.call(this, c, !0);
            },
            add: oe("add"),
            set: oe("set"),
            delete: oe("delete"),
            clear: oe("clear"),
            forEach: tt(!0, !0),
        };
    return (
        ["keys", "values", "entries", Symbol.iterator].forEach((c) => {
            (e[c] = nt(c, !1, !1)),
                (r[c] = nt(c, !0, !1)),
                (t[c] = nt(c, !1, !0)),
                (s[c] = nt(c, !0, !0));
        }),
        [e, r, t, s]
    );
}
var [zc, Bc, _u, bu] = Uc();
function wi(e, t) {
    const r = e ? Bc : zc;
    return (s, a, c) =>
        a === "__v_isReactive"
            ? !e
            : a === "__v_isReadonly"
            ? e
            : a === "__v_raw"
            ? s
            : Reflect.get(pt(r, a) && a in s ? r : s, a, c);
}
var Wc = { get: wi(!1) },
    Xc = { get: wi(!0) };
function xi(e, t, r) {
    const s = L(r);
    if (s !== r && t.call(e, s)) {
        const a = gi(e);
        console.warn(
            `Reactive ${a} contains both the raw and reactive versions of the same object${
                a === "Map" ? " as keys" : ""
            }, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`
        );
    }
}
var Si = new WeakMap(),
    Kc = new WeakMap(),
    Ci = new WeakMap(),
    Jc = new WeakMap();
function Vc(e) {
    switch (e) {
        case "Object":
        case "Array":
            return 1;
        case "Map":
        case "Set":
        case "WeakMap":
        case "WeakSet":
            return 2;
        default:
            return 0;
    }
}
function Gc(e) {
    return e.__v_skip || !Object.isExtensible(e) ? 0 : Vc(gi(e));
}
function Cn(e) {
    return e && e.__v_isReadonly ? e : Ti(e, !1, $c, Wc, Si);
}
function ki(e) {
    return Ti(e, !0, Fc, Xc, Ci);
}
function Ti(e, t, r, s, a) {
    if (!gt(e))
        return console.warn(`value cannot be made reactive: ${String(e)}`), e;
    if (e.__v_raw && !(t && e.__v_isReactive)) return e;
    const c = a.get(e);
    if (c) return c;
    const u = Gc(e);
    if (u === 0) return e;
    const f = new Proxy(e, u === 2 ? s : r);
    return a.set(e, f), f;
}
function L(e) {
    return (e && L(e.__v_raw)) || e;
}
function Yt(e) {
    return !!(e && e.__v_isRef === !0);
}
Z("nextTick", () => gn);
Z("dispatch", (e) => He.bind(He, e));
Z("watch", (e, { evaluateLater: t, cleanup: r }) => (s, a) => {
    let c = t(s),
        f = Sr(() => {
            let d;
            return c((y) => (d = y)), d;
        }, a);
    r(f);
});
Z("store", hc);
Z("data", (e) => Ir(e));
Z("root", (e) => ht(e));
Z(
    "refs",
    (e) => (e._x_refs_proxy || (e._x_refs_proxy = Be(Qc(e))), e._x_refs_proxy)
);
function Qc(e) {
    let t = [];
    return (
        Pe(e, (r) => {
            r._x_refs && t.push(r._x_refs);
        }),
        t
    );
}
var Lt = {};
function Ei(e) {
    return Lt[e] || (Lt[e] = 0), ++Lt[e];
}
function Yc(e, t) {
    return Pe(e, (r) => {
        if (r._x_ids && r._x_ids[t]) return !0;
    });
}
function Zc(e, t) {
    e._x_ids || (e._x_ids = {}), e._x_ids[t] || (e._x_ids[t] = Ei(t));
}
Z("id", (e, { cleanup: t }) => (r, s = null) => {
    let a = `${r}${s ? `-${s}` : ""}`;
    return eu(e, a, t, () => {
        let c = Yc(e, r),
            u = c ? c._x_ids[r] : Ei(r);
        return s ? `${r}-${u}-${s}` : `${r}-${u}`;
    });
});
dt((e, t) => {
    e._x_id && (t._x_id = e._x_id);
});
function eu(e, t, r, s) {
    if ((e._x_id || (e._x_id = {}), e._x_id[t])) return e._x_id[t];
    let a = s();
    return (
        (e._x_id[t] = a),
        r(() => {
            delete e._x_id[t];
        }),
        a
    );
}
Z("el", (e) => e);
Pi("Focus", "focus", "focus");
Pi("Persist", "persist", "persist");
function Pi(e, t, r) {
    Z(t, (s) =>
        G(
            `You can't use [$${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${r}`,
            s
        )
    );
}
q(
    "modelable",
    (e, { expression: t }, { effect: r, evaluateLater: s, cleanup: a }) => {
        let c = s(t),
            u = () => {
                let _;
                return c((w) => (_ = w)), _;
            },
            f = s(`${t} = __placeholder`),
            d = (_) => f(() => {}, { scope: { __placeholder: _ } }),
            y = u();
        d(y),
            queueMicrotask(() => {
                if (!e._x_model) return;
                e._x_removeModelListeners.default();
                let _ = e._x_model.get,
                    w = e._x_model.set,
                    m = li(
                        {
                            get() {
                                return _();
                            },
                            set(C) {
                                w(C);
                            },
                        },
                        {
                            get() {
                                return u();
                            },
                            set(C) {
                                d(C);
                            },
                        }
                    );
                a(m);
            });
    }
);
q("teleport", (e, { modifiers: t, expression: r }, { cleanup: s }) => {
    e.tagName.toLowerCase() !== "template" &&
        G("x-teleport can only be used on a <template> tag", e);
    let a = fr(r),
        c = e.content.cloneNode(!0).firstElementChild;
    (e._x_teleport = c),
        (c._x_teleportBack = e),
        e.setAttribute("data-teleport-template", !0),
        c.setAttribute("data-teleport-target", !0),
        e._x_forwardEvents &&
            e._x_forwardEvents.forEach((f) => {
                c.addEventListener(f, (d) => {
                    d.stopPropagation(),
                        e.dispatchEvent(new d.constructor(d.type, d));
                });
            }),
        ze(c, {}, e);
    let u = (f, d, y) => {
        y.includes("prepend")
            ? d.parentNode.insertBefore(f, d)
            : y.includes("append")
            ? d.parentNode.insertBefore(f, d.nextSibling)
            : d.appendChild(f);
    };
    M(() => {
        u(c, a, t),
            ue(() => {
                se(c);
            })();
    }),
        (e._x_teleportPutBack = () => {
            let f = fr(r);
            M(() => {
                u(e._x_teleport, f, t);
            });
        }),
        s(() =>
            M(() => {
                c.remove(), Ae(c);
            })
        );
});
var tu = document.createElement("div");
function fr(e) {
    let t = ue(
        () => document.querySelector(e),
        () => tu
    )();
    return t || G(`Cannot find x-teleport element for selector: "${e}"`), t;
}
var Ai = () => {};
Ai.inline = (e, { modifiers: t }, { cleanup: r }) => {
    t.includes("self") ? (e._x_ignoreSelf = !0) : (e._x_ignore = !0),
        r(() => {
            t.includes("self") ? delete e._x_ignoreSelf : delete e._x_ignore;
        });
};
q("ignore", Ai);
q(
    "effect",
    ue((e, { expression: t }, { effect: r }) => {
        r(B(e, t));
    })
);
function Zt(e, t, r, s) {
    let a = e,
        c = (d) => s(d),
        u = {},
        f = (d, y) => (_) => y(d, _);
    if (
        (r.includes("dot") && (t = nu(t)),
        r.includes("camel") && (t = ru(t)),
        r.includes("passive") && (u.passive = !0),
        r.includes("capture") && (u.capture = !0),
        r.includes("window") && (a = window),
        r.includes("document") && (a = document),
        r.includes("debounce"))
    ) {
        let d = r[r.indexOf("debounce") + 1] || "invalid-wait",
            y = lt(d.split("ms")[0]) ? Number(d.split("ms")[0]) : 250;
        c = ci(c, y);
    }
    if (r.includes("throttle")) {
        let d = r[r.indexOf("throttle") + 1] || "invalid-wait",
            y = lt(d.split("ms")[0]) ? Number(d.split("ms")[0]) : 250;
        c = ui(c, y);
    }
    return (
        r.includes("prevent") &&
            (c = f(c, (d, y) => {
                y.preventDefault(), d(y);
            })),
        r.includes("stop") &&
            (c = f(c, (d, y) => {
                y.stopPropagation(), d(y);
            })),
        r.includes("once") &&
            (c = f(c, (d, y) => {
                d(y), a.removeEventListener(t, c, u);
            })),
        (r.includes("away") || r.includes("outside")) &&
            ((a = document),
            (c = f(c, (d, y) => {
                e.contains(y.target) ||
                    (y.target.isConnected !== !1 &&
                        ((e.offsetWidth < 1 && e.offsetHeight < 1) ||
                            (e._x_isShown !== !1 && d(y))));
            }))),
        r.includes("self") &&
            (c = f(c, (d, y) => {
                y.target === e && d(y);
            })),
        (su(t) || Oi(t)) &&
            (c = f(c, (d, y) => {
                ou(y, r) || d(y);
            })),
        a.addEventListener(t, c, u),
        () => {
            a.removeEventListener(t, c, u);
        }
    );
}
function nu(e) {
    return e.replace(/-/g, ".");
}
function ru(e) {
    return e.toLowerCase().replace(/-(\w)/g, (t, r) => r.toUpperCase());
}
function lt(e) {
    return !Array.isArray(e) && !isNaN(e);
}
function iu(e) {
    return [" ", "_"].includes(e)
        ? e
        : e
              .replace(/([a-z])([A-Z])/g, "$1-$2")
              .replace(/[_\s]/, "-")
              .toLowerCase();
}
function su(e) {
    return ["keydown", "keyup"].includes(e);
}
function Oi(e) {
    return ["contextmenu", "click", "mouse"].some((t) => e.includes(t));
}
function ou(e, t) {
    let r = t.filter(
        (c) =>
            ![
                "window",
                "document",
                "prevent",
                "stop",
                "once",
                "capture",
                "self",
                "away",
                "outside",
                "passive",
            ].includes(c)
    );
    if (r.includes("debounce")) {
        let c = r.indexOf("debounce");
        r.splice(c, lt((r[c + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
    }
    if (r.includes("throttle")) {
        let c = r.indexOf("throttle");
        r.splice(c, lt((r[c + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
    }
    if (r.length === 0 || (r.length === 1 && dr(e.key).includes(r[0])))
        return !1;
    const a = ["ctrl", "shift", "alt", "meta", "cmd", "super"].filter((c) =>
        r.includes(c)
    );
    return (
        (r = r.filter((c) => !a.includes(c))),
        !(
            a.length > 0 &&
            a.filter(
                (u) => (
                    (u === "cmd" || u === "super") && (u = "meta"), e[`${u}Key`]
                )
            ).length === a.length &&
            (Oi(e.type) || dr(e.key).includes(r[0]))
        )
    );
}
function dr(e) {
    if (!e) return [];
    e = iu(e);
    let t = {
        ctrl: "control",
        slash: "/",
        space: " ",
        spacebar: " ",
        cmd: "meta",
        esc: "escape",
        up: "arrow-up",
        down: "arrow-down",
        left: "arrow-left",
        right: "arrow-right",
        period: ".",
        comma: ",",
        equal: "=",
        minus: "-",
        underscore: "_",
    };
    return (
        (t[e] = e),
        Object.keys(t)
            .map((r) => {
                if (t[r] === e) return r;
            })
            .filter((r) => r)
    );
}
q("model", (e, { modifiers: t, expression: r }, { effect: s, cleanup: a }) => {
    let c = e;
    t.includes("parent") && (c = e.parentNode);
    let u = B(c, r),
        f;
    typeof r == "string"
        ? (f = B(c, `${r} = __placeholder`))
        : typeof r == "function" && typeof r() == "string"
        ? (f = B(c, `${r()} = __placeholder`))
        : (f = () => {});
    let d = () => {
            let m;
            return u((C) => (m = C)), pr(m) ? m.get() : m;
        },
        y = (m) => {
            let C;
            u((A) => (C = A)),
                pr(C) ? C.set(m) : f(() => {}, { scope: { __placeholder: m } });
        };
    typeof r == "string" &&
        e.type === "radio" &&
        M(() => {
            e.hasAttribute("name") || e.setAttribute("name", r);
        });
    var _ =
        e.tagName.toLowerCase() === "select" ||
        ["checkbox", "radio"].includes(e.type) ||
        t.includes("lazy")
            ? "change"
            : "input";
    let w = ae
        ? () => {}
        : Zt(e, _, t, (m) => {
              y(jt(e, t, m, d()));
          });
    if (
        (t.includes("fill") &&
            ([void 0, null, ""].includes(d()) ||
                (_n(e) && Array.isArray(d())) ||
                (e.tagName.toLowerCase() === "select" && e.multiple)) &&
            y(jt(e, t, { target: e }, d())),
        e._x_removeModelListeners || (e._x_removeModelListeners = {}),
        (e._x_removeModelListeners.default = w),
        a(() => e._x_removeModelListeners.default()),
        e.form)
    ) {
        let m = Zt(e.form, "reset", [], (C) => {
            gn(
                () => e._x_model && e._x_model.set(jt(e, t, { target: e }, d()))
            );
        });
        a(() => m());
    }
    (e._x_model = {
        get() {
            return d();
        },
        set(m) {
            y(m);
        },
    }),
        (e._x_forceModelUpdate = (m) => {
            m === void 0 && typeof r == "string" && r.match(/\./) && (m = ""),
                (window.fromModel = !0),
                M(() => ri(e, "value", m)),
                delete window.fromModel;
        }),
        s(() => {
            let m = d();
            (t.includes("unintrusive") &&
                document.activeElement.isSameNode(e)) ||
                e._x_forceModelUpdate(m);
        });
});
function jt(e, t, r, s) {
    return M(() => {
        if (r instanceof CustomEvent && r.detail !== void 0)
            return r.detail !== null && r.detail !== void 0
                ? r.detail
                : r.target.value;
        if (_n(e))
            if (Array.isArray(s)) {
                let a = null;
                return (
                    t.includes("number")
                        ? (a = Nt(r.target.value))
                        : t.includes("boolean")
                        ? (a = it(r.target.value))
                        : (a = r.target.value),
                    r.target.checked
                        ? s.includes(a)
                            ? s
                            : s.concat([a])
                        : s.filter((c) => !au(c, a))
                );
            } else return r.target.checked;
        else {
            if (e.tagName.toLowerCase() === "select" && e.multiple)
                return t.includes("number")
                    ? Array.from(r.target.selectedOptions).map((a) => {
                          let c = a.value || a.text;
                          return Nt(c);
                      })
                    : t.includes("boolean")
                    ? Array.from(r.target.selectedOptions).map((a) => {
                          let c = a.value || a.text;
                          return it(c);
                      })
                    : Array.from(r.target.selectedOptions).map(
                          (a) => a.value || a.text
                      );
            {
                let a;
                return (
                    ai(e)
                        ? r.target.checked
                            ? (a = r.target.value)
                            : (a = s)
                        : (a = r.target.value),
                    t.includes("number")
                        ? Nt(a)
                        : t.includes("boolean")
                        ? it(a)
                        : t.includes("trim")
                        ? a.trim()
                        : a
                );
            }
        }
    });
}
function Nt(e) {
    let t = e ? parseFloat(e) : null;
    return cu(t) ? t : e;
}
function au(e, t) {
    return e == t;
}
function cu(e) {
    return !Array.isArray(e) && !isNaN(e);
}
function pr(e) {
    return (
        e !== null &&
        typeof e == "object" &&
        typeof e.get == "function" &&
        typeof e.set == "function"
    );
}
q("cloak", (e) =>
    queueMicrotask(() => M(() => e.removeAttribute(Ee("cloak"))))
);
Qr(() => `[${Ee("init")}]`);
q(
    "init",
    ue((e, { expression: t }, { evaluate: r }) =>
        typeof t == "string" ? !!t.trim() && r(t, {}, !1) : r(t, {}, !1)
    )
);
q("text", (e, { expression: t }, { effect: r, evaluateLater: s }) => {
    let a = s(t);
    r(() => {
        a((c) => {
            M(() => {
                e.textContent = c;
            });
        });
    });
});
q("html", (e, { expression: t }, { effect: r, evaluateLater: s }) => {
    let a = s(t);
    r(() => {
        a((c) => {
            M(() => {
                (e.innerHTML = c),
                    (e._x_ignoreSelf = !0),
                    se(e),
                    delete e._x_ignoreSelf;
            });
        });
    });
});
fn(Fr(":", Ur(Ee("bind:"))));
var Ii = (
    e,
    { value: t, modifiers: r, expression: s, original: a },
    { effect: c, cleanup: u }
) => {
    if (!t) {
        let d = {};
        dc(d),
            B(e, s)(
                (_) => {
                    fi(e, _, a);
                },
                { scope: d }
            );
        return;
    }
    if (t === "key") return uu(e, s);
    if (
        e._x_inlineBindings &&
        e._x_inlineBindings[t] &&
        e._x_inlineBindings[t].extract
    )
        return;
    let f = B(e, s);
    c(() =>
        f((d) => {
            d === void 0 && typeof s == "string" && s.match(/\./) && (d = ""),
                M(() => ri(e, t, d, r));
        })
    ),
        u(() => {
            e._x_undoAddedClasses && e._x_undoAddedClasses(),
                e._x_undoAddedStyles && e._x_undoAddedStyles();
        });
};
Ii.inline = (e, { value: t, modifiers: r, expression: s }) => {
    t &&
        (e._x_inlineBindings || (e._x_inlineBindings = {}),
        (e._x_inlineBindings[t] = { expression: s, extract: !1 }));
};
q("bind", Ii);
function uu(e, t) {
    e._x_keyExpression = t;
}
Gr(() => `[${Ee("data")}]`);
q("data", (e, { expression: t }, { cleanup: r }) => {
    if (lu(e)) return;
    t = t === "" ? "{}" : t;
    let s = {};
    Ut(s, e);
    let a = {};
    gc(a, s);
    let c = _e(e, t, { scope: a });
    (c === void 0 || c === !0) && (c = {}), Ut(c, e);
    let u = ke(c);
    Rr(u);
    let f = ze(e, u);
    u.init && _e(e, u.init),
        r(() => {
            u.destroy && _e(e, u.destroy), f();
        });
});
dt((e, t) => {
    e._x_dataStack &&
        ((t._x_dataStack = e._x_dataStack),
        t.setAttribute("data-has-alpine-state", !0));
});
function lu(e) {
    return ae ? (Vt ? !0 : e.hasAttribute("data-has-alpine-state")) : !1;
}
q("show", (e, { modifiers: t, expression: r }, { effect: s }) => {
    let a = B(e, r);
    e._x_doHide ||
        (e._x_doHide = () => {
            M(() => {
                e.style.setProperty(
                    "display",
                    "none",
                    t.includes("important") ? "important" : void 0
                );
            });
        }),
        e._x_doShow ||
            (e._x_doShow = () => {
                M(() => {
                    e.style.length === 1 && e.style.display === "none"
                        ? e.removeAttribute("style")
                        : e.style.removeProperty("display");
                });
            });
    let c = () => {
            e._x_doHide(), (e._x_isShown = !1);
        },
        u = () => {
            e._x_doShow(), (e._x_isShown = !0);
        },
        f = () => setTimeout(u),
        d = Kt(
            (w) => (w ? u() : c()),
            (w) => {
                typeof e._x_toggleAndCascadeWithTransitions == "function"
                    ? e._x_toggleAndCascadeWithTransitions(e, w, u, c)
                    : w
                    ? f()
                    : c();
            }
        ),
        y,
        _ = !0;
    s(() =>
        a((w) => {
            (!_ && w === y) ||
                (t.includes("immediate") && (w ? f() : c()),
                d(w),
                (y = w),
                (_ = !1));
        })
    );
});
q("for", (e, { expression: t }, { effect: r, cleanup: s }) => {
    let a = fu(t),
        c = B(e, a.items),
        u = B(e, e._x_keyExpression || "index");
    (e._x_prevKeys = []),
        (e._x_lookup = {}),
        r(() => hu(e, a, c, u)),
        s(() => {
            Object.values(e._x_lookup).forEach((f) =>
                M(() => {
                    Ae(f), f.remove();
                })
            ),
                delete e._x_prevKeys,
                delete e._x_lookup;
        });
});
function hu(e, t, r, s) {
    let a = (u) => typeof u == "object" && !Array.isArray(u),
        c = e;
    r((u) => {
        du(u) && u >= 0 && (u = Array.from(Array(u).keys(), (p) => p + 1)),
            u === void 0 && (u = []);
        let f = e._x_lookup,
            d = e._x_prevKeys,
            y = [],
            _ = [];
        if (a(u))
            u = Object.entries(u).map(([p, v]) => {
                let x = gr(t, v, p, u);
                s(
                    (P) => {
                        _.includes(P) && G("Duplicate key on x-for", e),
                            _.push(P);
                    },
                    { scope: { index: p, ...x } }
                ),
                    y.push(x);
            });
        else
            for (let p = 0; p < u.length; p++) {
                let v = gr(t, u[p], p, u);
                s(
                    (x) => {
                        _.includes(x) && G("Duplicate key on x-for", e),
                            _.push(x);
                    },
                    { scope: { index: p, ...v } }
                ),
                    y.push(v);
            }
        let w = [],
            m = [],
            C = [],
            A = [];
        for (let p = 0; p < d.length; p++) {
            let v = d[p];
            _.indexOf(v) === -1 && C.push(v);
        }
        d = d.filter((p) => !C.includes(p));
        let k = "template";
        for (let p = 0; p < _.length; p++) {
            let v = _[p],
                x = d.indexOf(v);
            if (x === -1) d.splice(p, 0, v), w.push([k, p]);
            else if (x !== p) {
                let P = d.splice(p, 1)[0],
                    I = d.splice(x - 1, 1)[0];
                d.splice(p, 0, I), d.splice(x, 0, P), m.push([P, I]);
            } else A.push(v);
            k = v;
        }
        for (let p = 0; p < C.length; p++) {
            let v = C[p];
            v in f &&
                (M(() => {
                    Ae(f[v]), f[v].remove();
                }),
                delete f[v]);
        }
        for (let p = 0; p < m.length; p++) {
            let [v, x] = m[p],
                P = f[v],
                I = f[x],
                j = document.createElement("div");
            M(() => {
                I || G('x-for ":key" is undefined or invalid', c, x, f),
                    I.after(j),
                    P.after(I),
                    I._x_currentIfEl && I.after(I._x_currentIfEl),
                    j.before(P),
                    P._x_currentIfEl && P.after(P._x_currentIfEl),
                    j.remove();
            }),
                I._x_refreshXForScope(y[_.indexOf(x)]);
        }
        for (let p = 0; p < w.length; p++) {
            let [v, x] = w[p],
                P = v === "template" ? c : f[v];
            P._x_currentIfEl && (P = P._x_currentIfEl);
            let I = y[x],
                j = _[x],
                F = document.importNode(c.content, !0).firstElementChild,
                V = ke(I);
            ze(F, V, c),
                (F._x_refreshXForScope = (W) => {
                    Object.entries(W).forEach(([Q, ee]) => {
                        V[Q] = ee;
                    });
                }),
                M(() => {
                    P.after(F), ue(() => se(F))();
                }),
                typeof j == "object" &&
                    G(
                        "x-for key cannot be an object, it must be a string or an integer",
                        c
                    ),
                (f[j] = F);
        }
        for (let p = 0; p < A.length; p++)
            f[A[p]]._x_refreshXForScope(y[_.indexOf(A[p])]);
        c._x_prevKeys = _;
    });
}
function fu(e) {
    let t = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/,
        r = /^\s*\(|\)\s*$/g,
        s = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,
        a = e.match(s);
    if (!a) return;
    let c = {};
    c.items = a[2].trim();
    let u = a[1].replace(r, "").trim(),
        f = u.match(t);
    return (
        f
            ? ((c.item = u.replace(t, "").trim()),
              (c.index = f[1].trim()),
              f[2] && (c.collection = f[2].trim()))
            : (c.item = u),
        c
    );
}
function gr(e, t, r, s) {
    let a = {};
    return (
        /^\[.*\]$/.test(e.item) && Array.isArray(t)
            ? e.item
                  .replace("[", "")
                  .replace("]", "")
                  .split(",")
                  .map((u) => u.trim())
                  .forEach((u, f) => {
                      a[u] = t[f];
                  })
            : /^\{.*\}$/.test(e.item) &&
              !Array.isArray(t) &&
              typeof t == "object"
            ? e.item
                  .replace("{", "")
                  .replace("}", "")
                  .split(",")
                  .map((u) => u.trim())
                  .forEach((u) => {
                      a[u] = t[u];
                  })
            : (a[e.item] = t),
        e.index && (a[e.index] = r),
        e.collection && (a[e.collection] = s),
        a
    );
}
function du(e) {
    return !Array.isArray(e) && !isNaN(e);
}
function Ri() {}
Ri.inline = (e, { expression: t }, { cleanup: r }) => {
    let s = ht(e);
    s._x_refs || (s._x_refs = {}),
        (s._x_refs[t] = e),
        r(() => delete s._x_refs[t]);
};
q("ref", Ri);
q("if", (e, { expression: t }, { effect: r, cleanup: s }) => {
    e.tagName.toLowerCase() !== "template" &&
        G("x-if can only be used on a <template> tag", e);
    let a = B(e, t),
        c = () => {
            if (e._x_currentIfEl) return e._x_currentIfEl;
            let f = e.content.cloneNode(!0).firstElementChild;
            return (
                ze(f, {}, e),
                M(() => {
                    e.after(f), ue(() => se(f))();
                }),
                (e._x_currentIfEl = f),
                (e._x_undoIf = () => {
                    M(() => {
                        Ae(f), f.remove();
                    }),
                        delete e._x_currentIfEl;
                }),
                f
            );
        },
        u = () => {
            e._x_undoIf && (e._x_undoIf(), delete e._x_undoIf);
        };
    r(() =>
        a((f) => {
            f ? c() : u();
        })
    ),
        s(() => e._x_undoIf && e._x_undoIf());
});
q("id", (e, { expression: t }, { evaluate: r }) => {
    r(t).forEach((a) => Zc(e, a));
});
dt((e, t) => {
    e._x_ids && (t._x_ids = e._x_ids);
});
fn(Fr("@", Ur(Ee("on:"))));
q(
    "on",
    ue((e, { value: t, modifiers: r, expression: s }, { cleanup: a }) => {
        let c = s ? B(e, s) : () => {};
        e.tagName.toLowerCase() === "template" &&
            (e._x_forwardEvents || (e._x_forwardEvents = []),
            e._x_forwardEvents.includes(t) || e._x_forwardEvents.push(t));
        let u = Zt(e, t, r, (f) => {
            c(() => {}, { scope: { $event: f }, params: [f] });
        });
        a(() => u());
    })
);
_t("Collapse", "collapse", "collapse");
_t("Intersect", "intersect", "intersect");
_t("Focus", "trap", "focus");
_t("Mask", "mask", "mask");
function _t(e, t, r) {
    q(t, (s) =>
        G(
            `You can't use [x-${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${r}`,
            s
        )
    );
}
We.setEvaluator(Dr);
We.setReactivityEngine({ reactive: Cn, effect: kc, release: Tc, raw: L });
var pu = We,
    Li = pu;
window.Alpine = Li;
Li.start();
