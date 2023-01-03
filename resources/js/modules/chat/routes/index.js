import { authGuard } from "@/modules/auth";

import MessagesPage from "@/modules/chat/pages/MessagesPage.vue";

import TheChat from "@/modules/chat/Components/TheChat.vue";
import Inbox from "@/modules/chat/Components/Inbox.vue";

export default [
    {
        path: "/messages",
        name: "messages",
        component: MessagesPage,
        beforeEnter: [authGuard],
        children: [
            {
                path: "inbox",
                name: "messages.inbox",
                component: Inbox,
                beforeEnter: [authGuard],
            },
            {
                path: "direct/:conversation_id",
                name: "messages.direct",
                component: TheChat,
                beforeEnter: [authGuard],
            },
        ],
    },
];
