<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import FormInput from "@/Components/FormInput.vue";
import FormLayout from "@/Layouts/FormLayout.vue";
import FormButton from "@/Components/FormButton.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormCheckBox from "@/Components/FormCheckBox.vue";
import CheckBoxLayout from "@/Components/CheckBoxLayout.vue";
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
    province: "",
    municipality: "",
    barangay: "",
    nationality: "",
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    password_confirmation: "",
    permissions: [],
});

//Province data
const province = Object.keys(props.locations).sort();

const emptyMunicipalityselect = () => {
    form.municipality = null;
};

const municipality = computed(() => {
    if (!form.province) return [];

    const selectedProvince = props.locations[form.province];

    return Object.keys(selectedProvince.municipality_list);
});

const barangay = computed(() => {
    if (!form.municipality) return [];

    const selectedMunicipality =
        props.locations[form.province].municipality_list[form.municipality];

    return selectedMunicipality.barangay_list;
});

// Get an array of municipality names (keys)
const barangayNames = props.locations["BATANGAS"].municipality_list;
console.log(props.locations);

const submit = () => {
    router.post("/drivers", form);
};
//Watch for changes in province
watch(
    () => form.province,
    () => {
        form.municipality = ""; // Reset municipality when province changes
    }
);
onMounted(() => {
    /* form.province = "LAGUNA"; */
    // Set the first role's ID as the selected value
});
</script>

<template>
    <Head>
        <title>Create-Driver</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Driver" link="/drivers" />

        <form @submit.prevent="submit" class="mt-5">
            <!-- Nationality Selection  -->
            <v-select
                class="bg-gray-50 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-[465px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.nationality"
                :options="nationality"
                placeholder="Select one"
                label="nationality"
            >
                <template #selected-option="{ nationality }">
                    <div class="text-black dark:text-white">
                        {{ nationality }}
                    </div>
                </template>
            </v-select>

            <v-select
                class="bg-gray-50 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-[465px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.province"
                :options="province"
                label="province"
                placeholder="Select province"
            >
                <template #selected-option="{ province }">
                    <div class="text-black dark:text-white">
                        {{ province }}
                    </div>
                </template>
            </v-select>

            <v-select
                class="bg-gray-50 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-[465px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.municipality"
                :options="municipality"
                label="municipality"
                placeholder="Select one"
            >
                <template #selected-option="{ municipality }">
                    <div class="text-black dark:text-white">
                        {{ municipality }}
                    </div>
                </template>
            </v-select>

            <v-select
                class="bg-gray-50 cursor-pointer w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-[465px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.barangay"
                :options="barangay"
                label="barangay"
                placeholder="Select one"
            >
                <template #selected-option="{ barangay }">
                    <div class="text-black dark:text-white">
                        {{ barangay }}
                    </div>
                </template>
            </v-select>

            <!-- Name Input -->

            <!--Email input field  -->

            <!-- Password and Confirm Password input field -->

            <!-- Form Button -->
            <FormButton> Submit </FormButton>
        </form>
    </FormLayout>
</template>
