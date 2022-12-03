import authGuard from "./guardes/authGuard";
import visitorGuard from "./guardes/visitorGuard";
import LoginPage from "./pages/LoginPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";
import authRoutes from "./routes";
import {
    authenticatedGet,
    authenticatedPost,
} from "./Services/AuthenticatedRequest";
import authorizationHeader from "@/modules/auth/Services/AuthorizationHeaderService";
import { useAuthStore } from "./store/AuthStore";

export {
    authGuard,
    visitorGuard,
    LoginPage,
    RegisterPage,
    authRoutes,
    authenticatedGet,
    authenticatedPost,
    authorizationHeader,
    useAuthStore,
};
