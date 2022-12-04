<template>
    <section class="flex flex-col h-full p-2">
        <div class="flex flex-col gap-2 flex-1">
            <div v-for="message in chatStore.getCurrentChatMessages">
                <ChatBubble :message="message" />
            </div>
        </div>

        <MessageBox />
    </section>
</template>

<script setup>
import { MessageBox, ChatBubble, useChatStore } from "@/modules/chat";

const chatStore = useChatStore();
</script>
