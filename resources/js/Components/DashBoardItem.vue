<script setup>
defineProps({
    icon: Array,
    category: String,
    percentage: String,
    statusIcon: Array,
    count: String,
    compared: String,
    statusColor: {
        default: "text-green-700",
        type: String,
    },
});
</script>

<template>
    <div class="col-span-1 h-44 bg-slate-950 rounded-md flex flex-col p-5">
        <font-awesome-icon :icon="icon" class="text-4xl dark:text-white mt-4" />
        <div class="flex justify-between mt-8">
            <p class="dark:text-white text-lg">{{ category }}</p>
            <p class="dark:text-white text-lg">{{ count }}</p>
        </div>
        <div class="flex justify-between">
            <p class="dark:text-white text-lg">{{ compared }}</p>
            <p :class="statusColor" class="text-lg">
                {{ percentage
                }}<font-awesome-icon :icon="statusIcon" class="ml-1" />
            </p>
        </div>
    </div>
  
</template>
