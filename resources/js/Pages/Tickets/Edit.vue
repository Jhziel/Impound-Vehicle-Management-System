<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import InputGroup from "@/Components/InputGroup.vue";
import FormSection from "@/Components/FormSection.vue";
import FormTextArea from "@/Components/FormTextArea.vue";
import { router, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";

defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    violation: Object,
});

const form = useForm({
    violation_name: "",
    violation_code: "",
    violation_description: "",
    fine: "",
});

onMounted(() => {
    form.violation_name = props.violation.violation_name;
    form.violation_code = props.violation.violation_code;
    form.violation_description = props.violation.violation_description;
    form.fine = props.violation.fine;
});

const submit = (id) => {
    router.put(`/violations/${id}`, form);
};
</script>

<template>
    <Head>
        <title>Create-Violation</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Violation" link="/violations" />

        <form @submit.prevent="submit(violation.id)" class="mt-5">
            <!-- Violation Name Input Field -->
            <FormSection>
                <SectionTitle> Violation Name </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="violationName"
                            >Violation Name:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="text"
                            name="violationName"
                            id="violationName"
                            placeholder="Enter the violation Name"
                            v-model="form.violation_name"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Violation Code Input Field -->
            <FormSection>
                <SectionTitle> Violation Code </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="violationCode"
                            >Violation Code:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="text"
                            name="violationCode"
                            id="violationCode"
                            placeholder="Enter the violation Code"
                            v-model="form.violation_code"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Violation Descriptions Input Field -->
            <FormSection>
                <SectionTitle> Violation Descriptions </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="violationDescription"
                            >Violation Descriptions:</FormLabel
                        >
                        <FormTextArea
                            v-model="form.violation_description"
                            name="violationDescription"
                            placeholder="Enter a Violation description here..."
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Fine Input Field -->
            <FormSection>
                <SectionTitle> Fine </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="fine">Fine:</FormLabel>
                        <FormInput
                            width="full"
                            type="number"
                            name="fine"
                            id="fine"
                            placeholder="Enter the violation fine"
                            v-model="form.fine"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <hr class="border border-gray-500 dark:border-slate-50" />
            <!-- Form Button -->
            <div class="flex justify-center">
                <FormButton> Submit </FormButton>
            </div>
        </form>
    </FormLayout>
</template>
