import { createRouter, createWebHistory } from "vue-router";

import Chat from "../Components/Chat.vue";

const routes = [
    {
        path: "/",
        component: Chat,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
