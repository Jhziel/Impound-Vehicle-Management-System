<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import Table from "@/Components/Table.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineOptions({ layout: BaseLayout });
</script>

<template>
    <Head>
        <title>Drivers</title>
    </Head>
    <Table />
</template>
