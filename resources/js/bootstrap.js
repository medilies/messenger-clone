import _ from "lodash";
window._ = _;

import axios from "axios";
window.axios = axios;

import Echo from "laravel-echo";
import Pusher from "pusher-js";

import { useAuthStore } from "./modules/auth/store/AuthStore";
import { authenticatedPost } from "@/modules/auth/Services/AuthenticatedRequest";
import router from "./router";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.defaults.baseURL = "http://127.0.0.1:8000";

window.axios.defaults.withCredentials = true;

axios.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        // TODO: improve this logic
        if (error.response.status === 401) {
            const authStore = useAuthStore();

            authStore.invalidate();
            router.push("/login");

            return;
        }

        return Promise.reject(error);
    }
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.Echo = new Echo({
    broadcaster: import.meta.env.VITE_BROADCAST_DRIVER,
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost:
        import.meta.env.VITE_PUSHER_HOST ??
        `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Options mentioned by pusher
    disableStats: true, // Options mentioned by beyond code
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                authenticatedPost("/api/broadcasting/auth", {
                    socket_id: socketId,
                    channel_name: channel.name,
                })
                    .then((response) => {
                        callback(false, response.data);
                    })
                    .catch((error) => {
                        callback(true, error);
                    });
            },
        };
    },
});
