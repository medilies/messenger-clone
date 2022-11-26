<template>
    <form @submit.prevent="send">
        <input
            v-model="message"
            type="text"
            class="w-full border-gray-500 rounded-md"
        />
    </form>
</template>

<script setup>
import { sendMessage } from "@/Services/AuthenticatedRequest";
import { ref } from "vue";

const props = defineProps({
    targetUser: {
        type: Object,
        required: true,
    },
});

const message = ref("");

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
    });

    message.value = "";
}
</script>
