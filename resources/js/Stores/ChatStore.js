import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAuthStore } from "../modules/auth/store/AuthStore";
import { useUsersStore } from "./UsersStore";

export const useChatStore = defineStore("chat", () => {
    const authStore = useAuthStore();
    const usersStore = useUsersStore();

    const currentChat = ref(null);
    const messages = ref({});

    const getCurrentChatMessages = computed(() => {
        if (currentChat.value === null) {
            return [];
        }

        return messages.value[currentChat.value.userId];
    });

    const getCurrentChatUser = computed(() => {
        if (currentChat.value === null) {
            return null;
        }

        return usersStore.users.find(
            (user) => user.id === currentChat.value.userId
        );
    });

    const getCurrentChatUserId = computed(() => {
        if (currentChat.value === null) {
            return null;
        }

        return usersStore.users.find(
            (user) => user.id === currentChat.value.userId
        ).id;
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
        currentChat,
        messages,
        getCurrentChatMessages,
        getCurrentChatUser,
        getCurrentChatUserId,
        storeNewMessage,
    };
});
