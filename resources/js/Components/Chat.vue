<template>

    <div class="flex flex-col gap-2 p-2">
        <div v-for="message in messages">
            <div class="p-2 bg-gray-100"> {{ message }} </div>
        </div>
    </div>

    <TextBox @send-message="sendMessage" />

</template>

<script>
import TextBox from '@/Components/TextBox.vue';

export default {
    name: 'Chat',
    components: {
        TextBox,
    },

    data() {
        return {
            messages: []
        }
    },

    created() {
        Echo
            .channel("home").listen("NewMessage", (e) => {
                this.messages.push(e.message)
                console.log(e);
            });

        this.messages = [
            'foo',
            'bar'
        ];
    },

    methods: {
        sendMessage(message) {
            axios.post("/api/messages", message)
                .then((response) => {
                    console.log(response.data);
                });
        }
    }
}
</script>
