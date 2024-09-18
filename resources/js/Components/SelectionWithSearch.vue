<script setup>
const model = defineModel();
defineProps({
    data: Array,
    placeholder: String,
});
</script>

<template>
    <v-select
        class="bg-gray-50 mb-3 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        v-model="model"
        :options="data"
        :placeholder="placeholder"
        label="data"
    >
        <template #selected-option="{ data }">
            <div class="text-black dark:text-white">
                {{ data }}
            </div>
        </template>
        <template #no-options="{ search, filteredOptions }">
            <div v-if="search" class="text-black">
                Sorry no matching data for "{{ search }}"
            </div>
            <div v-else="condition" class="text-black">No data</div>
        </template>
    </v-select>
</template>
