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

async function getOldMessage(direct_messages_target_user_id) {
    direct_messages_target_user_id = parseInt(direct_messages_target_user_id);

    if (isNaN(direct_messages_target_user_id)) {
        return;
    }

    const response = await authenticatedGet(
        `/api/messages/${direct_messages_target_user_id}`
    );

    chatStore.mergeOlderMessages(direct_messages_target_user_id, response.data);
    // TODO: add auto scroll down
}

// TODO: optimize this logic of looking for older messages when less than 50
if (chatStore.getCurrentChatMessages.length < 50) {
    getOldMessage(route.params.direct_messages_target_user_id);
}

watch(route, async (oldRoute, newRoute) => {
    if (chatStore.getCurrentChatMessages.length < 50) {
        getOldMessage(newRoute.params.direct_messages_target_user_id);
    }
});
</script>
