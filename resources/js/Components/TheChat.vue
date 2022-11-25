<template>
    <div class="flex flex-col gap-2 p-2">
        <div v-for="message in messages">
            <div class="p-2 bg-gray-100">{{ message }}</div>
        </div>
    </div>

    <TextBox />
</template>

<script>
import TextBox from "@/Components/TextBox.vue";
import { ref } from "vue";

export default {
    name: "TheChat",

    components: {
        TextBox,
    },

    setup() {
        const messages = ref([]);

        Echo.channel("home").listen("NewMessage", (e) => {
            messages.value.push(e.message);
            console.log(e);
        });

        return {
            messages,
        };
    },
};
</script>
