<script setup>
import BackButton from "./BackButton.vue";
defineProps({
    link: String,
    pageTitle: String,
});
</script>

<template>
    <div class="flex justify-between">
        <h1 class="text-2xl dark:text-slate-50 text-gray-700 font-bold">{{ pageTitle }}</h1>
        <BackButton :link="link" />
    </div>
</template>
