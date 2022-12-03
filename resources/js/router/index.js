import { createRouter, createWebHistory } from "vue-router";

import { authRoutes } from "@/modules/auth";

import HomePage from "../pages/HomePage.vue";

import authGuard from "@/modules/auth/guardes/authGuard";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomePage,
        beforeEnter: [authGuard],
    },
    ...authRoutes,
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
