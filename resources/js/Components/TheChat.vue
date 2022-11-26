<template>
    <div v-if="chatStore.currentChat === null"></div>
    <div v-else>
        <h1 class="text-center">Chat with {{ getCurrentChatUser().name }}</h1>

        <!--  -->
        <div class="flex flex-col gap-2 p-2">
            <div v-for="message in getCurrentChatMessage">
                <div class="p-2 bg-gray-100">
                    {{ message.user.name }}: {{ message.content }}
                </div>
            </div>
        </div>

        <MessageBox :target-user="getCurrentChatUser()" />
    </div>
</template>

<script setup>
import MessageBox from "@/Components/MessageBox.vue";
import { useAuthStore } from "@/Stores/AuthStore";
import { useChatStore } from "@/Stores/ChatStore";
import { useUsersStore } from "@/Stores/UsersStore";
import { computed, ref } from "vue";

const authStore = useAuthStore();
const usersStore = useUsersStore();
const chatStore = useChatStore();

function getCurrentChatUser() {
    return usersStore.users.find(
        (user) => user.id === chatStore.currentChat.userId
    );
}

// TODO: useChatSore where messages are grouped by chat
const messages = ref([]);

const getCurrentChatMessage = computed(() => {
    return messages.value.filter(
        (message) =>
            (message.target_user_id === authStore.user.id &&
                message.user_id === getCurrentChatUser().id) ||
            (message.target_user_id === getCurrentChatUser().id &&
                message.user_id === authStore.user.id)
    );
});

Echo.channel("home").listen("NewMessage", (e) => {
    messages.value.push(e.message);
    console.log(e);
});
</script>
