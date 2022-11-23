<template>
    <div class="container mx-auto border">

        <h1 class="text-center"> Realtime chat {{ authStore.user.email }}</h1>

        <TheChat />

    </div>
</template>

<script >
import TheChat from '@/Components/TheChat.vue';
import { useAuthStore } from '@/Stores/AuthStore';
import { mapStores } from 'pinia';

export default {
    name: "HomePage",

    components: {
        TheChat,
    },

    computed: {
        ...mapStores(useAuthStore)
    }
}
</script>
