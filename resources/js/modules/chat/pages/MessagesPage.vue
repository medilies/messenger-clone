<template>
    <div class="flex h-full">
        <div
            class="h-full w-48 bg-slate-900 border border-gray-600 overflow-y-auto"
        >
            <UsersList />
        </div>
        <div class="flex-1 border border-gray-600">
            <TheChat />
        </div>
    </div>
</template>

<script setup>
import { TheChat, UsersList } from "@/modules/chat";

import { useUsersStore } from "@/Stores/UsersStore";
import { useChatStore } from "@/modules/chat";

import { authenticatedGet } from "@/modules/auth/Services/AuthenticatedRequest";
import { useAuthStore } from "@/modules/auth/store/AuthStore";

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

        chatStore.storeNewMessage(message);
    }
);

Echo.private("chat").listenForWhisper("typing", (e) => {
    console.log("typing...");
});
</script>
