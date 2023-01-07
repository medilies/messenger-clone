<template>
    <section class="flex flex-col h-screen bg-gray-900">
        <nav
            class="grow-0 shrink-0 basis-12 bg-slate-900 border border-gray-600"
        >
            <div v-if="authStore.isAuthenticated">
                <div class="flex gap-4 justify-center h-full">
                    <NavItem :route="{ name: 'home' }"> Home </NavItem>
                    <NavItem :route="{ name: 'chat.inbox' }"> Inbox </NavItem>
                </div>
            </div>
            <div v-else class="h-full">
                <div class="flex gap-4 justify-center h-full">
                    <NavItem :route="{ name: 'login' }"> Login</NavItem>
                    <NavItem :route="{ name: 'register' }"> Register</NavItem>
                </div>
            </div>
        </nav>

        <main class="grow-0 shrink basis-full overflow-hidden">
            <router-view />
        </main>
    </section>
</template>

<script setup>
import NavItem from "./Components/NavItem.vue";

import { useChatStore } from "@/modules/chat";
import { useAuthStore } from "@/modules/auth/store/AuthStore";
import { useUsersStore } from "@/Stores/UsersStore";

const chatStore = useChatStore();

const authStore = useAuthStore();

if (authStore.user) {
    /*
        Chat
    */
    Echo.private(`chat.${authStore.user.id}`).listen(
        ".NewMessageEvent",
        (message) => {
            // console.log(message);

            chatStore.storeNewMessage(message);
        }
    );

    // Echo.private("chat").listenForWhisper("typing", (e) => {
    //     console.log("typing...");
    // });

    /*
        Users
    */

    const usersStore = useUsersStore();

    usersStore.refreshUsers();
}
</script>
