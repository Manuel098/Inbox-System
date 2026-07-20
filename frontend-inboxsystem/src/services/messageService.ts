import { client } from "../api";
import { ENDPOINTS } from "../api/endpoints";
import { storeMessageProps } from "../interfaces/ServicesInterfaces";

export const MessageService = {
    async getByThread(threadId: string) {
        try {
            const { data } = await client.get( ENDPOINTS.showThread.replaceAll("{thread}", threadId));
            return data;
        } catch(e) {
            console.error(e)
        }
        
    },

    async send(threadId: string, body: storeMessageProps) {
        const { data } = await client.post(ENDPOINTS.storeMessage.replaceAll("{thread}", threadId), body);

        return data;
    },
};