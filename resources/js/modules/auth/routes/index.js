import LoginPage from "@/modules/auth/pages/LoginPage.vue";
import RegisterPage from "@/modules/auth/pages/RegisterPage.vue";
import visitorGuard from "@/modules/auth/guardes/visitorGuard";

export default [
    {
        path: "/login",
        name: "login",
        component: LoginPage,
        beforeEnter: [visitorGuard],
    },
    {
        path: "/register",
        name: "register",
        component: RegisterPage,
        beforeEnter: [visitorGuard],
    },
];
