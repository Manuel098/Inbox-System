import { client } from "../api";
import { ENDPOINTS } from "../api/endpoints";
import { createThreadProps } from "../interfaces/ServicesInterfaces";

export const ThreadService = {
    async getAll() {
        const { data } = await client.get(ENDPOINTS.threads);
        return data;
    },

    async create(payload: createThreadProps) {
        const { data } = await client.post(
            ENDPOINTS.threads,
            payload
        );

        return data;
    },
};