import axios from "axios";

export default {
    create(message) {
        return axios.post("/api/users", {
            message: message
        });
    },
    findAll() {
        return axios.get("/api/users");
    },
    get(id) {
        return axios.get("/api/user/" + id);
    }
};