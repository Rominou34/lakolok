import axios from "axios";

export default {
    new(spending) {
        return axios.post("/api/spendings/new", spending);
    },
    getAll() {
        return axios.get("/api/spendings");
    },
    get(id) {
        return axios.get("/api/spendings/" + id);
    },
};