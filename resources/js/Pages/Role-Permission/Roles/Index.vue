<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { router } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRowPermissionRole from "@/Components/TableRowPermissionRole.vue";
defineOptions({ layout: BaseLayout });
defineProps({
    permissions: Object,
});

const destroy = (id) => {
    router.delete(`/permissions/${id}`);
};
</script>

<template>
    <Head>
        <title>Permissions</title>
    </Head>
    <Table :heads="['name', 'action']">
        <TableRowPermissionRole />
    </Table>
</template>
