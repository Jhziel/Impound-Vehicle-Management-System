<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import InputError from "@/Components/InputError.vue";
import { router, useForm } from "@inertiajs/vue3";
defineOptions({
    layout: BaseLayout,
});
defineProps({
    errors: Object,
});
const form = useForm({
    permission: "",
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
                <FormLabel labelfor="permission">Permission</FormLabel>
                <FormInput
                    type="text"
                    name="permission"
                    id="permission"
                    placeholder="New Permission"
                    v-model="form.permission"
                />
                <InputError :errors="errors" errorMessage="permission" />
            </div>
            <FormButton>Submit</FormButton>
        </form>
    </FormLayout>
</template>
