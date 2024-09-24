<script setup>
import { method, reduce } from "lodash";

const model = defineModel();
const props = defineProps({
    data: Array,
    placeholder: String,
    id: String,
    label: {
        type: String,
        default: null,
    },
    reduce: {
        type: Function,
        default: null,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <v-select
        class="bg-gray-50 mb-3 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        :id="id"
        :multiple="multiple"
        v-model="model"
        :options="data"
        :placeholder="placeholder"
        :label="label"
        :required="!model"
        :reduce="reduce"
        required
    >
        <template #selected-option="{ option }">
            <div v-if="option" class="text-black dark:text-white">
                {{ option[label] || option }}
            </div>
        </template>

        <template #option="{ option }">
            <h3 v-if="option" class="text-gray-800 dark:text-slate-50">
                {{ option[label] || option }}
            </h3>
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

.vs__selected {
    color: #374151;
}
.dark .vs__selected {
    color: white;
}

.vs__dropdown-option {
    color: #374151;
}
.dark .vs__dropdown-option {
    color: white;
}
.vs__dropdown-toggle {
    border: none;
}
</style>
