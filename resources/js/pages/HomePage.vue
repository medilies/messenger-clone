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

Echo.private("direct-messages").listen("NewMessage", (message) => {
    // console.log(message);
    chatStore.storeNewMessage(message);
});
</script>
