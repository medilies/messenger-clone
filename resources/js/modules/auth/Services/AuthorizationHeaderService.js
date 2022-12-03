import { useAuthStore } from "@/modules/auth";

const authorizationHeader = () => {
    const authStore = useAuthStore();

    let bearerToken = authStore.bearerToken;

    if (bearerToken) {
        return {
            Accept: "application/json",
            Authorization: "Bearer " + bearerToken,
        };
    }

    return {};
};

export default authorizationHeader;
