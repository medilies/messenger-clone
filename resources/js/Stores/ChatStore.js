import { defineStore } from "pinia";

export const useChatStore = defineStore("chat", {
    state: () => ({
        currentChat: null,
    }),
    getters: {},
    actions: {},
});
