<script setup>
const model = defineModel();
defineProps({
    data: Array,
    placeholder: String,
    id: String,
});
</script>

<template>
    <v-select
        class="bg-gray-50 mb-3 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        :id="id"
        v-model="model"
        :options="data"
        :placeholder="placeholder"
        label="data"
        required
    >
        <template #selected-option="{ data }">
            <div class="text-black dark:text-white">
                {{ data }}
            </div>
        </template>
        <template #option="{ data }">
            <h3 class="text-gray-800 dark:text-slate-50">{{ data }}</h3>
        </template>
        <template #no-options="{ search, filteredOptions }">
            <div v-if="search" class="text-gray-700 dark:text-slate-50">
                Sorry no matching data for "{{ search }}"
            </div>
            <div v-else="condition" class="text-gray-700 dark:text-slate-50">
                No data
            </div>
        </template>
    </v-select>
</template>

<style>
.vs__dropdown-menu {
    background-color: white;
}
.dark .vs__dropdown-menu {
    background-color: #374151;
}
.vs__dropdown-toggle {
    border: none;
}
</style>
