<template>
    <div></div>
</template>

<script setup>
import { useUsersStore } from "@/Stores/UsersStore";
import { authenticatedGet } from "@/modules/auth/Services/AuthenticatedRequest";

/*
    Users
*/

const usersStore = useUsersStore();

if (usersStore.users === null) {
    authenticatedGet("/api/users").then((response) => {
        // console.log(response.data);

        usersStore.users = response.data;
    });
}
</script>
