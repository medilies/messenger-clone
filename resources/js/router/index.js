import { createRouter, createWebHistory } from "vue-router";

import HomePage from "@/pages/HomePage.vue";

import { authGuard, authRoutes } from "@/modules/auth";
import { chatRoutes } from "@/modules/chat";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomePage,
        beforeEnter: [authGuard],
    },
    ...authRoutes,
    ...chatRoutes,
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
