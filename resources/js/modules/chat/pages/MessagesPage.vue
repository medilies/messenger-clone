<template>
    <div class="flex h-full">
        <router-view class="flex-1 border border-gray-600" />
    </div>
</template>

<script setup>
import { UsersList } from "@/modules/chat";

import { useChatStore } from "@/modules/chat";

import { authenticatedGet } from "@/modules/auth/Services/AuthenticatedRequest";
import { useAuthStore } from "@/modules/auth/store/AuthStore";

/*
    Chat
*/

const chatStore = useChatStore();

const authStore = useAuthStore();

Echo.private(`direct-messages.${authStore.user.id}`).listen(
    ".DirectMessage",
    (message) => {
        // console.log(message);

        chatStore.storeNewMessage(message);
    }
);

Echo.private("chat").listenForWhisper("typing", (e) => {
    console.log("typing...");
});
</script>
