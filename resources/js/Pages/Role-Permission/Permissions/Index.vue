<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { router } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRowPermissionRole from "@/Components/TableRowPermissionRole.vue";
defineOptions({ layout: BaseLayout });
defineProps({
    permissions: Object,
    filters: Object,
});

const destroy = (id) => {
    router.delete(`/permissions/${id}`);
};
</script>

<template>
    <Head>
        <title>Permissions</title>
    </Head>
    <Table
        :heads="['name', 'action']"
        linkName="New Permission"
        linkAdd="/permissions/create"
        pageTitle="Permissions List"
        :pageData="permissions"
        search="permissions"
        :currentSeach="filters"
    >
        <TableRowPermissionRole
            v-for="permission in permissions.data"
            :key="permission.id"
            :data="permission"
            link="permissions"
            @delete-permission="destroy"
        />
    </Table>
</template>
