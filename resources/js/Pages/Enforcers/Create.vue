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
import InputError from "@/Components/InputError.vue";
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
    errors: Object,
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
    status: "Active",
});

//get province data
let province = Object.keys(props.locations).sort();

province = province.map((prov) => {
    return { province: prov };
});

//get municipality data
const municipality = computed(() => {
    if (!form.province) return [];

    const selectedProvince = props.locations[form.province];

    return Object.keys(selectedProvince.municipality_list).map(
        (municipalityKey) => {
            return { municipality: municipalityKey };
        }
    );
});

//get barangay data
const barangay = computed(() => {
    if (!form.municipality) return [];

    const selectedMunicipality =
        props.locations[form.province].municipality_list[form.municipality];

    return selectedMunicipality.barangay_list.map((barangay) => {
        return { barangay: barangay };
    });
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
    form.civil_status = "Single";
});
</script>

<template>
    <Head>
        <title>Create-Enforcer</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Enforcer" link="/enforcers" />

        <form @submit.prevent="submit" class="mt-5 space-y-10">
            <input type="text" hidden v-model="form.status" />
            <!-- Badge Number Input Field -->
            <FormSection>
                <SectionTitle> Badge No. </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="badge_no">Badge#:</FormLabel>
                        <FormInput
                            width="full"
                            type="text"
                            name="badge_no"
                            id="badge_no"
                            placeholder="Enforcer Badge Number"
                            v-model="form.badge_no"
                        />

                        <!-- Badge Number Error -->
                        <InputError :errors="errors" errorMessage="badge_no" />
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
                            <FormLabel labelfor="first_name"
                                >First Name:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="first_name"
                                id="first_name"
                                placeholder="User First Name"
                                v-model="form.first_name"
                            />

                            <!-- First Name Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="first_name"
                            />
                        </div>

                        <!--Last Name input field  -->
                        <div class="w-full">
                            <FormLabel labelfor="last_name"
                                >Last Name:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="last_name"
                                id="last_name"
                                placeholder="User Last Name"
                                v-model="form.last_name"
                            />

                            <!-- Last Name Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="last_name"
                            />
                        </div>
                        <!--Middle Initial  input field  -->
                        <div class="w-full basis-1/4">
                            <FormLabel labelfor="middle_name_initial"
                                >M.I</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="text"
                                name="middle_name_initial"
                                id="middle_name_initial"
                                placeholder="Driver M.I"
                                v-model="form.middle_name_initial"
                                maxlength="3"
                            />

                            <!-- Middle Initial Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="middle_name_initial"
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
                        <FormLabel labelfor="street_address"
                            >Street Address:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="text"
                            name="street_address"
                            id="street_address"
                            placeholder="Driver street address"
                            v-model="form.street_address"
                        />

                        <!-- Street Address Error -->
                        <InputError
                            :errors="errors"
                            errorMessage="street_address"
                        />
                    </div>

                    <div class="flex gap-2 mb-6">
                        <!-- Province Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="province">Province:</FormLabel>
                            <SelectionWithSearch
                                id="province"
                                :data="province"
                                label="province"
                                v-model="form.province"
                                placeholder="Select Province"
                                :reduce="(option) => option.province"
                            />

                            <!-- Province Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="province"
                            />
                        </div>

                        <!-- Municipality Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="municipality"
                                >Municipality:</FormLabel
                            >
                            <SelectionWithSearch
                                :data="municipality"
                                label="municipality"
                                :reduce="(option) => option.municipality"
                                v-model="form.municipality"
                                placeholder="Select Municipality"
                            />

                            <!-- Municipality Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="municipality"
                            />
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <!-- Barangay Selection -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="barangay">Barangay:</FormLabel>
                            <SelectionWithSearch
                                :data="barangay"
                                label="barangay"
                                :reduce="(option) => option.barangay"
                                v-model="form.barangay"
                                placeholder="Select Barangay"
                            />

                            <!-- Barangay Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="barangay"
                            />
                        </div>

                        <!-- Postal Code Input Field -->
                        <div class="flex flex-col w-full">
                            <FormLabel labelfor="postal_code"
                                >Postal Code:</FormLabel
                            >
                            <FormInput
                                width="full"
                                type="number"
                                name="postal_code"
                                id="postal_code"
                                placeholder="ex.4025"
                                v-model="form.postal_code"
                            />

                            <!-- Postal Code Error -->
                            <InputError
                                :errors="errors"
                                errorMessage="postal_code"
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
                        <FormLabel labelfor="contact_no"
                            >Cell Phone#:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="number"
                            name="contact_no"
                            id="contact_no"
                            placeholder="Driver Cell Phone Number"
                            v-model="form.contact_no"
                        />

                        <!-- Cell Phone# Error -->
                        <InputError
                            :errors="errors"
                            errorMessage="contact_no"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Civil Status Selection-->
            <FormSection>
                <SectionTitle> Civil Status </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="civil_status"
                            >Civil Status:</FormLabel
                        >
                        <StaticSelection
                            id="civil_status"
                            v-model="form.civil_status"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </StaticSelection>

                        <!-- Civil Status Error -->
                        <InputError
                            :errors="errors"
                            errorMessage="civil_status"
                        />
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
                            id="nationality"
                            v-model="form.nationality"
                            label="nationality"
                            :reduce="(option) => option.nationality"
                            placeholder="Select Nationality"
                        />
                    </div>

                    <!-- Nationality Error -->
                    <InputError :errors="errors" errorMessage="nationality" />
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

                        <!-- Gender Error -->
                        <InputError :errors="errors" errorMessage="gender" />
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
                            name="contact_no"
                            id="date_of_birth"
                            placeholder="Driver Cell Phone Number"
                            v-model="form.date_of_birth"
                        />

                        <!-- Date of Birth Error -->
                        <InputError
                            :errors="errors"
                            errorMessage="date_of_birth"
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
