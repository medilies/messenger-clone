import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: JSON.parse(localStorage.getItem("user")),
        bearerToken: localStorage.getItem("bearerToken"),
    }),
    getters: {
        isAuthenticated(state) {
            if (state.user && state.bearerToken) {
                return true;
            }

            return false;
        },
    },
    actions: {
        setAuthFromResponse(response) {
            this.user = response.data.user;
            this.bearerToken = response.data.token;

            localStorage.setItem("bearerToken", response.data.token);

            localStorage.setItem("user", JSON.stringify(response.data.user));
        },

        invalidate() {
            this.user = null;
            this.bearerToken = null;

            localStorage.removeItem("user");
            localStorage.removeItem("bearerToken");
        },
    },
});
