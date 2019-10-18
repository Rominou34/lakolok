<template>
    <div id="user">
        <h1>{{ user.name }} {{ user.lastname }}</h1>
        <div class="container">
            <div class="row col">
                <h2>{{ user.nickname }}</h2>
                <hr/>
                <p>
                    Login: {{ user.login }}
                </p>
                <p>
                    E-mail: {{ user.mail }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import UserAPI from "../api/user";

export default {
    name: "User",
    data() {
        return {
            user: {}
        }
    },
    created() {
        UserAPI.get(this.$route.params.id).then((response) => {
            this.user = response.data
        });
    }
};
</script>