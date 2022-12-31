<template>
    <div class="text-white">
        <div
            v-for="conversation in conversationsStore.conversations"
            key="conversation.id"
        >
            {{ conversation.id }}
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

import { useConversationStore } from "@/modules/chat";

const conversationsStore = useConversationStore();

conversationsStore.refreshConversations();
</script>
