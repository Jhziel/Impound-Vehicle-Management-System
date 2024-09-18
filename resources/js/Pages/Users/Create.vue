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
import { computed, onMounted } from "vue";
defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    roles: Object,
});
const form = useForm({
    role: "",
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    password_confirmation: "",
    permissions: [],
});

const filteredPermissions = computed(() => {
    if (!form.role) return [];

    const selectedRole = props.roles.find((role) => role.id == form.role);

    // If a role is selected and it has permissions, return those permissions
    if (selectedRole) {
        return selectedRole.permissions;
    }

    return [];
});
const submit = () => {
    router.post("/users", form);
};

onMounted(() => {
    if (props.roles.length > 0) {
        form.role = props.roles[0].id; // Set the first role's ID as the selected value
    }
});
</script>

<template>
    <Head>
        <title>Create-User</title>
    </Head>
    <FormLayout>
        <PageHeading pageTitle="Create User" link="/users" />

        <form @submit.prevent="submit" class="mt-5">
            <!-- Role Selection -->
            <FormLabel labelfor="roles">Role:</FormLabel>
            <select
                id="roles"
                class="bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-[465px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.role"
            >
                <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{ role.name }}
                </option>
            </select>

            <!-- Name Input -->
            <div class="flex gap-10 mt-3">
                <!--First Name input field  -->
                <div class="w-full">
                    <FormLabel labelfor="firstName">First Name:</FormLabel>
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
                    <FormLabel labelfor="lastName">Last Name:</FormLabel>
                    <FormInput
                        width="full"
                        type="text"
                        name="lastName"
                        id="lastName"
                        placeholder="User Last Name"
                        v-model="form.lastName"
                    />
                </div>
            </div>

            <!--Email input field  -->
            <div class="mt-3">
                <FormLabel labelfor="email">Email:</FormLabel>
                <FormInput
                    width="[465px]"
                    type="email"
                    name="email"
                    id="email"
                    placeholder="User Email"
                    v-model="form.email"
                />
            </div>

            <!-- Password and Confirm Password input field -->
            <div class="flex gap-10 mt-3">
                <!-- Password input field -->
                <div class="w-full">
                    <FormLabel labelfor="password"> Password:</FormLabel>
                    <FormInput
                        width="full"
                        type="password"
                        name="password"
                        id="password"
                        placeholder="User Password"
                        v-model="form.password"
                    />
                </div>

                <!-- Confirm Password input field -->
                <div class="w-full">
                    <FormLabel labelfor="password_confirmation"
                        >Confirm Password:</FormLabel
                    >
                    <FormInput
                        width="full"
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="Confirm Password"
                        v-model="form.password_confirmation"
                    />
                </div>
            </div>

            <CheckBoxLayout
                class="items-center grid grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
                <FormCheckBox
                    v-for="permission in filteredPermissions"
                    :key="permission.id"
                    :name="permission.name"
                    type="checkbox"
                    :value="permission.name"
                    v-model="form.permissions"
                />
            </CheckBoxLayout>

            <!-- Form Button -->
            <FormButton> Submit </FormButton>
        </form>
    </FormLayout>
</template>
