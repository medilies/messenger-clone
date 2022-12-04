import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAuthStore } from "@/modules/auth/store/AuthStore";
import { useRoute } from "vue-router";

export const useChatStore = defineStore("chat", () => {
    const authStore = useAuthStore();
    const route = useRoute();

    const messages = ref({});

    const getCurrentChatMessages = computed(() => {
        if (
            !messages.value[
                parseInt(route.params.direct_messages_target_user_id)
            ]
        ) {
            messages.value[
                parseInt(route.params.direct_messages_target_user_id)
            ] = [];
        }

        return messages.value[
            parseInt(route.params.direct_messages_target_user_id)
        ];
    });

    function storeNewMessage(message) {
        // console.log(message);

        let chatId =
            authStore.user.id === message.user_id
                ? message.target_user_id
                : message.user_id;

        if (!messages.value[chatId]) {
            messages.value[chatId] = [];
        }

        messages.value[chatId].push(message);
    }

    // TODO: optimize this logic
    function mergeOlderMessages(chatId, oldMessages) {
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
