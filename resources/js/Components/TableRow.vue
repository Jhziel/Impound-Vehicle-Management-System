<script setup>
defineProps({
    data: Array,
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
            <img
                class="w-10 h-10 rounded-full"
                src="/docs/images/people/profile-picture-4.jpg"
                alt="Jese image"
            />
            <div class="ps-3">
                <div class="text-base font-semibold">{{ data.name }}</div>
            </div>
        </th>
        <td class="px-6 py-4"></td>
        <td class="px-6 py-4">
            <div class="flex items-center">
                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                Offline
            </div>
        </td>
        <td class="px-6 py-4">
            <a
                href="#"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >Edit user</a
            >
        </td>
    </tr>
</template>
