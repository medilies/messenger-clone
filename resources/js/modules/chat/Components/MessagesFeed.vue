<template>
    <div
        ref="containerDiv"
        class="flex flex-col gap-2 flex-1 p-1 overflow-y-auto"
    >
        <div v-for="(message, index) in chatStore.getCurrentChatMessages">
            <div v-if="thresholdDiff(index)" class="text-white text-center">
                {{ new Date(message.created_at).toLocaleString() }}
            </div>

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

function thresholdDiff(index) {
    const threshold = 1000 * 60 * 60 * 2;

    const diff = (index) => {
        if (index === 0) {
            return 0;
        }

        const t =
            new Date(
                chatStore.getCurrentChatMessages[index].created_at
            ).valueOf() -
            new Date(
                chatStore.getCurrentChatMessages[index - 1].created_at
            ).valueOf();

        return t;
    };

    return diff(index) > threshold;
}
</script>
