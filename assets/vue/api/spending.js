import axios from "axios";

export default {
    create(message) {
        return axios.post("/api/spendings", {
            message: message
        });
    },
    getAll() {
        return axios.get("/api/spendings");
    },
    get(id) {
        return axios.get("/api/spending/" + id);
    }
};