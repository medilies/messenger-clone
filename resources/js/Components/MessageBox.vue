<template>
    <form @submit.prevent="send">
        <input
            @keyup="typing"
            v-model="message"
            type="text"
            class="w-full border-gray-500 rounded-md"
            autofocus
        />
    </form>
</template>

<script setup>
import { sendMessage } from "@/Services/AuthenticatedRequest";
import { useChatStore } from "@/Stores/ChatStore";
import { ref } from "vue";

const props = defineProps({
    targetUser: {
        type: Object,
        required: true,
    },
});

const message = ref("");

const chatStore = useChatStore();

// function typing() {
//     console.log("Im typing");
//     Echo.private(`chat`).whisper("typing", {
//         name: "hip hop houray",
//     });
// }

function send() {
    if (!message.value) {
        return;
    }

    const messageData = {
        content: message.value,
        target_user_id: props.targetUser.id,
    };

    sendMessage(messageData).then((response) => {
        // console.log(response.data);

        chatStore.storeNewMessage(response.data);
    });
    // TODO: catch

    message.value = "";
}
</script>
