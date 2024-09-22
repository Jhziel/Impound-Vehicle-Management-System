<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
import TableItems from "@/Components/TableItems.vue";
defineOptions({ layout: BaseLayout });

const props = defineProps({
    violations: Object,
    filters: Object,
});
</script>

<template>
    <Head>
        <title>Violations</title>
    </Head>
    <Table
        :heads="['name', 'code', 'fine', 'action']"
        linkName="New Violation"
        linkAdd="/violations/create"
        pageTitle="Violations List"
        :pageData="violations"
        search="violations"
        :currentSeach="filters"
    >
        <TableRow
            v-for="violation in violations.data"
            :key="violation.id"
            :data="violation"
        >
            <template #row-data="{ data }">
                <!-- Define the columns dynamically using slots -->
                <TableItems>
                    {{ data.violation_name }}
                </TableItems>
                <TableItems>{{ data.violation_code }}</TableItems>
                <TableItems>₱ {{ data.fine }}</TableItems>
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
