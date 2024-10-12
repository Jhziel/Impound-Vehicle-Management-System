<script setup>
import FormLayout from "@/Layouts/FormLayout.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";

defineOptions({
    layout: BaseLayout,
});

const props = defineProps({
    slots: Object,
});
console.log(props.slots);

const slotLeft = props.slots.filter((slot) => slot.slot_code.startsWith("L"));
const slotRight = props.slots.filter((slot) => slot.slot_code.startsWith("R"));
const slotTop = props.slots.filter((slot) => slot.slot_code.startsWith("T"));

/* const selectSlot = (slot) => {
    if (!slot.is_occupied) {
        form.slot = slot.id;
    }
}; */
const showEdit = ref(false);
const currentSlot = ref(null);
const show = ref(false);
const showModal = (slot) => {
    show.value = !show.value;
};
const closeModal = () => {
    show.value = false;
};
</script>

<template>
    <FormLayout>
        <div class="text-center">
            <button @click="showModal" class="bg-green-500 px-2 py-2">
                Show
            </button>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-slate-50">
                Impound Area
            </h1>
        </div>

        <div class="flex justify-center items-center gap-2">
            <div class="bg-green-500 w-8 border h-8"></div>
            <p class="text-gray-800 dark:text-slate-50 font-semibold text-2xl">
                Vacant
            </p>
            <div class="bg-red-500 w-8 border h-8"></div>
            <p class="text-gray-800 dark:text-slate-50 font-semibold text-2xl">
                Occupied
            </p>
        </div>
        <div class="grid grid-cols-12 grid-rows-12">
            <div
                v-for="(slot, index) in slotTop"
                :key="index"
                :class="[
                    slot.is_occupied
                        ? 'bg-red-500' // If occupied, make it red
                        : 'bg-green-500 hover:bg-yellow-400', // Compare selected slot ID
                ]"
                class="border flex justify-center items-center cursor-pointer"
                @click="showModal(slot)"
            >
                {{ slot.slot_code }}
            </div>
            <!--  -->
            <div class="col-start-1 row-start-2 row-end-13">
                <div
                    v-for="(slot, index) in slotLeft"
                    :key="index"
                    :class="[
                        slot.is_occupied
                            ? 'bg-red-500' // If occupied, make it red
                            : 'bg-green-500 hover:bg-yellow-400',
                    ]"
                    class="border h-20 flex justify-center items-center cursor-pointer"
                    @click="showModal(slot)"
                >
                    {{ slot.slot_code }}
                </div>
            </div>

            <div class="col-start-12 row-start-2 row-end-13">
                <div
                    v-for="(slot, index) in slotRight"
                    :key="index"
                    :class="[
                        slot.is_occupied
                            ? 'bg-red-500' // If occupied, make it red
                            : 'bg-green-500 hover:bg-yellow-400',
                    ]"
                    class="border h-20 flex justify-center items-center cursor-pointer"
                    @click="showModal(slot)"
                >
                    {{ slot.slot_code }}
                </div>
            </div>
        </div>
    </FormLayout>
    <Modal :show="show" @close="closeModal">
        <dir v-if="condition"></dir>
    </Modal>
</template>
