<script setup>
const model = defineModel();
defineProps({
    type: {
        type: String,
        default: "text",
    },
    name: String,
    id: String,
    placeholder: String,
    width: {
        type: String,
        default: "1/2",
    },
});
</script>

<template>
    <input
        :type="type"
        :name="name"
        :id="id"
        :placeholder="placeholder"
        v-model="model"
        :class="`w-${width}`"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        required
    />
</template>
