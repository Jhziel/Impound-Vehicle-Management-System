<script setup>
import SideBar from "@/Components/SideBar.vue";
import { useDark, useToggle } from "@vueuse/core";
import Header from "@/Components/Header.vue";
import { ref } from "vue";

const isDark = useDark();
const toggleDark = useToggle(isDark);
const isOpen = ref(false);

const toggleSideBar = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <div class="flex h-screen bg-gray-200 dark:bg-slate-900">
        <SideBar :isOpen="isOpen" @hideSidebar="toggleSideBar" />
        <div class="flex-1 flex flex-col overflow-hidden">
            <Header
                :isDark="isDark"
                @toggleDark="toggleDark"
                @toggleSideBar="toggleSideBar"
            />
            <main class="px-10 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>
