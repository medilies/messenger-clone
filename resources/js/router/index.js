import { createRouter, createWebHistory } from "vue-router";

import LoginPage from "../pages/LoginPage.vue";
import HomePage from "../pages/HomePage.vue";

const routes = [
    {
        path: "/",
        component: HomePage,
    },
    {
        path: "/login",
        component: LoginPage,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
