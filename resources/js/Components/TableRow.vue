<script setup>
defineProps({
    data: Object,
});
</script>

<template>
    <tr
        class="bg-white dark:bg-slate-950 hover:bg-gray-50 dark:hover:bg-gray-600"
    >
        <slot name="row-data" :data="data" />
    </tr>
</template>
