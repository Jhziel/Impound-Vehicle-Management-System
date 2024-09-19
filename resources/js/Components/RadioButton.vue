<script setup>
const model = defineModel();

defineProps({
    value: String,
    mb: {
        type: String,
        default: "4",
    },
});
</script>

<template>
    <div :class="`flex items-center mb-${mb}`">
        <input
            :id="value"
            type="radio"
            :value="value"
            v-model="model"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
            >{{ value }}
        </label>
    </div>
</template>
