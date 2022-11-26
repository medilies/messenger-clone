<template>
    <div class="flex container mx-auto border">
        <div class="flex-1">
            <TheChat />
        </div>
        <div>
            <UsersList />
        </div>
    </div>
</template>

<script setup>
import TheChat from "@/Components/TheChat.vue";
import UsersList from "@/Components/UsersList.vue";

import { useUsersStore } from "@/Stores/UsersStore";
import { useChatStore } from "@/Stores/ChatStore";

import { authenticatedGet } from "@/Services/AuthenticatedRequest";
import { useAuthStore } from "@/Stores/AuthStore";

/*
    Users
*/

const usersStore = useUsersStore();

if (usersStore.users === null) {
    authenticatedGet("/api/users").then((response) => {
        // console.log(response.data);

        usersStore.users = response.data;
    });
}

/*
    Chat
*/

const chatStore = useChatStore();

const authStore = useAuthStore();

Echo.private(`direct-messages.${authStore.user.id}`).listen(
    "DirectMessageEvent",
    (message) => {
        // console.log(message);

        // * already stored on send response handler
        if (message.user_id === authStore.user.id) {
            return;
        }

        chatStore.storeNewMessage(message);
    }
);
Echo.private("direct-messages").listen("NewMessage", (message) => {
    // console.log(message);
    chatStore.storeNewMessage(message);
});
</script>
