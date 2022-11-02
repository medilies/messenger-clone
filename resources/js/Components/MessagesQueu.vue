<template>
    <div class="flex flex-col gap-2 p-2">
        <div v-for="message in messages">
            <div class="p-2 bg-gray-100"> {{ message }} </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        messages: Array
    }
}
</script>
