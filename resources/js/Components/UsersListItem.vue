<template>
    <button
        @click="setCurrentChat"
        class="w-full border bold rounded-md p-2 text-left hover:bg-gray-100"
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
