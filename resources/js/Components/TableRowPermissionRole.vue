<script setup>
defineProps({
    permission: Object,
});
</script>

<template>
    <tr
        class="bg-white dark:bg-slate-950 hover:bg-gray-50 dark:hover:bg-gray-600"
    >
        <th
            scope="row"
            class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
        >
            <div class="ps-3">
                <div class="text-base font-semibold">{{ permission.name }}</div>
            </div>
        </th>
        <td class="px-6 py-4">
            <Link
                :href="`/permissions/${permission.id}/edit`"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >Edit user</Link
            >
        </td>
    </tr>
</template>
