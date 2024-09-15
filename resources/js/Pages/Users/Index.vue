<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import TableRow from "@/Components/TableRow.vue";
defineOptions({ layout: BaseLayout });

const props=defineProps({
    users: Object,
    filters: Object,
});
</script>

<template>
    <Head> Users </Head>
    <Table
        :heads="['name', 'position', 'permissions', 'action']"
        linkName="New User"
        linkAdd="/users/create"
        pageTitle="Users List"
        :pageData="users"
        search="users"
        :currentSeach="filters"
    >
        <TableRow v-for="user in users.data" :key="user.id" :data="user" />
    </Table>
</template>
