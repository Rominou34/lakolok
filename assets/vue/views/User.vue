<template>
    <div id="user">
        <div class="row col">
            <h1>
                {{ user.name }} {{ user.lastname }}
                <span v-if="user.nickname">({{ user.nickname }})</span>
            </h1>
            <hr/>
            <p>
                Login: {{ user.login }}
            </p>
            <p>
                E-mail: {{ user.mail }}
            </p>
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