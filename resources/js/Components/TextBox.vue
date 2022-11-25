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
import sendMessage from "@/Services/SendMessageService.js";
import { ref } from "vue";

const message = ref("");

function send() {
    if (!message.value) {
        return;
    }

    sendMessage({ message: message.value }).then((response) => {
        console.log(response.data);
    });

    message.value = "";
}
</script>
