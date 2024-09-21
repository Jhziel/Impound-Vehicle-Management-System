<script setup>
defineProps({
    errorMessage: {
        type: String,
        
    },
    errors: {
        type:Object,
        default: "",
    }
});
</script>

<template>
    <div v-if="errors[errorMessage]">
        <p class="text-sm text-red-600">
            {{ errors[errorMessage] }}
        </p>
    </div>
</template>
