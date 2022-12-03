<template>
    <RouterLink
        :to="{ name: 'messages.direct', params: { id: props.user.id } }"
        :class="currentChatUserClass"
        class="w-full block hover:text-white rounded-md p-1 text-left truncate cursor-pointer"
    >
        {{ user.name }}
    </RouterLink>
</template>

<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const route = useRoute();

const currentChatUserClass = reactive([
    // ! not reactive check
    props.user.id === parseInt(route.params.id)
        ? "text-white bg-blue-800"
        : "text-blue-300 bg-blue-900",
]);
</script>
