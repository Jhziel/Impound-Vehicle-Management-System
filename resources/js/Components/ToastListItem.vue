<script setup>
import { computed } from "vue";
import { onMounted } from "vue";

const props = defineProps({
    message: String,
    type: String,
});

onMounted(() => {
    setTimeout(() => emit("remove"), 2000);
});

const emit = defineEmits(["remove"]);

const backGround = computed(() => {
    if (props.type === "success") {
        return "bg-green-500 dark:bg-green-700";
    }
    return "bg-red-500 dark:bg-red-700";
});

const icon = computed(() => {
    if (props.type === "success") {
        return ["fas", "circle-check"];
    }

    return ["fas", "circle-xmark"];
});
</script>
<template>
    <div
        :class="backGround"
        class="flex items-center p-4 text-slate-50 rounded-lg shadow"
        role="alert"
    >
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8text-slate-50 text-lg"
        >
            <font-awesome-icon :icon="icon" />
        </div>
        <div class="ms-3 text-sm font-normal">{{ message }}</div>
        <button
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-200 dark:hover:bg-gray-700"
            data-dismiss-target="#toast-default"
            aria-label="Close"
            @click="emit('remove')"
        >
            <span class="sr-only">Close</span>
            <svg
                class="w-3 h-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                />
            </svg>
        </button>
    </div>
</template>
