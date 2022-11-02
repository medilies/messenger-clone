<template>
    <div class="container mx-auto border">
        <h1 class="text-center"> Hello vue </h1>

        <MessagesQueu :messages="messages" />
    </div>
</template>

<script>
import MessagesQueu from "./Components/MessagesQueu.vue";

export default {
    name: 'App',

    components: {
        MessagesQueu,
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
    }
}
</script>
