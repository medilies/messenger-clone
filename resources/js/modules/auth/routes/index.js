import { visitorGuard, LoginPage, RegisterPage } from "@/modules/auth";

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
