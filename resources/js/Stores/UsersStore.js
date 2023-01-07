import { defineStore } from "pinia";

import { authenticatedGet } from "@/modules/auth/Services/AuthenticatedRequest";

export const useUsersStore = defineStore("users", {
    state: () => ({
        users: [],
    }),
    getters: {},
    actions: {
        refreshUsers() {
            authenticatedGet("/api/users").then((response) => {
                // console.log(response.data);

                this.users = response.data;
            });
        },
    },
});
