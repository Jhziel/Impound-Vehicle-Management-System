<script setup>
defineProps({
    disabled: Boolean,
});
</script>

<template>
    <button
        type="submit"
        class="bg-blue-500 py-2 px-4 w-24 mt-3"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>
