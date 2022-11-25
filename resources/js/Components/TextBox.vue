<template>
    <form @submit.prevent="send">
        <input
            v-model="message"
            type="text"
            class="w-full border-gray-500 rounded-md"
        />
    </form>
</template>

<script>
import sendMessage from "@/Services/SendMessageService.js";
import { ref } from "vue";

export default {
    name: "TextBox",

    setup() {
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

        return {
            message,
            send,
        };
    },
};
</script>
