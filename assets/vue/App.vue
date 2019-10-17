<template>
    <div id="main-container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <router-link class="navbar-brand" to="/home">App</router-link>
                <router-link class="nav-item" to="/user/1" active-class="active">User</router-link>
            </nav>
        </header>

        <div id="content">
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "App"
};
</script>