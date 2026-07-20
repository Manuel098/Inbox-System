import axios from "axios";

export const api = axios.create({
    // @ts-expect-error
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        "Content-Type": "application/json",
    },
});