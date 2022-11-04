import { createRouter, createWebHashHistory } from "vue-router";

import Chat from "../Components/Chat.vue";

const routes = [
    {
        path: "/",
        component: Chat,
    },
];

export default createRouter({
    history: createWebHashHistory(),
    routes,
});
