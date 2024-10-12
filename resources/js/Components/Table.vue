<script setup>
import SearchAndActionButton from "@/Components/SearchAndActionButton.vue";
import { router } from "@inertiajs/vue3";
import { throttle } from "lodash";
import { ref, watch } from "vue";
const props = defineProps({
    heads: Array,
    linkAdd: String,
    linkName: String,
    pageTitle: String,
    pageData: Object,
    search: String,
    currentSeach: Object,
});

const search = ref(props.currentSeach.search);
const drivers = true;

watch(
    search,
    throttle(function (value) {
        router.get(
            // Executes a GET request to the search endpoint using the router.
            // `${props.search}` dynamically constructs the search URL.
            `/${props.search}`,
            { search: value },
            {
                /*  Preserves the current state of
                the page so whenever you type on search it does not reset */
                preserveState: true,

                replace: true,
            }
        );
    }, 500)
);


</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
        <h1
            class="dark:text-slate-50 text-gray-700 font-semibold text-2xl mb-2"
        >
            {{ pageTitle }}
        </h1>
        <SearchAndActionButton
            :linkAdd="linkAdd"
            :linkName="linkName"
            v-model="search"
        />

        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-2 border-indigo-600"
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
        <div class="bg-white dark:bg-slate-800 px-3 py-2">
            <div class="flex justify-between">
                <p class="text-gray-800 dark:text-slate-50">
                    Showing {{ pageData.from }} to {{ pageData.to }} of
                    {{ pageData.total }} entries
                </p>
                <div>
                    <Component
                        :is="link.url ? 'Link' : 'span'"
                        v-for="link in pageData.links"
                        :key="link.id"
                        :href="link.url"
                        :class="
                            link.active
                                ? 'bg-blue-500 text-white'
                                : link.url
                                ? 'bg-slate-200 dark:bg-gray-600'
                                : 'bg-gray-300 dark:bg-gray-900 text-gray-500 cursor-not-allowed'
                        "
                        class="px-3 py-1 font-md text-blue-500 dark:text-white"
                        v-html="link.label"
                    >
                    </Component>
                </div>
            </div>
        </div>
    </div>
</template>
