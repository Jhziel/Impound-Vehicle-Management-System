<script setup>
import SideBarLink from "@/Components/SideBarLink.vue";
</script>

<template>
    <div class="flex">
        <div class="fixed inset-0 z-20 opacity-50 hidden"></div>
        <aside
            class="fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto transition duration-300 transform bg-slate-950 lg:translate-x-0 lg:static lg:inset-0 -translate-x-full px-9"
        >
            <div class="text-slate-50 mt-4 font-bold text-2xl">
                <a href="/">Logo Here</a>
            </div>
            <ul class="flex flex-col mt-20 gap-3">
                <!-- Dashboard Link -->
                <SideBarLink
                    link="/"
                    :icon="['fas', 'house']"
                    :active="$page.url === '/'"
                    >Dashboard</SideBarLink
                >

                <!-- Drivers Link -->
                <SideBarLink
                    link="/drivers"
                    :icon="['fas', 'id-card']"
                    :active="$page.url.startsWith('/drivers')"
                    >Drivers</SideBarLink
                >
            </ul>
        </aside>
    </div>
</template>
