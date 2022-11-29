import { useAuthStore } from "@/Stores/AuthStore";

export default function visitorGuard(to, from) {
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
        return from.href || "/";
    }
}
