<template>
    <div class="container mx-auto border">
        <h1 class="text-center">Realtime chat {{ authStore.user.email }}</h1>

        <TheChat />
    </div>
</template>

<script setup>
import TheChat from "@/Components/TheChat.vue";
import { useAuthStore } from "@/Stores/AuthStore";

const authStore = useAuthStore();
</script>
