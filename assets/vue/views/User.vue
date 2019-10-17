<template>
    <div>
        <div class="row col">
            <h1>User {{ $route.params.id }}</h1>
        </div>

        <div class="row col">
            <p>User page.</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "User"
};
</script>