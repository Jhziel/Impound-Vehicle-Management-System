<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
defineOptions({ layout: BaseLayout });

defineProps({
    users: Array,
});
</script>

<template>
    <Head> Users </Head>
    <Table
        :heads="['name', 'position', 'permissions', 'action']"
        linkName="New User"
        linkAdd="/users/create"
        pageTitle="Users List"
    >
        <TableRow v-for="user in users" :key="index" :data="user" />
    </Table>
</template>
