<template>
    <div
        ref="containerDiv"
        class="flex flex-col gap-2 flex-1 p-1 overflow-y-auto"
    >
        <div v-for="message in chatStore.getCurrentChatMessages">
            <ChatBubble :message="message" />
        </div>
    </div>
</template>

<script setup>
import ChatBubble from "@/modules/chat/Components/MessageBubble.vue";
import { useChatStore } from "@/modules/chat";
import { onUpdated, ref } from "vue";

const chatStore = useChatStore();

const containerDiv = ref(null);

function scrollDown() {
    containerDiv.value.scroll({
        top: containerDiv.value.scrollHeight,
        behavior: "smooth",
    });
}

onUpdated(scrollDown);
</script>
