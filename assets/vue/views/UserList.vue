<template>
    <div id="userlist">
        <table class="hover">
            <thead>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Login</th>
                <th>Email</th>
                <th>Surnom</th>
            </thead>
            <tbody>
                <router-link v-for="user in users" v-bind:key="user.id"
                    v-bind:to="'/user/'+user.id" tag="tr" class="clickable">
                    <td>{{ user.lastname }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.login }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.nickname }}</td>
                </router-link>
            </tbody>
        </table>
    </div>
</template>

<script>
import UserAPI from "../api/user";

export default {
    name: "UserList",
    data() {
        return {
            users: []
        }
    },
    created() {
        UserAPI.getAll().then((response) => {
            this.users = response.data
        });
    },
    methods: {}
};
</script>