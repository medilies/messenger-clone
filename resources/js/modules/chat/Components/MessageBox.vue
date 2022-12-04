<template>
    <form @submit.prevent="send">
        <input
            @keyup="typing"
            v-model="message"
            type="text"
            class="w-full bg-gray-800 border-purple-800 text-white rounded-md"
            autofocus
        />
    </form>
</template>

<script setup>
import { sendMessage } from "@/modules/auth/Services/AuthenticatedRequest"; // ! move it

import { useChatStore } from "@/modules/chat";

import { ref } from "vue";
import { useRoute } from "vue-router";

const message = ref("");

function typing() {
    Echo.private("chat").whisper("typing", { msg: message.value });
}

const chatStore = useChatStore();

const route = useRoute();

function send() {
    if (!message.value) {
        return;
    }

    const messageData = {
        content: message.value,
        target_user_id: parseInt(route.params.direct_messages_target_user_id),
    };

    sendMessage(messageData).then((response) => {
        // console.log(response.data);

        chatStore.storeNewMessage(response.data);
    });
    // TODO: catch

    message.value = "";
}
</script>
