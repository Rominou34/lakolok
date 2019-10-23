<template>
    <div id="spendings">
        <h1>Spendings</h1>
        <div class="container">
            {{ new_spending }}
            <div class="container">
                <form v-on:submit.prevent="saveSpending(new_spending)">
                    <div class="form-row">
                        <div class="col-3">
                            <label for="new-spending-name" class="sr-only">Name</label>
                            <input type="text" class="form-control" id="new-spending-name"
                                v-model="new_spending.name" placeholder="Name"/>
                        </div>
                        <div class="col-2">
                            <label for="new-spending-amount" class="sr-only">Amount</label>
                            <input type="number" class="form-control" id="new-spending-amount"
                                v-model="new_spending.amount" placeholder="Amount"/>
                        </div>
                        <div class="col-3">
                            <label for="new-spending-user" class="sr-only">User</label>
                            <select class="form-control" id="new-spending-user"
                                v-model="new_spending.user">
                                <option v-for="user in users" v-bind:value="user.id" v-bind:key="user.id">
                                    {{ user.name }} {{ user.lastname }}
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="new-spending-date" class="sr-only">Date</label>
                            <input type="date" class="form-control" id="new-spending-date"
                                v-model="new_spending.date" placeholder="Date"/>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            {{ users }}
            <table class="table">
                <thead class="thead-light">
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
                    <tr v-if="!spendings.length">
                        <td colspan="4" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import SpendingAPI from "../api/spending";
import UserApi from "../api/user";

export default {
    name: "Spendings",
    data() {
        return {
            spendings: [],
            new_spending: {},
            users: []
        }
    },
    created() {
        SpendingAPI.getAll().then((response) => {
            this.spendings = response.data
        });
        UserApi.getAllShort().then((response) => {
            this.users = response.data;
        });
    },
    methods: {
        saveSpending(spending) {
            console.log(spending);
            console.log(spending.name);
        }
    }
};
</script>