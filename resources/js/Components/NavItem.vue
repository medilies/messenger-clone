<template>
    <div
        class="flex justify-center items-center p-2 text-gray-200 font-bold hover:text-white"
    >
        <router-link :to="props.route"> <slot></slot> </router-link>
    </div>
</template>

<script setup>
const props = defineProps({
    route: {
        type: Object,
        required: true,
    },
});
</script>
