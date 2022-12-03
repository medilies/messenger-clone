<template>
    <div class="flex flex-col" :class="alignClassObject">
        <p class="text-slate-400 text-xs">{{ props.message.user.name }}</p>
        <div :class="colorClassObject" class="w-4/6 p-2 rounded-md">
            {{ props.message.content }}
        </div>
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
    authStore.user.id === props.message.user.id ? "items-end" : "",
]);
</script>
