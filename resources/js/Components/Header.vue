<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
defineProps({
    isDark: Boolean,
});
defineEmits(["toggleDark", "toggleSideBar"]);
</script>

<template>
    <header
        class="flex items-center justify-between md:justify-end px-6 py-4 bg-white border-b-4 border-indigo-600 font-semibold dark:bg-slate-950 dark:text-slate-50"
    >
        <div class="text-2xl border-[2px] border-gray-500 px-3 lg:hidden">
            <button @click="$emit('toggleSideBar')">
                <font-awesome-icon :icon="['fas', 'bars']" />
            </button>
        </div>
        <div class="flex">
            <div>
                <div
                    @click="$emit('toggleDark')"
                    class="relative bg-gray-200 dark:bg-gray-500 w-20 cursor-pointer rounded-2xl h-6"
                >
                    <button
                        :class="
                            isDark
                                ? 'translate-x-full bg-gray-400 '
                                : 'translate-x-0 bg-yellow-300 '
                        "
                        class="absolute text-lg transition-all transform top-1/2 -translate-y-1/2 left-0 w-10 h-8 rounded-full"
                    >
                        <font-awesome-icon
                            :icon="['fas', isDark ? 'moon' : 'sun']"
                            class="text-white"
                        />
                    </button>
                </div>
            </div>

            <div class="ms-3">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            >
                               <!--  {{ $page.props.auth.user.name }} -->

                                <svg
                                    class="ms-2 -me-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')">
                            Profile
                        </DropdownLink>
                        <DropdownLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>
    </header>
</template>
