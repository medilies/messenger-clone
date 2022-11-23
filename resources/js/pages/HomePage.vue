<template>
    <div class="container mx-auto border">
        <h1 class="text-center"> Realtime chat {{ authStore.user.email }}</h1>

        <Chat />
    </div>
</template>

<script >
import Chat from '@/Components/Chat.vue';
import { useAuthStore } from '@/Stores/AuthStore';
import { mapStores } from 'pinia';



export default {
    components: {
        Chat,
    },
    computed: {
        ...mapStores(useAuthStore)
    }
}
</script>
