import { authGuard } from "@/modules/auth";
import MessagesPage from "@/modules/chat/pages/MessagesPage.vue";

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
    },
];
