import { createRouter, createWebHistory } from "vue-router";

import LoginPage from "../pages/LoginPage.vue";
import HomePage from "../pages/HomePage.vue";

import authGuard from "./authGuard";
import visitorGuard from "./visitorGuard";

const routes = [
    {
        path: "/",
        component: HomePage,
        beforeEnter: [authGuard],
    },
    {
        path: "/login",
        component: LoginPage,
        beforeEnter: [visitorGuard],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
