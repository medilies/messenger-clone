<template>
    <aside class="flex flex-col h-full gap-1 p-1">
        <div v-for="user in usersStore.users" key="user.id">
            <UsersListItem :user="user" />
        </div>
    </aside>
</template>

<script setup>
import { useUsersStore } from "@/Stores/UsersStore";

import { UsersListItem } from "@/modules/chat";

const usersStore = useUsersStore();
</script>
