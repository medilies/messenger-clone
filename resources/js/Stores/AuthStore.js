import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        bearerToken: null,
    }),
    getters: {},
    actions: {
        setAuthFromResponse(response) {
            this.user = response.data.user;
            this.bearerToken = response.data.token;

            sessionStorage.setItem(
                "bearerToken",
                JSON.stringify(response.data.token)
            );

            sessionStorage.setItem("user", JSON.stringify(response.data.user));
        },
    },
});
