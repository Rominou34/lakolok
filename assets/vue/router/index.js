import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import User from "../views/User";
import UserList from "../views/UserList";
import Signup from "../views/Signup";
import Spendings from "../views/Spendings";
import Errands from "../views/Errands";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home },
        { path: "*", redirect: "/" },
        { path: "/users", component: UserList },
        { path: "/user/:id", component: User },
        { path: "/signup", component: Signup },
        { path: "/spendings", component: Spendings },
        { path: "/errands", component: Errands }
    ]
});