<script setup>
defineProps({
    link: String,
});
</script>

<template>
    <Link :href="link" class="bg-red-500 py-2 px-4"
        ><font-awesome-icon
            :icon="['fas', 'arrow-left']"
            class="mr-1"
        />Back</Link
    >
</template>
