import { client } from "../api";
import { ENDPOINTS } from "../api/endpoints";
import { signInProps } from "../interfaces/ServicesInterfaces";

export const MessageService = {
    async signIn(payload: signInProps) {
        try {
            const { data } = await client.post( ENDPOINTS.signIn, payload);
            return data;
        } catch(e) {
            console.error(e)
        }
    },

    async getUser() {
        try {
            const { data } = await client.post( ENDPOINTS.user);
            return data;
        } catch(e) {
            console.error(e)
        }
    },

};
