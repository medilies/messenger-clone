<template>
    <button
        @click="setCurrentChat"
        :class="[
            chatStore.getCurrentChatUserId === props.user.id
                ? 'text-white bg-blue-800'
                : 'text-blue-300 bg-blue-900',
        ]"
        class="w-full hover:text-white bold rounded-md p-2 text-left"
    >
        {{ user.name }}
    </button>
</template>

<script setup>
import { useChatStore } from "@/Stores/ChatStore";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const chatStore = useChatStore();

function setCurrentChat() {
    chatStore.currentChat = {
        type: "direct",
        userId: props.user.id,
    };
}
</script>
