<script setup>
defineProps({
    labelfor: String,
});
</script>

<template>
    <label
        :for="labelfor"
        class="text-lg font-semibold text-gray-700 dark:text-slate-50"
        ><slot
    /></label>
</template>
