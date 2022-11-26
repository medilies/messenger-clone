<template>
    <div v-if="chatStore.currentChat === null"></div>
    <div v-else>
        <h1 class="text-center">
            Chat with {{ chatStore.getCurrentChatUser.name }}
        </h1>

        <!--  -->
        <div class="flex flex-col gap-2 p-2">
            <div v-for="message in chatStore.getCurrentChatMessages">
                <div class="p-2 bg-gray-100">
                    {{ message.user.name }}: {{ message.content }}
                </div>
            </div>
        </div>

        <MessageBox :target-user="chatStore.getCurrentChatUser" />
    </div>
</template>

<script setup>
import MessageBox from "@/Components/MessageBox.vue";

import { useChatStore } from "@/Stores/ChatStore";

const chatStore = useChatStore();
</script>
