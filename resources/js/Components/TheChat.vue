<template>
    <div class="flex flex-col h-full p-3">
        <div v-if="chatStore.currentChat === null"></div>

        <div v-else class="flex flex-col h-full">
            <!--  -->
            <div class="flex flex-col gap-2 flex-1 p-2">
                <div v-for="message in chatStore.getCurrentChatMessages">
                    <ChatMessage :message="message" />
                </div>
            </div>

            <MessageBox :target-user="chatStore.getCurrentChatUser" />
        </div>
    </div>
</template>

<script setup>
import MessageBox from "@/Components/MessageBox.vue";
import ChatMessage from "@/Components/ChatMessage.vue";

import { useChatStore } from "@/Stores/ChatStore";

const chatStore = useChatStore();
</script>
