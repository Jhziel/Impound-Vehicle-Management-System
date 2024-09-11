<script setup>
defineProps({
    isDark: Boolean,
});
defineEmits(["toggleDark", "toggleSideBar"]);
</script>

<template>
    <header
        class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600 font-semibold dark:bg-slate-950 dark:text-slate-50"
    >
        <div class="text-2xl border-[2px] border-gray-500 px-3 lg:hidden">
            <button @click="$emit('toggleSideBar')">
                <font-awesome-icon :icon="['fas', 'bars']" />
            </button>
        </div>
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
    </header>
</template>
