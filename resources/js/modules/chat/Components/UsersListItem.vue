<template>
    <a
        @click="setCurrentChat"
        :class="currentChatUserClass"
        class="w-full block hover:text-white rounded-md p-1 text-left truncate cursor-pointer"
    >
        {{ user.name }}
    </a>
</template>

<script setup>
import { useChatStore } from "@/modules/chat";
import { reactive } from "vue";

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

const currentChatUserClass = reactive([
    chatStore.getCurrentChatUserId === props.user.id
        ? "text-white bg-blue-800"
        : "text-blue-300 bg-blue-900",
]);
</script>
