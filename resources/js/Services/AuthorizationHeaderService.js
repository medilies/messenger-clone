import { useAuthStore } from "@/Stores/AuthStore";

const authorizationHeader = () => {
    const authStore = useAuthStore();

    let bearerToken = authStore.bearerToken;

    if (bearerToken) {
        return {
            accept: "application/json",
            Authorization: "Bearer " + bearerToken,
        };
    }

    return {};
};

export default authorizationHeader;
