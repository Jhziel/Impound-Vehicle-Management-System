<script setup>
import SearchAndActionButton from "@/Components/SearchAndActionButton.vue";
defineProps({
    heads: Array,
    linkAdd: String,
    linkName: String,
    pageTitle: String,
});
const drivers = true;
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
        <h1
            class="dark:text-slate-50 text-gray-700 font-semibold text-2xl mb-2"
        >
            {{ pageTitle }}
        </h1>
        <SearchAndActionButton :linkAdd="linkAdd" :linkName="linkName" />
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th v-for="head in heads" scope="col" class="px-6 py-3">
                        {{ head }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!drivers">
                    <td
                        class="text-2xl dark:text-white text-center py-10 font-semibold"
                        colspan="5"
                    >
                        No Drivers Data
                    </td>
                </tr>

                <template v-else>
                    <slot />
                </template>
            </tbody>
        </table>
        <div class="bg-white dark:bg-slate-800 text-white">hello</div>
    </div>
</template>
