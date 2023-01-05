<template>
    <div class="flex flex-col gap-1 p-1 text-white overflow-y-auto">
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
