<template>
    <div id="main-container">
        <header>
            <!--
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <router-link class="navbar-brand" to="/home">App</router-link>
                <router-link class="nav-item" to="/spendings" active-class="active">Spendings</router-link>
                <router-link class="nav-item" to="/users" active-class="active">Users</router-link>
            </nav>
            !-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <router-link class="navbar-brand" to="/">App</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-content">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/spendings">Spendings</router-link>
                        </li>
                        <li>
                            <router-link class="nav-link" to="/users">Users</router-link>
                        </li>
                    </ul>
                    <div class="navbar-nav">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                User
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                <router-link class="dropdown-item" to="/user/1">Profile</router-link>
                                <router-link class="dropdown-item" to="/lougout">Logout</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div id="content" class="container" style="margin-top: 56px">
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "App"
};
</script>