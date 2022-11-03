<template>
    <div class="container mx-auto border">
        <h1 class="text-center"> Realtime chat </h1>

        <Chat :messages="messages" />
    </div>
</template>

<script>
import Chat from "./Components/Chat.vue";

export default {
    components: {
        Chat,
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
}
</script>
