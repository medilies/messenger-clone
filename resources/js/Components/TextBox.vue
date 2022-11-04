<template>
    <form @submit.prevent="onSubmit">
        <input v-model="newMessage" type="text" class="w-full border-gray-500 rounded-md">
    </form>
</template>

<script>
export default {
    data() {
        return {
            newMessage: 'Bruh'
        }
    },

    methods: {
        onSubmit() {
            if (!this.newMessage) {
                return;
            }

            console.log(this.newMessage);

            this.$emit('send-message', { message: this.newMessage });

            this.newMessage = '';
        }
    }
}
</script>
