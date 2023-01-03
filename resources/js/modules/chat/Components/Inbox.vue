<template>
    <div class="text-white">
        <div
            v-for="conversation in conversationsStore.conversations"
            key="conversation.id"
        >
            <ConversationDirectListItem :conversation="conversation" />
        </div>
    </div>
</template>

<script setup>
import ConversationDirectListItem from "@/modules/chat/Components/ConversationDirectListItem.vue";

import { useConversationStore } from "@/modules/chat";

const conversationsStore = useConversationStore();

conversationsStore.refreshConversations();
</script>
