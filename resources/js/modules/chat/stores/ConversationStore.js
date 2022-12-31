import { authenticatedGet } from "@/modules/auth";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useConversationStore = defineStore("conversation", () => {
    const conversations = ref({});

    function refreshConversations() {
        authenticatedGet("/api/conversations").then((response) => {
            console.log(response.data);

            conversations.value = response.data;
        });
    }

    return {
        conversations,
        refreshConversations,
    };
});
