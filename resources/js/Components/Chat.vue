<template>

    <div class="flex flex-col gap-2 p-2">
        <div v-for="message in messages">
            <div class="p-2 bg-gray-100"> {{ message }} </div>
        </div>
    </div>

    <TextBox @send-message="sendMessage" />

</template>

<script>
import TextBox from "./TextBox.vue";

export default {
    props: {
        messages: Array
    },

    components: {
        TextBox,
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
