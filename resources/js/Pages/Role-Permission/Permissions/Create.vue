<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
defineOptions({
    layout: BaseLayout,
});

const form = useForm({
    name: "",
});

const submit = () => {
    router.post("/permissions", form);
};
</script>

<template>
    <FormLayout>
        <PageHeading pageTitle="Create Permission" link="/permissions" />
        <form @submit.prevent="submit" class="mt-5">
            <div>
                <FormLabel labelfor="name">Permission</FormLabel>
                <FormInput
                    type="text"
                    name="name"
                    id="name"
                    placeholder="New Permission"
                    v-model="form.name"
                />
            </div>
            <FormButton>Submit</FormButton>
        </form>
    </FormLayout>
</template>
