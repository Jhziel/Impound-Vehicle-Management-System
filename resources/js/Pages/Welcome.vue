<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import DashBoardItem from "@/Components/DashBoardItem.vue";
import BarChart from '@/Components/BarChart.vue';
defineOptions({
    layout: BaseLayout,
});
</script>

<template>
    <div class="p-5">
        <div class="grid grid-cols-3 gap-5">
            <!-- Today -->
            <DashBoardItem
                :icon="['fas', 'calendar-day']"
                category="Today's Violations"
                percentage="4.3%"
                compared="Compared Yesterday"
                count="25"
                :statusIcon="['fas', 'arrow-up']"
            />

            <!-- Month -->
            <DashBoardItem
                :icon="['fas', 'calendar-week']"
                category="This Month Violations"
                percentage="-18.3%"
                compared="Compared Last Month"
                :statusIcon="['fas', 'arrow-down']"
                statusColor="text-red-700"
                count="450"
            />

            <!-- Year -->
            <DashBoardItem
                :icon="['fas', 'calendar-alt']"
                category="This Year Violations"
                percentage="8.5%"
                compared="Compared to Last Year"
                :statusIcon="['fas', 'arrow-up']"
                count="5,250"
            />
        </div>
    </div>

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
        <BarChart />
    </div>
</template>
