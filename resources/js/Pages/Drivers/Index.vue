<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
import { router, useForm } from "@inertiajs/vue3";
defineOptions({ layout: BaseLayout });

const props = defineProps({
    drivers: Object,
    filters: Object,
});
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
        />
    </Table>
</template>
