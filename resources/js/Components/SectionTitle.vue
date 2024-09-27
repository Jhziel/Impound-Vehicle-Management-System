<script setup>
defineProps({
    place: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div :class="place" class="basis-1/4 py-2 px-5 text-center">
        <h1 class="text-2xl text-gray-800 dark:text-slate-50"><slot /></h1>
    </div>
</template>
