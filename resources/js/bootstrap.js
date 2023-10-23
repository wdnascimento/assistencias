window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */





window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// PUSHER

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// //  -------------------
// //  PUSHER CONFIG
// //  -------------------

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     auth:{
//         headers: {
//             Accept: 'application/json',
//             Authorization: 'Bearer '+ process.env.MIX_PUSHER_APP_KEY,
//         },
//     },

//     authEndpoint: process.env.MIX_APP_URL+'/api/endpoint/auth'

// });

import Echo from '@ably/laravel-echo';
import * as Ably from 'ably';

window.Ably = Ably;
window.Echo = new Echo({
    broadcaster: 'ably',
    heartbeats: 'false'
});

window.Echo.connector.ably.connection.on(stateChange => {
    if (stateChange.current === 'connected') {
        console.log('connected to ably server');
    }

});


