<template>
    <button @click="goToDiscussion">Discussion</button>
</template>

<script setup>
import { authenticatedGet } from "@/modules/auth";
import { useConversationStore } from "@/modules/chat";
import { useRouter } from "vue-router";

const props = defineProps({
    params: {
        type: Object,
        required: true,
    },
});

const conversationStore = useConversationStore();

const router = useRouter();

function goToDiscussion() {
    authenticatedGet(
        `/api/chat/conversations/direct/${props.params.userId}`
    ).then((response) => {
        console.log(response.data);

        // TODO: push to store
        // conversationStore

        router.push({
            name: "chat.conversation",
            params: { conversation_id: response.data.id },
        });
    });
}
</script>
