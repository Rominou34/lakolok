<template>
    <div id="spendings">
        <h1>Errands</h1>
        <div class="container">
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
            <div v-if="errands.length">
                <div v-for="errand in errands" v-bind:key="errand.id" class="card">
                    <h5 class="card-header">
                        {{ errand.name }}
                    </h5>
                    <div class="card-body">
                    </div>
                    <div class="card-body">
                        <button v-on:click.prevent="newItem(errand)" class="btn btn-primary">
                            Add an item
                        </button>
                    </div>
                </div>
            </div>
            <!-- Displayed if no errand found !-->
            <div class="text-center" v-if="loaded && !errands.length">
                <p>
                    No errands found
                </p>
                <button type="button" class="btn btn-primary"
                    v-on:click="newErrand()">
                    Create a new one
                </button>
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
        }
    }
};
</script>