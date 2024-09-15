<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";

defineOptions({ layout: BaseLayout });
</script>

<template>
    <Head>
        <title>Drivers</title>
    </Head>
    <Table
        :heads="['name', 'position', 'status', 'action']"
        linkName="New Driver"
        linkAdd="asdadssad"
        pageTitle="Users List"
    >
        <TableRow  />
        
    </Table>
</template>
