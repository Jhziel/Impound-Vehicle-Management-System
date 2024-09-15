<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import CheckBoxLayout from "@/Components/CheckBoxLayout.vue";
import FormCheckBox from "@/Components/FormCheckBox.vue";
import { router, useForm } from "@inertiajs/vue3";
defineOptions({
    layout: BaseLayout,
});

defineProps({
    permissions: Object,
});

const form = useForm({
    name: "",
    permissions: [],
});

const submit = () => {
    router.post("/roles", form);
};
</script>

<template>
    <FormLayout>
        <PageHeading pageTitle="Create Role" link="/roles" />

        <form @submit.prevent="submit" class="mt-5">
            <div>
                <FormLabel labelfor="name">Roles</FormLabel>

                <FormInput
                    type="text"
                    name="name"
                    id="name"
                    placeholder="New Roles"
                    v-model="form.name"
                />
            </div>

            <CheckBoxLayout
                class="items-center grid grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
                <FormCheckBox
                    v-for="permission in permissions"
                    :key="permission.id"
                    :name="permission.name"
                    type="checkbox"
                    :value="permission.name"
                    v-model="form.permissions"
                />
            </CheckBoxLayout>

            <FormButton :disabled="form.processing"> Submit </FormButton>
        </form>
    </FormLayout>
</template>
