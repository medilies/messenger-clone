import { authGuard } from "@/modules/auth";
import MessagesPage from "@/modules/chat/pages/MessagesPage.vue";
import TheChat from "@/modules/chat/Components/TheChat.vue";

export default [
    {
        path: "/messages",
        name: "messages",
        component: MessagesPage,
        beforeEnter: [authGuard],
        children: [
            {
                path: "direct/:direct_messages_target_user_id",
                name: "messages.direct",
                component: TheChat,
                beforeEnter: [authGuard],
            },
        ],
    },
];
