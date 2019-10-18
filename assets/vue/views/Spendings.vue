<template>
    <div id="spendings">
        <table>
            <thead>
                <th>Name</th>
                <th>Amount</th>
                <th>User</th>
                <th>Date</th>
            </thead>
            <tbody>
                <tr v-for="spending in spendings" v-bind:key="spending.id">
                    <td>{{ spending.lib }}</td>
                    <td>{{ spending.amount }}</td>
                    <td>
                        <router-link v-bind:to="'/user/' + spending.userid" tag="a" class="pointer hover-underline">
                            {{ spending.username }}
                        </router-link>
                    </td>
                    <td>{{ spending.date }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import SpendingAPI from "../api/spending";

export default {
    name: "Spendings",
    data() {
        return {
            spendings: []
        }
    },
    created() {
        SpendingAPI.getAll().then((response) => {
            this.spendings = response.data
        });
    },
    methods: {}
};
</script>