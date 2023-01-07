<template>
    <router-link
        :to="{
            name: 'chat.conversation',
            params: { conversation_id: props.params.userId },
        }"
    >
        <slot> Discussion </slot>
    </router-link>
</template>

<script setup>
// ! This shouldn't be a </router-link> component
// ! It should ask the conversation ID using the user ID
// ! Then redirect

const props = defineProps({
    params: {
        type: Object,
        required: true,
    },
});
</script>
