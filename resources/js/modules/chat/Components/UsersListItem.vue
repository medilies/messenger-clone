<template>
    <RouterLink
        :to="{
            name: '',
            params: {},
        }"
        class="w-full block hover:text-white rounded-md p-1 text-left text-sm truncate cursor-pointer text-blue-300 bg-blue-900"
    >
        {{ user.name }}
    </RouterLink>
</template>

<script setup>
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="css" scoped>
@import "tailwindcss/components";

.router-link-active {
    @apply text-white bg-blue-800;
}
</style>
