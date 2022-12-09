# Messenger clone

## Features

### System features

1. Listing contacts.
2. Searching for a contact.
3. Direct messages.
4. Group messages.
5. Sending media.
6. Sending vocal messages.
7. Indicating the connection status of a contact.
8. Indicating when a contact was last seen if not connected.
9. Signaling if user is typing.
10. Reporting the message state sending - sent - delivered - seen.
11. Searching for a message in a conversation.
12. Editing a message, and wether to keep the history of changes or not.
13. Deleting a message.

### Front end only features

1. Auto-scrolling down when entering a conversation.
2. Showing a notification when a user isn't in the conversation.
3. Showing a count of not seen messages.
4. Getting stored messages from the backend.
5. Caching messages.
6. Show a separator when there is a considerable time interval between messages.

## Architecture

Like any other cloud app. This app will need a:

-   **Database** for storing users data and messages.
-   Backend services for handling API calls, **authentication**, **session management**, **authorization** and **file management**.

In a classical way, **Laravel** with **MySQL** can handle all the above. But now the special part is enabling realtime messaging, if you are a lazy engineer and do not care about your client/employer bills its ok to go to **Firebase** to handle the messaging part. But if you have enough experience you already know that realtime data needs to be mobilized using a realtime protocols such as `websocket`, and you are asking your self which websocket server implementation to couple with the chosen backend.

**Laravel** comes bundled with tools that support, **events**, **notifications**, **broadcasting**, and **queues**. But doesn't support any realtime protocol out of the box but instead of letting us stray alone looking for websocket servers to couple with **Laravel**. It eases and recommends the integration of [Pusher](https://pusher.com/) and [Ably](https://ably.com/). Even better, the community maintains packages that can be used as alternative, compatible, self hosted APIs for **Pusher** which are:

-   [Laravel Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction) is a PHP package built on top of [Ratchet](http://socketo.me/), [read more...](https://freek.dev/1228-introducing-laravel-websockets-an-easy-to-use-websocket-server-implemented-in-php).
-   [Soketi](https://soketi.app/) is a NodeJS package built on top of µWebSockets.js.

My preference is **Laravel Websockets** for the simple fact of being able to maintain it in one repository with the **Laravel** backend.

For the client side **pusher-js** library is the go to, and **laravel-echo** makes it even easier to use publish and subscribe from the browsers.

To be more exhaustive, this demo will be using **Sanctum** for authenticating API calls. And **Axios** as a front end HTTP client.

### Scaling

<https://beyondco.de/docs/laravel-websockets/faq/scaling>

## Database

## Scaffolding

```shell
laravel new --git laravel-clone
```

```shell
composer require laravel/sanctum
```

```shell
composer require pusher/pusher-php-server:7.0.2
```

> Version compatibilty issue <https://github.com/beyondcode/laravel-websockets/issues/1041>

```shell
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

```shell
npm install --save-dev laravel-echo pusher-js
```

Setup a database and the `env` configs.

## Config

> Before broadcasting any events, you will first need to register the `App\Providers\BroadcastServiceProvider`. In new Laravel applications, you only need to uncomment this provider in the providers array of your config/app.php configuration file. This `BroadcastServiceProvider` contains the code necessary to register the broadcast authorization routes and callbacks.

The following config makes it easy to switch between **Pusher** and **Laravel Websockets**.

```env
# .env
APP_URL=http://127.0.0.1:8000

BROADCAST_DRIVER=pusher

PUSHER_APP_ID=app-id
PUSHER_APP_KEY=app-key
PUSHER_APP_SECRET=app-secret
PUSHER_APP_CLUSTER=mt1

# https:443:encrypyed-true / http:6001:encrypyed-false
# PUSHER_SCHEME=https
# PUSHER_PORT=443
# PUSHER_ENCRYPTED=true
PUSHER_SCHEME=http
PUSHER_PORT=6001
PUSHER_ENCRYPTED=false

# Includes cluster in pusher URL -> replace XX
# PUSHER_HOST=api-XX.pusher.com
PUSHER_HOST=127.0.0.1

LARAVEL_WEBSOCKETS_ENABLE_CLIENT_MESSAGES=true

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
VITE_PUSHER_PORT=${PUSHER_PORT}
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
```

Add Sanctum's middleware `\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class` to api middleware group within `app/Http/Kernel.php`.

Register `App\Providers\BroadcastServiceProvider::class` in `config/app.php`.

```php
// config\broadcasting.php
return [
    // ...
    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY', 'app-key'),
            'secret' => env('PUSHER_APP_SECRET', 'app-secret'),
            'app_id' => env('PUSHER_APP_ID', 'app-id'),
            'options' => [
                // By default on laravel:
                'cluster' => env('PUSHER_APP_CLUSTER', 'eu'),
                'useTLS' => env('PUSHER_SCHEME') === 'https', // default to true
                // Added for laravel websockets package
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'port' => env('PUSHER_PORT', 443),
                'host' => env('PUSHER_HOST', 'api-'.env('PUSHER_APP_CLUSTER', 'eu').'.pusher.com'),
                //
                'base_path' => env('PUSHER_BASE_PATH', '/apps/'.env('PUSHER_APP_ID')),
            ],
            'client_options' => [
                // Guzzle client options: https://docs.guzzlephp.org/en/stable/request-options.html
            ],
        ],
        // ...
    ]
    // ...
];
```

```php
// config\websockets.php
return [
    'dashboard' => [
        'port' => env('PUSHER_PORT', 6001),
    ],

    'apps' => [
        [
            'name' => env('APP_NAME'),
            'id' => env('PUSHER_APP_ID', 'app-id'),
            'key' => env('PUSHER_APP_KEY', 'app-key'),
            'secret' => env('PUSHER_APP_SECRET', 'app-secret'),
            'capacity' => null,
            'enable_client_messages' => env('LARAVEL_WEBSOCKETS_ENABLE_CLIENT_MESSAGES', false),
            'enable_statistics' => true,
        ],
    ],
    // ...
];
```

```js
// resources\js\bootstrap.js
import _ from "lodash";
window._ = _;

import axios from "axios";
window.axios = axios;

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.defaults.baseURL = import.meta.env.APP_URL;

window.axios.defaults.withCredentials = true;

window.Pusher = Pusher;

window.Echo = new Echo({
    // Options mentioned by pusher
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === "https",
    // Options exclusively by beyond code
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    disableStats: true,
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios
                    .post(
                        "/api/broadcasting/auth",
                        {
                            socket_id: socketId,
                            channel_name: channel.name,
                        },
                        {
                            headers: {
                                Accept: "application/json",
                                Authorization:
                                    "Bearer " +
                                    localStorage.getItem("bearerToken"),
                            },
                        }
                    )
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
```

```php
// routes/api.php
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/sanctum/token', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    // ...
});
```

```php
use Illuminate\Support\Facades\Route;

Route::fallback(fn() => view('app'));
```

### SSL

<https://beyondco.de/docs/laravel-websockets/basic-usage/ssl>

## Laravel broadcasting

> Events are broadcast over "channels", which may be specified as public or private.
> Any visitor to your application may subscribe to a public channel without any authentication or authorization; however, in order to subscribe to a private channel, a user must be authenticated and authorized to listen on that channel.

### ShouldBroadcast events interface

Broadcastable events must implement the `Illuminate\Contracts\Broadcasting\ShouldBroadcast` interface, This will instruct Laravel to broadcast the event when it is fired.

The `ShouldBroadcast` interface requires our event to define a broadcastOn method.

## References

<https://devtechnosys.com/messaging-app-development.php>

<https://towardsdatascience.com/ace-the-system-interview-design-a-chat-application-3f34fd5b85d0>

<https://stackoverflow.com/questions/46484989/database-schema-for-chat-private-and-group>

<https://stackoverflow.com/questions/39810106/storing-messages-of-different-chats-in-a-single-database-table>

<https://www.youtube.com/watch?v=vvhC64hQZMk>
