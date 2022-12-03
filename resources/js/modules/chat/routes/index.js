import { authGuard } from "@/modules/auth";
import HomePage from "@/modules/chat/pages/HomePage.vue";

export default [
    {
        path: "/",
        name: "home",
        component: HomePage,
        beforeEnter: [authGuard],
    },
];
