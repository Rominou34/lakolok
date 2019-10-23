import axios from "axios";

export default {
    signup(user) {
        return axios.post("/api/users/signup", user);
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