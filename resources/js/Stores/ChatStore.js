import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAuthStore } from "./AuthStore";
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

    function storeNewMessage(message) {
        // console.log(message);

        // ! Must not receive messages that are meant for direct messages between other users
        if (
            !(authStore.user.id === message.user_id) &&
            !(authStore.user.id === message.target_user_id)
        ) {
            return;
        }

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
        storeNewMessage,
    };
});
