import axios from "axios";

const url = "/api"

const instance = axios.create({
    baseURL: url,
    withCredentials: false,
    headers: {
        accept: 'application/json',
    }
})

export default instance
