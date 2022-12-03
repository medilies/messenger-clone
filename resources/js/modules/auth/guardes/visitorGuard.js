import { useAuthStore } from "@/modules/auth";

export default function visitorGuard(to, from) {
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
        return from.href || "/";
    }
}
