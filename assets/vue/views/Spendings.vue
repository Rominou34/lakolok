<template>
    <div id="spendings">
        <h1>Spendings</h1>
        <div class="container">
            {{ new_spending }}
            <div class="card">
                <div class="card-body">
                    <form v-on:submit.prevent="filterResults()" class="container">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="search-name">Name</label>
                                <input type="text" class="form-control" id="search-name"
                                    v-model="search.name" placeholder="Name"/>
                            </div>
                            <div class="col-md-3">
                                <label for="search-min">Price min</label>
                                <input type="number" class="form-control" id="search-min"
                                    v-model="search.price.min" placeholder="Min"/>
                            </div>
                            <div class="col-md-3">
                                <label for="search-max">Price max</label>
                                <input type="number" class="form-control" id="search-max"
                                    v-model="search.price.max" placeholder="Max"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="search-period">Period</label>
                                <input type="date" class="form-control" id="search-period"
                                    v-model="search.period" placeholder="Period"/>
                            </div>
                            <div class="col-md-3 align-self-md-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Search
                                </button>
                            </div>
                            <div class="col-md-3 align-self-md-end">
                                <button type="button" class="btn btn-secondary btn-block"
                                    v-on:click="new_spending = {}">
                                    New
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body" v-if="new_spending">
                    <form v-on:submit.prevent="createSpending(new_spending)" class="container">
                        <div class="form-row">
                            <div class="col-3">
                                <label for="new-spending-name" class="sr-only">Name</label>
                                <input type="text" class="form-control" id="new-spending-name"
                                    v-model="new_spending.name" placeholder="Name" required/>
                            </div>
                            <div class="col-2">
                                <label for="new-spending-amount" class="sr-only">Amount</label>
                                <input type="number" class="form-control" id="new-spending-amount"
                                    v-model="new_spending.amount" placeholder="Amount" required/>
                            </div>
                            <div class="col-3">
                                <label for="new-spending-user" class="sr-only">User</label>
                                <select class="form-control" id="new-spending-user"
                                    v-model="new_spending.user" required>
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
                        <td>{{ spending.name }}</td>
                        <td>{{ spending.amount }}</td>
                        <td>
                            <router-link v-bind:to="'/user/' + spending.userid" tag="a" class="pointer hover-underline">
                                {{ spending.username }}
                            </router-link>
                        </td>
                        <td>{{ spending.displayDate }}</td>
                    </tr>
                    <tr v-if="!loaded">
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
import UserAPI from "../api/user";

export default {
    name: "Spendings",
    data() {
        return {
            search: {
                price: {}
            },
            spendings: [],
            new_spending: false,
            users: [],
            loaded: false
        }
    },
    created() {
        this.getSpendings();
        UserAPI.getAllShort().then((response) => {
            this.users = response.data;
        });
    },
    methods: {
        getSpendings() {
            SpendingAPI.getAll().then((response) => {
                this.loaded = true;
                this.spendings = response.data
                this.spendings.forEach(spending => {
                    if(typeof spending.date != "undefined") {
                        spending.displayDate = new Date(spending.date).toLocaleDateString();
                    }
                });
            });
        },
        createSpending(spending) {
            console.log(spending);
            SpendingAPI.new(spending).then((response) => {
                console.log(response);
                if(response.data && response.data.spending) {
                    console.log(response.data.spending);
                    this.spendings.push(response.data.spending);
                    this.new_spending = false;
                }
            });
        }
    }
};
</script>