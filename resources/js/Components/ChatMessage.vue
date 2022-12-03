<template>
    <div
        :class="[
            authStore.user.id === props.message.user.id
                ? 'text-white bg-purple-900 ml-auto'
                : 'bg-gray-800 text-gray-50',
        ]"
        class="w-4/6 p-2 rounded-md"
    >
        {{ props.message.user.name }}: {{ props.message.content }}
    </div>
</template>

<script setup>
import { useAuthStore } from "@/modules/auth/store/AuthStore";

const authStore = useAuthStore();

const props = defineProps({
    message: {
        type: Object,
        required: true,
    },
});
</script>
