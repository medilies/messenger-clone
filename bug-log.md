Starting the WebSocket server on port 6001...

New connection opened for app key 666.

**ILIES** sending `pusher:connection_established`

New connection opened for app key 666.

**JULY** sending `pusher:connection_established`

**JULY** received:

```JSON
{"event": "pusher:subscribe", "channel":"private-direct-messages.1"}
```

**JULY** sending `pusher_internal:subscription_succeeded`

**JULY** received:

```JSON
{"event":"pusher:subscribe", "channel_data": {"user_id":"1","user_info":true},"channel":"presence-chat"}
```

**JULY** sending `pusher_internal:subscription_succeeded`

```JSON
{"presence":{"ids":[1],"hash":{"1":true},"count":1}}
```

**ILIES** received:

```JSON
{"event":"pusher:subscribe", "channel":"private-direct-messages.11"}
```

**ILIES** sending `pusher_internal:subscription_succeeded`

**ILIES** received:

```JSON
{"event":"pusher:subscribe", "channel_data":{"user_id":"11","user_info":true}, "channel":"presence-chat"}
```

**ILIES** sending `pusher_internal:subscription_succeeded`

```JSON
{"presence":{"ids":[1,11],"hash":{"1":true,"11":true},"count":2}}
```

**JULY** sending

```JSON
{"event":"pusher_internal:member_added", "channel":"presence-chat", "data":{"user_id":"11","user_info":true}}
```

**ILIES** received:

```JSON
{"event":"client-typing","data":{"msg":"h"},"channel":"presence-chat"}
```

**ILIES** received:

```JSON
{"event":"client-typing","data":{"msg":"hi"},"channel":"presence-chat"}
```

**ILIES** received:

```JSON
{"event":"client-typing","data":{"msg":""},"channel":"presence-chat"}
```

**JULY** sending

```JSON
{"channel":"private-direct-messages.1","event":"App\\Events\\DirectMessageEvent","data":"hi message object"}
```

**JULY** received:

```JSON
{"event":"client-typing","data":{"msg":"s"},"channel":"presence-chat"}
```

**JULY** received:

```JSON
{"event":"client-typing","data":{"msg":"su"},"channel":"presence-chat"}
```

**JULY** received:

```JSON
{"event":"client-typing","data":{"msg":"sup"},"channel":"presence-chat"}
```

**JULY** received:

```JSON
{"event":"client-typing","data":{"msg":""},"channel":"presence-chat"}
```

**ILIES** sending

```JSON
{"channel":"private-direct-messages.11","event":"App\\Events\\DirectMessageEvent","data":"sub message object"}
```
