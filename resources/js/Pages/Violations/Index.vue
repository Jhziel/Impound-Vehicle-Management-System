<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
defineOptions({ layout: BaseLayout });

const props = defineProps({
    users: Object,
    filters: Object,
});
</script>

<template>
    <Head>
        <title>Drivers</title>
    </Head>
    <Table
        :heads="['name', 'code', 'fine', 'action']"
        linkName="New Violation"
        linkAdd="/violations/create"
        pageTitle="Violations List"
        :pageData="users"
        search="users"
        :currentSeach="filters"
    >
        <TableRow v-for="user in users.data" :key="user.id" :data="user" />
    </Table>
</template>
