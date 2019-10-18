<template>
    <div id="main-container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <router-link class="navbar-brand" to="/home">App</router-link>
                <router-link class="nav-item" to="/spendings" active-class="active">Spendings</router-link>
                <router-link class="nav-item" to="/users" active-class="active">Users</router-link>
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