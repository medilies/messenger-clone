import { defineStore } from "pinia";

export const useUsersStore = defineStore("users", {
    state: () => ({
        users: null,
    }),
    getters: {},
    actions: {},
});
