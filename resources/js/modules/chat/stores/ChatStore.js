import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAuthStore } from "@/modules/auth/store/AuthStore";
import { useRoute } from "vue-router";

export const useChatStore = defineStore("chat", () => {
    const route = useRoute();

    const messages = ref({});

    const getCurrentChatMessages = computed(() => {
        if (!messages.value[parseInt(route.params.conversation_id)]) {
            messages.value[parseInt(route.params.conversation_id)] = [];
        }

        return messages.value[parseInt(route.params.conversation_id)];
    });

    function storeNewMessage(message) {
        // console.log(message);

        let chatId = message.conversation_id;

        if (!messages.value[chatId]) {
            messages.value[chatId] = [];
        }

        messages.value[chatId].push(message);
    }

    // TODO: optimize this logic
    function mergeOlderMessages(chatId, oldMessages) {
        chatId = parseInt(chatId);

        if (!messages.value[chatId]) {
            messages.value[chatId] = [];
        }

        messages.value[chatId] = oldMessages;
    }

    return {
        messages,
        getCurrentChatMessages,
        storeNewMessage,
        mergeOlderMessages,
    };
});
