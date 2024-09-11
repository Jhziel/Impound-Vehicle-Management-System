<script setup>
defineProps({
    link: String,
    icon: Array,
    active: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <li class="flex justify-between items-center">
        <Link
            :href="link"
            :class="active ? 'bg-gray-700' : 'hover:bg-gray-700'"
            class="text-white px-4 py-2 rounded-sm w-full font-medium block text-xl"
            ><font-awesome-icon :icon="icon" class="mr-3" /><slot
        /></Link>
    </li>
</template>
