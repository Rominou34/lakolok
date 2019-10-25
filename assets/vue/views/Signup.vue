<template>
    <div id="signup">
        <h1>Signup</h1>
        <form v-on:submit.prevent="signup()">
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="signup-login" class="sr-only">Login</label>
                    <input type="text" class="form-control" id="signup-login"
                        v-model="user.login" placeholder="Login"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="signup-name" class="sr-only">Name</label>
                    <input type="text" class="form-control" id="signup-name"
                        v-model="user.name" placeholder="Name"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="signup-mail" class="sr-only">E-mail</label>
                    <input type="mail" class="form-control" id="signup-email"
                        v-model="user.mail" placeholder="E-mail"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="signup-password" class="sr-only">Password</label>
                    <input type="password" class="form-control" id="signup-password"
                        v-model="user.password" placeholder="Password"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="signup-confirm" class="sr-only">Confirm password</label>
                    <input type="password" class="form-control" id="signup-confirm"
                        v-model="user.confirm" placeholder="Confirm password"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="signup-nickname" class="sr-only">Nickname</label>
                    <input type="text" class="form-control" id="signup-nickname"
                        v-model="user.nickname" placeholder="Nickname"/>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    Signup
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import UserAPI from "../api/user";

export default {
    name: "Signup",
    data() {
        return {
            user: {}
        }
    },
    methods: {
        signup() {
            UserAPI.signup(this.user).then((response) => {
                console.log(response);
            });
            console.log(this.user);
        }
    }
}
</script>

<style scoped>
    #signup {
        max-width: 320px;
        margin: auto;
    }
</style>