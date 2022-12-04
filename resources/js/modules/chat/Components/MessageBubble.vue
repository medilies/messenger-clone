<template>
    <div class="flex flex-col" :class="alignClassObject">
        <p class="text-slate-400 text-xs">{{ props.message.user.name }}</p>
        <p
            :class="colorClassObject"
            class="max-w-[80%] p-4 rounded-3xl text-sm break-words"
        >
            {{ props.message.content }}
        </p>
    </div>
</template>

<script setup>
import { useAuthStore } from "@/modules/auth";
import { reactive } from "vue";

const authStore = useAuthStore();

const props = defineProps({
    message: {
        type: Object,
        required: true,
    },
});

const colorClassObject = reactive([
    authStore.user.id === props.message.user.id
        ? "text-white bg-purple-900"
        : "bg-gray-800 text-gray-50",
]);

const alignClassObject = reactive([
    authStore.user.id === props.message.user.id ? "items-end" : "items-start",
]);
</script>
