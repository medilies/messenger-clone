import { createRouter, createWebHistory } from "vue-router";

import LoginPage from "../pages/LoginPage.vue";
import RegisterPage from "../pages/RegisterPage.vue";
import HomePage from "../pages/HomePage.vue";

import authGuard from "./authGuard";
import visitorGuard from "./visitorGuard";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomePage,
        beforeEnter: [authGuard],
    },
    {
        path: "/login",
        name: "login",
        component: LoginPage,
        beforeEnter: [visitorGuard],
    },
    {
        path: "/register",
        name: "register",
        component: RegisterPage,
        beforeEnter: [visitorGuard],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
