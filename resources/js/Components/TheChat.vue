<template>

    <div class="flex flex-col gap-2 p-2">
        <div v-for="message in messages">
            <div class="p-2 bg-gray-100"> {{ message }} </div>
        </div>
    </div>

    <TextBox />

</template>

<script>
import TextBox from '@/Components/TextBox.vue';

export default {
    name: 'TheChat',

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

        this.messages = [];
    },
}
</script>
