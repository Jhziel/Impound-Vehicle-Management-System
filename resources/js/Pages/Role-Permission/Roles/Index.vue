<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { router } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRowPermissionRole from "@/Components/TableRowPermissionRole.vue";
defineOptions({ layout: BaseLayout });
defineProps({
    roles: Object,
});

const destroy = (id) => {
    router.delete(`/roles/${id}`);
};
</script>

<template>
    <Head>
        <title>Permissions</title>
    </Head>
    <Table
        :heads="['name', 'action']"
        linkName="New Role"
        linkAdd="/roles/create/"
        pageTitle="Roles List"
        :pageData="roles"
    >
        <TableRowPermissionRole
            v-for="role in roles.data"
            :key="role.id"
            :data="role"
            link="roles"
            @delete-permission="destroy"
        />
    </Table>
</template>
