import axios from "axios";

export default {
    create(message) {
        return axios.post("/api/users", {
            message: message
        });
    },
    getAll() {
        return axios.get("/api/users");
    },
    getAllShort() {
        return axios.get("api/users/short");
    },
    get(id) {
        return axios.get("/api/user/" + id);
    }
};