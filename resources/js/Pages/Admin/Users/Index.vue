<script setup>
import Table from "@/Components/Table.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
defineOptions({ layout: BaseLayout });
</script>

<template>
    <Head> Users </Head>
    <Table
        :heads="['name', 'position', 'permissions', 'action']"
        linkName="New User"
        linkAdd="/users/create"
        pageTitle="Users List"
    ></Table>
</template>
