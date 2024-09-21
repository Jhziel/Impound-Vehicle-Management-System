<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
import TableItems from "@/Components/TableItems.vue";
import Swal from "sweetalert2";
import { Link, router, useForm } from "@inertiajs/vue3";

defineOptions({ layout: BaseLayout });

const props = defineProps({
    drivers: Object,
    filters: Object,
});

const deleteDriver = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/drivers/${id}`);
        }
    });
};
</script>

<template>
    <Head>
        <title>Drivers</title>
    </Head>

    <Table
        :heads="['name', 'license no', 'license type', 'action']"
        linkName="New Driver"
        linkAdd="/drivers/create"
        pageTitle="Drivers List"
        :pageData="drivers"
        search="drivers"
        :currentSeach="filters"
    >
        <TableRow
            v-for="driver in drivers.data"
            :key="driver.id"
            :data="driver"
        >
            <template #row-data="{ data }">
                <!-- Define the columns dynamically using slots -->
                <TableItems>
                    {{ data.first_name }} {{ data.last_name }}
                </TableItems>
                <TableItems>{{ data.license_no }}</TableItems>
                <TableItems class="px-6 py-4">{{
                    data.license_type
                }}</TableItems>
                <td class="px-6 py-4 flex gap-3">
                    <Link
                        :href="`/drivers/${data.id}/edit`"
                        class="font-medium bg-blue-600 dark:bg-blue-500 text-slate-50 px-4 py-2"
                        >Edit</Link
                    >
                    <button
                        class="font-medium bg-red-600 dark:bg-red-500 text-slate-50 px-4 py-2"
                        @click="deleteDriver(data.id)"
                    >
                        Delete
                    </button>
                </td>
            </template>
        </TableRow>
    </Table>
</template>
