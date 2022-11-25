<template>
    <form @submit.prevent="send">
        <input type="text" class="w-full border-gray-500 rounded-md" v-model="message">
    </form>
</template>

<script>
import sendMessage from "@/Services/SendMessageService.js";

export default {
    name: "TextBox",

    data() {
        return {
            message: ''
        }
    },

    methods: {
        send() {
            if (!this.message) {
                return;
            }

            console.log(this.message);

            sendMessage({ message: this.message })
                .then((response) => {
                    console.log(response.data);
                });

            this.message = '';
        }
    }
}
</script>
