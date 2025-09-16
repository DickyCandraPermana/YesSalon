import { createRouter, createWebHistory } from "vue-router";

import Home from "../views/Home.vue";
import About from "../views/About.vue";
import Midtrans from "../views/Midtrans.vue";

const routes = [
    { path: "/", name: "Home", component: Home },
    { path: "/about", name: "About", component: About },
    { path: "/midtrans", name: "Midtrans", component: Midtrans },
    {
        path: "/email/verify/:id/:hash",
        name: "email.verify",
        component: () => import("../views/EmailVerify.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
