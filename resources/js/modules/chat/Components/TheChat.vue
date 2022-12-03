<template>
    <div class="flex flex-col h-full">
        <div class="flex flex-col gap-2 flex-1 p-2">
            <div v-for="message in chatStore.getCurrentChatMessages">
                <ChatBubble :message="message" />
            </div>
        </div>

        <MessageBox />
    </div>
</template>

<script setup>
import { MessageBox, ChatBubble, useChatStore } from "@/modules/chat";

const chatStore = useChatStore();
</script>
