import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import User from "../views/User";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home },
        { path: "*", redirect: "/" },
        { path: "/user/:id", component: User }
    ]
});