import { authGuard } from "@/modules/auth";
import MessagesPage from "@/modules/chat/pages/MessagesPage.vue";
import TheChat from "@/modules/chat/Components/TheChat.vue";

export default [
    {
        path: "/",
        name: "home",
        component: MessagesPage,
        beforeEnter: [authGuard],
    },
    {
        path: "/messages",
        name: "messages",
        component: MessagesPage,
        beforeEnter: [authGuard],
        children: [
            {
                path: "direct/:id",
                name: "messages.direct",
                component: TheChat,
                beforeEnter: [authGuard],
            },
        ],
    },
];
