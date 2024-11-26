<!-- resources/js/Components/BarChart.vue -->
<template>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <canvas ref="barChartCanvas" class="w-full h-96"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Chart } from "chart.js";

const barChartCanvas = ref(null); // Reference to the canvas element
let barChart = null; // Chart instance

// Chart data and options
const chartData = {
    labels: ["January", "February", "March", "April", "May", "June"],
    datasets: [
        {
            label: "Sales",
            data: [50, 60, 80, 81, 56, 55],
            backgroundColor: "rgba(54, 162, 235, 0.6)",
            borderColor: "rgba(54, 162, 235, 1)",
            borderWidth: 1,
        },
        {
            label: "Expenses",
            data: [40, 55, 70, 60, 75, 65],
            backgroundColor: "rgba(255, 99, 132, 0.6)",
            borderColor: "rgba(255, 99, 132, 1)",
            borderWidth: 1,
        },
    ],
};

const chartOptions = {
    responsive: true,
    scales: {
        x: {
            beginAtZero: true,
        },
        y: {
            beginAtZero: true,
        },
    },
    plugins: {
        legend: {
            display: true,
            position: "top",
        },
        title: {
            display: true,
            text: "Monthly Sales and Expenses",
        },
    },
};

// Initialize the chart when the component is mounted
onMounted(() => {
    if (barChartCanvas.value) {
        barChart = new Chart(barChartCanvas.value, {
            type: "bar",
            data: chartData,
            options: chartOptions,
        });
    }
});

// Destroy the chart when the component is unmounted
onBeforeUnmount(() => {
    if (barChart) {
        barChart.destroy();
    }
});
</script>

<style scoped>
/* Tailwind classes handle most of the styling */
</style>
