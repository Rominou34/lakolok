<template>
    <div id="spendings">
        <h1>Errands</h1>
        <div class="container" v-if="loaded">
            <!-- New errand form !-->
            <div class="card" v-if="new_errand">
                <div class="card-body">
                    <form v-on:submit.prevent="createErrand(new_errand)" class="container">
                        <p class="bold">New errand</p>
                        <div class="form-row">
                            <div class="col-9">
                                <label for="new-errand-name" class="sr-only">Name</label>
                                <input type="text" class="form-control" id="new-errand-name"
                                    v-model="new_errand.name" placeholder="Name" required/>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- List of errands !-->
            <div v-if="errands.length && !new_errand">
                <div v-for="errand in errands" v-bind:key="errand.id" class="card">
                    <h5 class="card-header">
                        {{ errand.name }}
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-if="!errand.items.length">
                            No items
                        </li>
                        <li v-for="item in errand.items" v-bind:key="item.id" class="list-group-item">
                            <span v-if="!item.editing">{{ item.name }}</span>
                            <div v-if="item.editing">
                                <form v-on:submit.prevent="saveItem(item, errand)">
                                    <input type="text" v-model="item.name"/>
                                    <button type="submit">Save</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <div class="card-body">
                        <button v-on:click.prevent="newItem(errand)" class="btn btn-secondary">
                            Add an item
                        </button>
                    </div>
                </div>
            </div>
            <!-- Displayed if no errand found !-->
            <div class="text-center" v-if="!errands.length && !new_errand">
                <p>
                    No errands found
                </p>
            </div>
            <br/>
            <button type="button" v-on:click="newErrand()" class="btn btn-primary text-center">
                Create a new errand
            </button>
        </div>
        <!-- Loader !-->
        <div v-if="!loaded" class="container text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import ErrandApi from "../api/errand";

export default {
    name: "Errands",
    data() {
        return {
            errands: [],
            new_errand: false,
            loaded: false
        }
    },
    created() {
        this.getErrands();
        ErrandApi.getAll().then((response) => {
            this.errands = response.data;
        });
    },
    methods: {
        getErrands() {
            ErrandApi.getAll().then((response) => {
                this.loaded = true;
                this.errands = response.data;
            });
        },
        newErrand() {
            this.new_errand = {
                name: ''
            }
        },
        createErrand(errand) {
            console.log(errand);
            ErrandApi.new(errand).then((response) => {
                console.log(response);
                if(response.data && response.data.errand) {
                    console.log(response.data.errand);
                    this.errands.push(response.data.errand);
                    this.new_errand = false;
                }
            });
        },
        newItem(errand) {
            errand.items.push({
                name: '',
                bought: false,
                editing: true,
                errand: errand.id
            });
        },
        saveItem(item, errand) {
            if(item.id) {
                ErrandApi.updateItem(item).then((response) => {
                    console.log(response);
                    if(response.data && response.data.item) {
                        console.log(response.data.item);
                        item = response.data.item;
                    }
                });
            } else {
                ErrandApi.createItem(item).then((response) => {
                    console.log(response);
                    if(response.data && response.data.item) {
                        item.editing = false;
                    }
                });
            }
        }
    }
};
</script>