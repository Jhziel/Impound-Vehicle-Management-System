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
import StaticSelection from "@/Components/StaticSelection.vue";
import InputError from "@/Components/InputError.vue";
import SelectionWithSearch from "@/Components/SelectionWithSearch.vue";
import { computed, onMounted } from "vue";
import { router, useForm } from "@inertiajs/vue3";

defineOptions({
    layout: BaseLayout,
});
const props = defineProps({
    drivers: Object,
    enforcers: Object,
    violations: Array,
    errors: Object,
});

const form = useForm({
    driver_id: "",
    enforcer_id: "",
    ticket_no: "",
    location_of_incident: "",
    status: "",
    date_of_incident: "",
    violations: [],
});

const driversWithFullName = computed(() => {
    return props.drivers.map((driver) => ({
        ...driver,
        fullName: `${driver.first_name} ${driver.last_name}`,
    }));
});

const enforcersWithFullName = computed(() => {
    return props.enforcers.map((enforcer) => ({
        ...enforcer,
        fullName: `${enforcer.first_name} ${enforcer.last_name}`,
    }));
});

const submit = () => {
    router.post("/tickets", form);
};

//Get the current Time and Date
function getCurrentDateTime() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0"); // Months are 0-based, add 1
    const day = String(now.getDate()).padStart(2, "0");
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

//get the Violation Data
function getViolationDetail(id) {
    return props.violations.find((violation) => violation.id === id) || {};
}

function getTotalFine() {
    let totalFine = 0;
    form.violations.forEach(
        (fine) => (totalFine += getViolationDetail(fine).fine)
    );
    return totalFine;
}

onMounted(() => {
    form.status = "Pending";
    form.location_of_incident = "Baclaran";
    form.date_of_incident = getCurrentDateTime();
});
</script>

<template>
    <Head>
        <title>Create-Ticket</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create Violation" link="/violations" />

        <form @submit.prevent="submit" class="mt-5 space-y-10">
            <!-- Ticket Number Input Field -->
            <FormSection>
                <SectionTitle> Ticket No </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="ticket_no">Ticket No:</FormLabel>
                        <FormInput
                            width="full"
                            type="text"
                            name="ticket_no"
                            id="ticket_no"
                            placeholder="Enter the Ticket No"
                            v-model="form.ticket_no"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Driver Selection -->
            <FormSection>
                <SectionTitle> Involved in the Incident </SectionTitle>
                <InputGroup>
                    <div class="flex gap-2">
                        <div class="w-full">
                            <FormLabel labelfor="driver_id">Driver:</FormLabel>

                            <SelectionWithSearch
                                :data="driversWithFullName"
                                id="driver_id"
                                v-model="form.driver_id"
                                placeholder="Select Driver"
                                label="fullName"
                                :reduce="(driver) => driver.id"
                            />
                            <InputError
                                :errors="errors"
                                errorMessage="driver_id"
                            />
                        </div>
                        <div class="w-full">
                            <FormLabel labelfor="enforcer_id"
                                >Enforcers:</FormLabel
                            >

                            <SelectionWithSearch
                                :data="enforcersWithFullName"
                                id="enforcer_id"
                                v-model="form.enforcer_id"
                                placeholder="Select Driver"
                                label="fullName"
                                :reduce="(enforcer) => enforcer.id"
                            />
                            <InputError
                                :errors="errors"
                                errorMessage="enforcer_id"
                            />
                        </div>
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Status Selection -->
            <FormSection>
                <SectionTitle> Status </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="status">Status:</FormLabel>
                        <StaticSelection id="status" v-model="form.status">
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                        </StaticSelection>
                        <InputError :errors="errors" errorMessage="status" />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Location of Incident Selection -->
            <FormSection>
                <SectionTitle> Location of Incident </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="location_of_incident"
                            >Location of Incident:</FormLabel
                        >
                        <StaticSelection
                            id="location_of_incident"
                            v-model="form.location_of_incident"
                        >
                            <option value="Baclaran">Baclaran</option>
                            <option value="Banay-Banay">Banay-Banay</option>
                            <option value="Banlic">Banlic</option>
                            <option value="Bigaa">Bigaa</option>
                            <option value="Butong">Butong</option>
                            <option value="Casile">Casile</option>
                            <option value="Diezmo">Diezmo</option>
                            <option value="Gulod">Gulod</option>
                            <option value="Mamatid">Mamatid</option>
                            <option value="Marinig">Marinig</option>
                            <option value="Niugan">Niugan</option>
                            <option value="Butong">Butong</option>
                            <option value="Pittland">Pittland</option>
                            <option value="Pulo">Pulo</option>
                            <option value="Sala">Sala</option>
                            <option value="San Isidro">San Isidro</option>
                            <option value="Barangay I Poblacion">
                                Barangay I Poblacion
                            </option>
                            <option value="Barangay II Poblacion">
                                Barangay II Poblacion
                            </option>
                            <option value="Barangay III Poblacion">
                                Barangay III Poblacion
                            </option>
                        </StaticSelection>
                        <InputError
                            :errors="errors"
                            errorMessage="location_of_incident"
                        />
                    </div>
                </InputGroup>
            </FormSection>

            <!-- Date of Incident -->
            <FormSection>
                <SectionTitle> Date of Incident </SectionTitle>
                <InputGroup>
                    <div class="w-1/2 mb-6">
                        <FormLabel labelfor="date_of_incident"
                            >Date of Incident:</FormLabel
                        >
                        <FormInput
                            width="full"
                            type="datetime-local"
                            name="date_of_incident"
                            id="date_of_incident"
                            placeholder="Enter the Date of  Incident"
                            v-model="form.date_of_incident"
                        />
                        <InputError :errors="errors" errorMessage="status" />
                    </div>
                </InputGroup>
            </FormSection>

            {{ form.violations }}
            <!-- Violations Selection -->
            <FormSection>
                <SectionTitle> Violations </SectionTitle>
                <InputGroup>
                    <div class="w-full mb-6">
                        <FormLabel labelfor="nationality"
                            >Violation List:</FormLabel
                        >

                        <SelectionWithSearch
                            :data="violations"
                            id="violations"
                            :multiple="true"
                            v-model="form.violations"
                            label="violation_name"
                            :reduce="(option) => option.id"
                            placeholder="Select Violations"
                        />
                        <InputError
                            :errors="errors"
                            errorMessage="nationality"
                        />
                    </div>

                    <div
                        v-if="form.violations.length > 0"
                        class="overflow-x-auto"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Violation Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Violation Code
                                    </th>
                                    <th scope="col" class="px-6 py-3">Fine</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    v-for="(
                                        violationId, index
                                    ) in form.violations"
                                    :key="index"
                                >
                                    <td
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{
                                            getViolationDetail(violationId)
                                                .violation_name
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            getViolationDetail(violationId)
                                                .violation_code
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        ₱
                                        {{
                                            getViolationDetail(violationId).fine
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr
                            class="border border-gray-500 dark:border-slate-50 w-full"
                        />
                    </div>
                    <div v-if="form.violations.length > 0" class="relative">
                        <!-- Add 'relative' to the parent container -->
                        <div class="absolute left-7">Total Fine:</div>
                        <div class="absolute left-[80%]">
                            ₱{{ getTotalFine() }}
                        </div>
                        <!-- Make sure 'right-0' is spelled correctly -->
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
