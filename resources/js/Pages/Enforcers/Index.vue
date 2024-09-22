<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
import TableItems from "@/Components/TableItems.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
defineOptions({ layout: BaseLayout });

const props = defineProps({
    enforcers: Object,
    filters: Object,
});

const deleteEnforcer = (id) => {
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
            router.delete(`/enforcers/${id}`);
        }
    });
};
</script>

<template>
    <Head>
        <title>Drivers</title>
    </Head>
    <Table
        :heads="['name', 'Badge no', 'Status', 'action']"
        linkName="New Enforcer"
        linkAdd="/enforcers/create"
        pageTitle="Enforcers List"
        :pageData="enforcers"
        search="enforcers"
        :currentSeach="filters"
    >
        <TableRow
            v-for="enforcer in enforcers.data"
            :key="enforcer.id"
            :data="enforcer"
        >
            <template #row-data="{ data }">
                <!-- Define the columns dynamically using slots -->
                <TableItems>
                    {{ data.first_name }} {{ data.last_name }}
                </TableItems>
                <TableItems>{{ data.badge_no }}</TableItems>
                <TableItems>{{ data.status }}</TableItems>
                <td class="px-6 py-4 flex gap-3">
                    <Link
                        :href="`/enforcers/${data.id}/edit`"
                        class="font-medium bg-blue-600 dark:bg-blue-500 text-slate-50 px-4 py-2"
                        >Edit</Link
                    >
                    <button
                        class="font-medium bg-red-600 dark:bg-red-500 text-slate-50 px-4 py-2"
                        @click="deleteEnforcer(data.id)"
                    >
                        Delete
                    </button>
                </td>
            </template>
        </TableRow>
    </Table>
</template>
