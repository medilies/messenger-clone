# Messenger clone

## Features

### System features

1. Listing contacts.
2. Searching for a contact.
3. Direct messages.
4. Group messages.
5. Replying to messages.
6. Replying to messages in threads.
7. Sending media.
8. Sending vocal messages.
9. Indicating the connection status of a contact.
10. Indicating when a contact was last seen if not connected.
11. Signaling if user is typing.
12. Reporting the message state sending - sent - delivered - seen.
13. Searching for a message in a conversation.
14. Editing a message, and wether to keep the history of changes or not.
15. Deleting a message.

### Front end only features

1. Auto-scrolling down when entering a conversation.
2. Showing a notification when a user isn't in the conversation.
3. Showing a count of not seen messages.
4. Getting stored messages from the backend.
5. Caching messages.
6. Show a separator when there is a considerable time interval between messages.

## Architecture

Like most of cloud apps. This app will need a:

-   **Database** for storing users data and messages.
-   Backend services for handling API calls, **authentication**, **session management**, **authorization** and **file management**.

In a classical way, **Laravel** with **MySQL** can handle all the above. But now the special part is enabling realtime messaging, if you are a lazy engineer and do not care about your client/employer bills its ok to pick **Firebase** to handle the messaging part. But if you have enough experience you already know that realtime data needs to be mobilized using realtime protocols such as `websocket`, and you are asking your self which websocket server implementation to couple with the chosen backend.

**Laravel** comes bundled with tools that support, **events**, **notifications**, **broadcasting**, and **queues**. But doesn't support any realtime protocol out of the box but instead of letting us stray alone looking for websocket servers to couple with **Laravel**. It eases and recommends the integration of [Pusher](https://pusher.com/) or [Ably](https://ably.com/). Even better, the community maintains packages that can be used as alternative, compatible, self hosted APIs for **Pusher**.

1. [Laravel Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction) is a PHP package built on top of [Ratchet](http://socketo.me/), [read more...](https://freek.dev/1228-introducing-laravel-websockets-an-easy-to-use-websocket-server-implemented-in-php).
2. [Soketi](https://soketi.app/) is a NodeJS package built on top of µWebSockets.js.

My preference is `laravel-websockets` for the simple fact of being able to maintain it in one repository with the **Laravel** backend.

For the client side `pusher-js` library is the go to, and `laravel-echo` makes it even easier to use publish and subscribe from the browsers.

To be more exhaustive, this demo will be using `sanctum` for authenticating API calls. And `axios` as a front end HTTP client.

### Scaling

<https://beyondco.de/docs/laravel-websockets/faq/scaling>

## Database

Supporting group events has a huge impact on the database design!

## Scaffolding

```shell
laravel new --git messenger-clone
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

The following config makes it easy to switch between **Pusher** and **Laravel Websockets**.

```env
# .env
APP_URL=http://127.0.0.1:8000

BROADCAST_DRIVER=pusher

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=#api-CLUSTER.pusher.com or 127.0.0.1
PUSHER_PORT=443# or any other port (recommend 6001 for Laravel Websockets)
PUSHER_SCHEME=https# or http
PUSHER_APP_CLUSTER=

LARAVEL_WEBSOCKETS_ENABLE_CLIENT_MESSAGES=true

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
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
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'host' => env('PUSHER_HOST', 'api-'.env('PUSHER_APP_CLUSTER', 'eu').'.pusher.com') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'eu').'.pusher.com',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
                // Added
                'cluster' => env('PUSHER_APP_CLUSTER', 'eu'),
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
            'id' => env('PUSHER_APP_ID'),
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
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
                axios
                    .post(
                        "/broadcasting/auth",
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
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    // ...
});
```

```php
// app\Providers\BroadcastServiceProvider.php
    public function boot()
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]);

        require base_path('routes/channels.php');
    }
```

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::fallback(fn() => view('app'));
```

### SSL

<https://beyondco.de/docs/laravel-websockets/basic-usage/ssl>

## Laravel broadcasting

### Channels

-   Events are broadcast over "channels", which may be specified as **public** or **private**.
-   Any visitor may subscribe to a **public channel** without any **authentication** or **authorization**.
-   In order to subscribe to a **private channel**, a user must be **authenticated** and **authorized** to listen on that channel.

Instances of `Channel` represent **public channels** that any user may subscribe to, while `PrivateChannels` and `PresenceChannels` represent **private channels** that require **authorization**.

### Events

#### ShouldBroadcast

Broadcastable events must implement the `Illuminate\Contracts\Broadcasting\ShouldBroadcast` interface, This will instruct Laravel to broadcast the event when it is fired.

#### broadcastOn

The `ShouldBroadcast` interface requires the event to define a `broadcastOn` method. The method returns the channel to broadcast the event on.

-   `Illuminate\Broadcasting\Channel`,
-   `Illuminate\Broadcasting\PrivateChannel`
-   `Illuminate\Broadcasting\PresenceChannel`

#### broadcastAs

By default, Laravel will broadcast the event using the event's class name. However, you may customize the broadcast name.

```php
/**
 * The event's broadcast name.
 */
public function broadcastAs()
{
    return 'EventName';
}
```

#### broadcastWith

When an event is broadcast, all of its `public` properties are automatically serialized and broadcast as the event's payload.

```php
/**
 * Get the data to broadcast.
 */
public function broadcastWith()
{
    return $data;
}
```

#### broadcastWhen

Sometimes you want to broadcast your event only if a given condition is true.

```php
/**
 * Determine if this event should broadcast.
 */
public function broadcastWhen()
{
    return true;
}
```

#### broadcastQueue

Once the event has been fired, a queued job will automatically broadcast the event using your specified broadcast driver.

By default, each broadcast event is placed on the default queue for the default queue connection specified in `config\queue.php` file.

...

#### afterCommit

...

### Authorization

Authorizing that the currently authenticated user can actually listen on the **private channel** is accomplished by, making an HTTP request to your Laravel application with the channel name, and allowing your application to determine if the user can listen on that channel.

When using `Echo`, the HTTP request to **authorize subscriptions** to **private channels** will be made automatically; however, you do need to define the proper routes to respond to these requests.

In `app\Providers\BroadcastServiceProvider.php`, the `Broadcast::routes` method registers the `/broadcasting/auth` route to handle authorization requests. The method will automatically place its routes within the `web` **middleware group**; however, you may pass an array of route attributes to the method if you would like to customize the assigned attributes.

Channel authorization rules are defined in `routes/channels.php`.

```php
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('name.{param}', function (User $user, bool|int|string|float $param): bool {
    // true = authorized
    return auth()->check();
});
```

### Echo

```js
Echo.private(`name.${param}`).listen("SomeEvent", (e) => {
    console.log(e);
});
```

#### Custom authorization endpoint

By default, `Echo` will use the `/broadcasting/auth` endpoint to authorize channel access. However, you may customize it.

```js
window.Echo = new Echo({
    broadcaster: "pusher",
    // ...
    authEndpoint: "/custom/endpoint/auth",
});
```

#### Customizing the authorization request

...

## References

### Laravel docs refs

-   <https://laravel.com/docs/9.x/queues>
-   <https://laravel.com/docs/9.x/events>
-   <https://laravel.com/docs/9.x/notifications>
-   <https://laravel.com/docs/9.x/broadcasting>
-   <https://laravel.com/docs/9.x/sanctum>

### Database Design refs

-   <https://www.youtube.com/watch?v=xL_tYrEcP9M>
-   <https://towardsdatascience.com/ace-the-system-interview-design-a-chat-application-3f34fd5b85d0>
-   <https://stackoverflow.com/questions/46484989/database-schema-for-chat-private-and-group>
-   <https://stackoverflow.com/questions/39810106/storing-messages-of-different-chats-in-a-single-database-table>

### Architecture refs

-   <https://devtechnosys.com/messaging-app-development.php>
-   <https://www.youtube.com/watch?v=vvhC64hQZMk>

### Laravel Webcockets refs

-   <https://beyondco.de/docs/laravel-websockets/getting-started/introduction>
-   <https://www.youtube.com/watch?v=xKru8j9LXjA>
-   <https://www.youtube.com/watch?v=pd8LmGxt5Og&list=PLSfH3ojgWsQosqpQUc28yP9jJZXrEylJY&index=47> \[45-52\]
-   <https://www.youtube.com/watch?v=UwB5z6u7vt8>
