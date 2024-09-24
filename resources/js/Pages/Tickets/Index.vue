<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
import Swal from "sweetalert2";
import TableItems from "@/Components/TableItems.vue";
import { router } from "@inertiajs/vue3";
defineOptions({ layout: BaseLayout });

const props = defineProps({
    tickets: Object,
    filters: Object,
});

const deleteViolation = (id) => {
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
            router.delete(`/tickets/${id}`);
        }
    });
};
</script>

<template>
    <Head>
        <title>Tickets</title>
    </Head>
    <Table
        :heads="[
            'Ticket Number',
            'Violator Name',
            'Enforcer Name',
            'status',
            'action',
        ]"
        linkName="New Ticket"
        linkAdd="/tickets/create"
        pageTitle="Ticket List"
        :pageData="tickets"
        search="tickets"
        :currentSeach="filters"
    >
        <TableRow
            v-for="ticket in tickets.data"
            :key="ticket.id"
            :data="ticket"
        >
            <template #row-data="{ data }">
                <TableItems>
                    {{ data.ticket_no }}
                </TableItems>
                <TableItems>
                    {{ data.driver.first_name }}
                    {{ data.driver.last_name }}
                </TableItems>
                <TableItems>
                    {{ data.enforcer.first_name }}
                    {{ data.enforcer.last_name }}
                </TableItems>
                <TableItems>
                    {{ data.status }}
                </TableItems>
                <td class="px-6 py-4 flex gap-3">
                    <Link
                        :href="`/tickets/${data.id}/edit`"
                        class="font-medium bg-blue-600 dark:bg-blue-500 text-slate-50 px-4 py-2"
                        >Edit</Link
                    >
                    <button
                        class="font-medium bg-red-600 dark:bg-red-500 text-slate-50 px-4 py-2"
                        @click="deleteViolation(data.id)"
                    >
                        Delete
                    </button>
                </td>
            </template>
        </TableRow>
    </Table>
</template>
