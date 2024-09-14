<script setup>
defineProps({
    data: Object,
    link: String,
});
defineEmits(["delete-permission"]);
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
                <div class="text-base font-semibold">{{ data.name }}</div>
            </div>
        </th>
        <td class="px-6 py-4">
            <div class="flex gap-2">
                <Link
                    :href="`/${link}/${data.id}/edit`"
                    class="font-medium bg-blue-600 dark:bg-blue-500 text-white py-2 px-3"
                    >Edit user</Link
                >
                <button
                    class="font-medium bg-red-600 dark:bg-red-500 text-white py-2 px-3"
                    @click="$emit('delete-permission', data.id)"
                >
                    Delete
                </button>
            </div>
        </td>
    </tr>
</template>
