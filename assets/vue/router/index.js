import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import User from "../views/User";
import UserList from "../views/UserList";
import Spendings from "../views/Spendings";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home },
        { path: "*", redirect: "/" },
        { path: "/users", component: UserList },
        { path: "/user/:id", component: User },
        { path: "/spendings", component: Spendings }
    ]
});