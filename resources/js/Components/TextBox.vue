<template>
    <form @submit.prevent="sendMessage">
        <input type="text" class="w-full border-gray-500 rounded-md" v-model="message">
    </form>
</template>

<script>
import axios from 'axios';

export default {
    name: "TextBox",

    data() {
        return {
            message: ''
        }
    },

    methods: {
        sendMessage() {
            if (!this.message) {
                return;
            }

            console.log(this.message);

            axios.post("/api/messages", { message: this.message })
                .then((response) => {
                    console.log(response.data);
                });

            this.message = '';
        }
    }
}
</script>
