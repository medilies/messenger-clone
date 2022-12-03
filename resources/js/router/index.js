import { createRouter, createWebHistory } from "vue-router";

import { authRoutes } from "@/modules/auth";
import { chatRoutes } from "@/modules/chat";

const routes = [...authRoutes, ...chatRoutes];

export default createRouter({
    history: createWebHistory(),
    routes,
});
