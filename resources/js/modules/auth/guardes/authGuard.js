import { useAuthStore } from "@/modules/auth/store/AuthStore";

export default function authGuard(to, from) {
    const authStore = useAuthStore();

    if (!authStore.isAuthenticated) {
        return "/login";
    }
}
