import { client } from "../api";
import { ENDPOINTS } from "../api/endpoints";

export const MessageService = {
    async getNotificationList() {
        try {
            const { data } = await client.get( ENDPOINTS.listNotifications );
            return data;
        } catch(e) {
            console.error(e)
        }
        
    },
};