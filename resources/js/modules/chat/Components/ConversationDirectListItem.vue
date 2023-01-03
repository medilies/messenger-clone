<template>
    <RouterLink
        :to="{
            name: 'messages.direct',
            params: { conversation_id: props.conversation.id },
        }"
        class="w-full block hover:text-white rounded-md p-1 text-left text-sm truncate cursor-pointer text-blue-300 bg-blue-900"
    >
        {{ conversation.other_users[0].name }}
    </RouterLink>
</template>

<script setup>
const props = defineProps({
    conversation: {
        type: Object,
        required: true,
    },
});
</script>
