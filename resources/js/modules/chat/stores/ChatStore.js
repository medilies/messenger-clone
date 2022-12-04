import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAuthStore } from "@/modules/auth/store/AuthStore";
import { useRoute } from "vue-router";

export const useChatStore = defineStore("chat", () => {
    const authStore = useAuthStore();
    const route = useRoute();

    const messages = ref({});

    const getCurrentChatMessages = computed(() => {
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

    return {
        messages,
        getCurrentChatMessages,
        storeNewMessage,
    };
});
