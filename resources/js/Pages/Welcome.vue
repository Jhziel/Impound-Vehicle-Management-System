<script setup>
import SideBar from "@/Components/SideBar.vue";
import Header from "@/Components/Header.vue";
import { useDark, useToggle } from "@vueuse/core";
const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
    <div class="flex h-screen bg-gray-200 dark:bg-slate-900">
        <SideBar />
        <div class="flex-1 flex flex-col overflow-hidden">
            <Header :isDark="isDark" @toggleDark="toggleDark" />
            <main>
                <div
                    class="relative flex flex-col w-full min-w-0 mb-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border"
                >
                    <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                        <h6>Authors table</h6>
                    </div>
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-gray-200 text-slate-500"
                            >
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Author
                                        </th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Function
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Employed
                                        </th>
                                        <th
                                            class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b-0 whitespace-nowrap shadow-transparent"
                                        >
                                            <div class="flex px-2 py-1">
                                                <div>
                                                    <img
                                                        src=""
                                                        class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl"
                                                        alt="user6"
                                                    />
                                                </div>
                                                <div
                                                    class="flex flex-col justify-center"
                                                >
                                                    <h6
                                                        class="mb-0 leading-normal text-sm"
                                                    >
                                                        Miriam Eric
                                                    </h6>
                                                    <p
                                                        class="mb-0 leading-tight text-xs text-slate-400"
                                                    >
                                                        miriam@creative-tim.com
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b-0 whitespace-nowrap shadow-transparent"
                                        >
                                            <p
                                                class="mb-0 font-semibold leading-tight text-xs"
                                            >
                                                Programtor
                                            </p>
                                            <p
                                                class="mb-0 leading-tight text-xs text-slate-400"
                                            >
                                                Developer
                                            </p>
                                        </td>
                                        <td
                                            class="p-2 leading-normal text-center align-middle bg-transparent border-b-0 text-sm whitespace-nowrap shadow-transparent"
                                        >
                                            <span
                                                class="bg-gradient-to-tl from-green-600 to-lime-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white"
                                                >Online</span
                                            >
                                        </td>
                                        <td
                                            class="p-2 text-center align-middle bg-transparent border-b-0 whitespace-nowrap shadow-transparent"
                                        >
                                            <span
                                                class="font-semibold leading-tight text-xs text-slate-400"
                                                >14/09/20</span
                                            >
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b-0 whitespace-nowrap shadow-transparent"
                                        >
                                            <a
                                                href="javascript:;"
                                                class="font-semibold leading-tight text-xs text-slate-400"
                                            >
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
