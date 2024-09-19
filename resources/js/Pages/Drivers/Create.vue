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
import { computed, onMounted, ref, watch } from "vue";
import RadioButtonLabel from "@/Components/RadioButtonLabel.vue";
import RadioButton from "@/Components/RadioButton.vue";

defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    nationality: Object,
    locations: Object,
});

const form = useForm({
    civilStatus: "",
    gender: "",
    dateOfBirth: "",
    licenseNo: "",
    licenseType: "",
    streetAddress: "",
    province: "",
    municipality: "",
    barangay: "",
    postalCode: "",
    nationality: "",
    firstName: "",
    lastName: "",
    middleInitial: "",
    contactNo: "",
});

// License validation state
const validLicense = ref(false);

// Watch for changes in licenseType
watch(
    () => form.licenseType,
    (newValue) => {
        validLicense.value = newValue !== "No License";
        if (!validLicense.value) {
            form.licenseNo = "N/A";
        } else if (form.licenseNo === "N/A") {
            form.licenseNo = ""; // Clear 'N/A' if license is added
        }
    }
);

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
    router.post("/drivers", form);
};
onMounted(() => {
    form.licenseType = "Student";
    form.civilStatus = "Single";
});
</script>

<template>
    <Head>
        <title>Create-Driver</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Driver" link="/drivers" />

        <form @submit.prevent="submit" class="mt-5">
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

            <!-- License Type Selection -->

            <FormSection>
                <SectionTitle> License Type </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="lincenseType">
                            License Type:</FormLabel
                        >

                        <StaticSelection
                            id="lincenseType"
                            v-model="form.licenseType"
                        >
                            <option value="Student">Student</option>
                            <option value="Non-Pro">Non-Pro</option>
                            <option value="Professional">Professional</option>
                            <option value="No License">No License</option>
                        </StaticSelection>
                    </div>
                </InputGroup>
            </FormSection>

            <!-- License Number Input Field -->
            <FormSection>
                <SectionTitle class="basis-1/4 px-5"> License No </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="licenseNo"> License No:</FormLabel>

                        <FormInput
                            width="full"
                            type="text"
                            name="licenseNo"
                            id="licenseNo"
                            placeholder="Driver License Number"
                            v-model="form.licenseNo"
                            :disabled="!validLicense"
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
