import { authGuard } from "@/modules/auth";

import MessagesPage from "@/modules/chat/pages/MessagesPage.vue";

import TheConversation from "@/modules/chat/Components/TheConversation.vue";
import Inbox from "@/modules/chat/Components/Inbox.vue";

export default [
    {
        path: "/chat",
        name: "chat",
        component: MessagesPage,
        beforeEnter: [authGuard],
        children: [
            {
                path: "inbox",
                name: "chat.inbox",
                component: Inbox,
                beforeEnter: [authGuard],
            },
            {
                path: "conversations/:conversation_id",
                name: "chat.conversation",
                component: TheConversation,
                beforeEnter: [authGuard],
            },
        ],
    },
];
