<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormCheckBox from "@/Components/FormCheckBox.vue";
import CheckBoxLayout from "@/Components/CheckBoxLayout.vue";
import SelectionWithSearch from "@/Components/SelectionWithSearch.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";

defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    nationality: Object,
    locations: Object,
});

const form = useForm({
    civilStatus: "",
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
            form.licenseNo = "";
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
            <div class="flex items-center mb-10">
                <div class="basis-1/4 px-5">
                    <h1 class="text-2xl text-gray-800 dark:text-slate-50">
                        Name
                    </h1>
                </div>
                <div class="basis-3/4">
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
                </div>
            </div>

            <!-- Address Information -->
            <div class="flex items-center mb-10">
                <div class="basis-1/4 px-5 self-start mt-8">
                    <h1 class="text-2xl text-gray-800 dark:text-slate-50">
                        Address
                    </h1>
                </div>
                <div class="basis-3/4 flex flex-col">
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
                </div>
            </div>

            <!-- Cell Phone Number -->
            <div class="flex items-center mb-10">
                <div class="basis-1/4 px-5">
                    <h1 class="text-2xl text-gray-800 dark:text-slate-50">
                        Cell Phone No.
                    </h1>
                </div>
                <div class="basis-3/4">
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
                </div>
            </div>

            <!-- Civil Status Selection-->
            <div class="flex items-center mb-10">
                <div class="basis-1/4 px-5">
                    <h1 class="text-2xl text-gray-800 dark:text-slate-50">
                        Civil Status
                    </h1>
                </div>
                <div class="basis-3/4">
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="civil_status"
                            >Civil Status:</FormLabel
                        >
                        <select
                            id="civil_status"
                            class="bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="form.civilStatus"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Nationality Selection -->
            <div class="flex items-center">
                <div class="basis-1/4 px-5">
                    <h1 class="text-2xl text-gray-800 dark:text-slate-50">
                        Nationality
                    </h1>
                </div>
                <div class="basis-3/4">
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="civil_status"
                            >Civil Status:</FormLabel
                        >

                        <SelectionWithSearch
                            :data="nationality"
                            v-model="form.nationality"
                            placeholder="Select Nationality"
                        />
                    </div>
                </div>
            </div>

            <!-- Form Button -->
            <FormButton> Submit </FormButton>
        </form>
    </FormLayout>
</template>
