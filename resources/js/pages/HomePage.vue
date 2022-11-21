<template>
    <div class="container mx-auto border">
        <h1 class="text-center"> Realtime chat </h1>

        <Chat />
    </div>
</template>

<script >
import Chat from "../Components/Chat.vue";

export default {
    components: {
        Chat,
    },
}
</script>
