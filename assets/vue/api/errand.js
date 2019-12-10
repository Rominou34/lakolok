import axios from "axios";

export default {
    new(errand) {
        return axios.post("/api/errands/new", errand);
    },
    getAll() {
        return axios.get("/api/errands");
    },
    get(id) {
        return axios.get("/api/errands/" + id);
    },
};