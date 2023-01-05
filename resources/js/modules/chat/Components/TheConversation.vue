<template>
    <section class="flex flex-col gap-4 h-full p-2 overflow-x-hidden">
        <MessagesFeed />
        <MessageBox />
    </section>
</template>

<script setup>
import { authenticatedGet } from "@/modules/auth";
import { MessageBox, useChatStore } from "@/modules/chat";
import MessagesFeed from "@/modules/chat/Components/MessagesFeed.vue";
import { watch } from "vue";
import { useRoute } from "vue-router";

const chatStore = useChatStore();

const route = useRoute();

async function getOldMessage(conversation_id) {
    conversation_id = parseInt(conversation_id);

    if (isNaN(conversation_id)) {
        return;
    }

    const response = await authenticatedGet(
        `/api/conversations/${conversation_id}/messages`
    );

    // console.log(response.data);

    chatStore.mergeOlderMessages(conversation_id, response.data);
    // TODO: add auto scroll down
}

// TODO: optimize this logic of looking for older messages when less than 50
if (chatStore.getCurrentChatMessages.length < 50) {
    getOldMessage(route.params.conversation_id);
}

watch(route, async (oldRoute, newRoute) => {
    if (chatStore.getCurrentChatMessages.length < 50) {
        getOldMessage(newRoute.params.conversation_id);
    }
});
</script>
