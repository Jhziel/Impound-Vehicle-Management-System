<script setup>
import SideBarLink from "@/Components/SideBarLink.vue";

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["hideSidebar"]);
</script>

<template>
    <div class="flex">
        <div
            :class="isOpen ? 'block' : 'hidden'"
            class="fixed inset-0 z-20 bg-black opacity-50"
            @click="$emit('hideSidebar')"
        ></div>
        <aside
            :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto transition duration-300 transform bg-slate-950 lg:translate-x-0 lg:static lg:inset-0 px-9"
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
                >
                    Dashboard
                </SideBarLink>

                <!-- Drivers Link -->
                <SideBarLink
                    link="/drivers"
                    :icon="['fas', 'id-card']"
                    :active="$page.url.startsWith('/drivers')"
                >
                    Drivers
                </SideBarLink>

                <!-- Impounding Area -->
                <SideBarLink
                    link="/impound-area"
                    :icon="['fas', 'map-location-dot']"
                    :active="$page.url.startsWith('/impound-area')"
                >
                    Impound Area
                </SideBarLink>

                <!-- Reports -->
                <SideBarLink
                    link="/reports"
                    :icon="['fas', 'file']"
                    :active="$page.url.startsWith('/impound_area')"
                >
                    Reports
                </SideBarLink>

                <!-- Permissions -->
                <SideBarLink
                    link="/permissions"
                    :icon="['fas', 'user-lock']"
                    :active="$page.url.startsWith('/permissions')"
                >
                    Permissions
                </SideBarLink>

                <!-- Roles -->
                <SideBarLink
                    link="/roles"
                    :icon="['fas', 'user-gear']"
                    :active="$page.url.startsWith('/roles')"
                >
                    Roles
                </SideBarLink>

                <!-- Users -->
                <SideBarLink
                    link="/users"
                    :icon="['fas', 'users']"
                    :active="$page.url.startsWith('/users')"
                >
                    Users
                </SideBarLink>

                <!-- Enforcers -->
                <SideBarLink
                    link="/enforcers"
                    :icon="['fas', 'user-nurse']"
                    :active="$page.url.startsWith('/enforcers')"
                >
                    Enforcers
                </SideBarLink>

                <!-- Violation -->
                <SideBarLink
                    link="/violations"
                    :icon="['fas', 'gavel']"
                    :active="$page.url.startsWith('/violations')"
                >
                    Violations
                </SideBarLink>

                <!-- Ticket -->
                <SideBarLink
                    link="/tickets"
                    :icon="['fas', 'file-pen']"
                    :active="$page.url.startsWith('/tickets')"
                >
                    Tickets
                </SideBarLink>

                <!-- Impoound Ticket -->
                <SideBarLink
                    link="/impound-tickets"
                    :icon="['fas', 'car-side']"
                    :active="$page.url.startsWith('/impound-tickets')"
                >
                    Impound Tickets
                </SideBarLink>
            </ul>
        </aside>
    </div>
</template>
