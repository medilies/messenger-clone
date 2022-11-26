<template>
    <div class="bg-gray-300">
        <div v-for="user in usersStore.users" key="user.id">
            {{ user.name }}
        </div>
    </div>
</template>

<script setup>
import { useUsersStore } from "@/Stores/UsersStore";

const usersStore = useUsersStore();
</script>
