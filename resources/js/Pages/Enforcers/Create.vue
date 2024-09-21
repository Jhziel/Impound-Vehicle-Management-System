<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import SelectionWithSearch from "@/Components/SelectionWithSearch.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import InputGroup from "@/Components/InputGroup.vue";
import FormSection from "@/Components/FormSection.vue";
import { router, useForm } from "@inertiajs/vue3";
import StaticSelection from "@/Components/StaticSelection.vue";
import { computed, onMounted, watch } from "vue";
import RadioButton from "@/Components/RadioButton.vue";

defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    nationality: Object,
    locations: Object,
});

const form = useForm({
    first_name: "",
    last_name: "",
    middle_name_initial: "",
    street_address: "",
    province: "",
    municipality: "",
    barangay: "",
    postal_code: "",
    contact_no: "",
    nationality: "",
    civil_status: "",
    gender: "",
    date_of_birth: "",
    badge_no: "",
});

//get province data
const province = Object.keys(props.locations).sort();

//get municipality data
const municipality = computed(() => {
    if (!form.province) return [];

    const selectedProvince = props.locations[form.province];

    return Object.keys(selectedProvince.municipality_list);
});

//get barangay data
const barangay = computed(() => {
    if (!form.municipality) return [];

    const selectedMunicipality =
        props.locations[form.province].municipality_list[form.municipality];

    return selectedMunicipality.barangay_list;
});

//Watch for changes in province
watch(
    () => form.province,
    () => {
        form.municipality = ""; // Reset municipality when province changes
    }
);
//Watch for changes in municipality
watch(
    () => form.municipality,
    () => {
        form.barangay = ""; // Reset municipality when province changes
    }
);

const submit = () => {
    router.post("/enforcers", form);
};
onMounted(() => {
    form.civilStatus = "Single";
});
</script>

<template>
    <Head>
        <title>Create-Enforcer</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Enforcer" link="/enforcers" />

        <form @submit.prevent="submit" class="mt-5 space-y-10">
            <!-- Badge Number Input Field -->
            <FormSection>
                <SectionTitle> Badge No. </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="badgeNo">Badge#:</FormLabel>
                        <FormInput
                            width="full"
                            type="text"
                            name="badgeNo"
                            id="badgeNo"
                            placeholder="Enforcer Badge Number"
                            v-model="form.badgeNo"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Full Name Input Field -->
            <FormSection>
                <SectionTitle> Name </SectionTitle>
                <InputGroup>
                    <div class="flex gap-2 mb-2">
                        <!--First Name input field  -->
                        <div class="w-full">
                            <FormLabel labelfor="firstName"
                                >First Name:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="firstName"
                                id="firstName"
                                placeholder="User First Name"
                                v-model="form.firstName"
                            />
                        </div>

                        <!--Last Name input field  -->
                        <div class="w-full">
                            <FormLabel labelfor="lastName"
                                >Last Name:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="lastName"
                                id="lastName"
                                placeholder="User Last Name"
                                v-model="form.lastName"
                            />
                        </div>
                        <!--Suffix  input field  -->
                        <div class="w-full basis-1/4">
                            <FormLabel labelfor="middleInitial">M.I</FormLabel>
                            <FormInput
                                width="full"
                                type="text"
                                name="middleInitial"
                                id="middleInitial"
                                placeholder="Driver M.I"
                                v-model="form.middleInitial"
                            />
                        </div>
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Address Information -->
            <FormSection class="flex items-center mb-10">
                <SectionTitle> Address </SectionTitle>
                <InputGroup>
                    <!--Street Address input field  -->
                    <div class="w-full mb-6">
                        <FormLabel labelfor="streetAddress"
                            >Street Address:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="text"
                            name="streetAddress"
                            id="streetAddress"
                            placeholder="Driver street address"
                            v-model="form.streetAddress"
                        />
                    </div>

                    <div class="flex gap-2 mb-6">
                        <!-- Province Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="province">Province:</FormLabel>
                            <SelectionWithSearch
                                :data="province"
                                v-model="form.province"
                                placeholder="Select Province"
                            />
                        </div>

                        <!-- Municipality Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="municipality"
                                >Municipality:</FormLabel
                            >
                            <SelectionWithSearch
                                :data="municipality"
                                v-model="form.municipality"
                                placeholder="Select Municipality"
                            />
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <!-- Barangay Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="barangay">Barangay:</FormLabel>
                            <SelectionWithSearch
                                :data="barangay"
                                v-model="form.barangay"
                                placeholder="Select Barangay"
                            />
                        </div>

                        <!-- Postal Code Input Field -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="postalCode"
                                >Postal Code:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="postalCode"
                                id="postalCode"
                                placeholder="ex.4025"
                                v-model="form.postalCode"
                            />
                        </div>
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Cell Phone Number -->
            <FormSection>
                <SectionTitle> Cell Phone No. </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="contactNo">Cell Phone#:</FormLabel>
                        <FormInput
                            width="full"
                            type="text"
                            name="contactNo"
                            id="contactNo"
                            placeholder="Driver Cell Phone Number"
                            v-model="form.contactNo"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Civil Status Selection-->
            <FormSection>
                <SectionTitle> Civil Status </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="civilStatus"
                            >Civil Status:</FormLabel
                        >
                        <StaticSelection
                            id="civilStatus"
                            v-model="form.civilStatus"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </StaticSelection>
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Nationality Selection -->
            <FormSection class="flex items-center mb-10">
                <SectionTitle> Nationality </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="nationality"
                            >Nationality:</FormLabel
                        >

                        <SelectionWithSearch
                            :data="nationality"
                            v-model="form.nationality"
                            placeholder="Select Nationality"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Gender Selection -->
            <FormSection class="flex items-center mb-10">
                <SectionTitle> Gender </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="gender">Gender:</FormLabel>

                        <!-- Male Radio Button -->
                        <RadioButton
                            value="Male"
                            v-model="form.gender"
                            mb="4"
                        />

                        <!-- Female Radio Button -->
                        <RadioButton
                            value="Female"
                            v-model="form.gender"
                            mb=""
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Birth Day Selection -->
            <FormSection>
                <SectionTitle> Date of Birth </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="date_of_birth">
                            Date of Birth:</FormLabel
                        >

                        <FormInput
                            width="full"
                            type="date"
                            name="contactNo"
                            id="date_of_birth"
                            placeholder="Driver Cell Phone Number"
                            v-model="form.dateOfBirth"
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
