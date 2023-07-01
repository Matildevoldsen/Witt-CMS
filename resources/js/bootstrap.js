/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: window.location.hostname,
    wssPort: 6001,
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                callback(false, {}); // Just auth every request
            }
        };
    },
});
window.addEventListener('load', function () {
    // Check if the browser's theme is set to dark mode
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        // If dark mode is set, create a cookie named "theme" with the value "dark"
        document.cookie = "theme=dark; path=/";
    } else {
        // If dark mode is not set, create a cookie named "theme" with the value "light"
        document.cookie = "theme=light; path=/";
    }
});
