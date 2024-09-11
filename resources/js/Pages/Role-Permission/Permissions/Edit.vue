<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    permission: Object,
});

const form = useForm({
    name: "",
});

const submit = () => {
    router.put(`/permissions/${props.permission.id}`, form);
};

onMounted(() => {
    if (props.permission) {
        form.name = props.permission.name;
    }
});
</script>

<template>
    <div class="bg-gray-800 mt-10 text-white py-7 px-5">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Edit Permission</h1>
            <Link href="/permissions" class="bg-red-500 py-2 px-4"
                ><font-awesome-icon
                    :icon="['fas', 'arrow-left']"
                    class="mr-1"
                />Back</Link
            >
        </div>

        <form @submit.prevent="submit" class="mt-5">
            <div>
                <label for="name" class="text-lg font-semibold block"
                    >Permission</label
                >

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="New Permission"
                    required
                    v-model="form.name"
                />
            </div>
            <button type="submit" class="bg-blue-500 py-2 px-4 w-24 mt-3">
                Update
            </button>
        </form>
    </div>
</template>
