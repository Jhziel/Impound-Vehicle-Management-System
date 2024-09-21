<script setup>
import { router, usePage } from "@inertiajs/vue3";
import ToastListItem from "./ToastListItem.vue";

import { onUnmounted, ref } from "vue";
const items = ref([]);

const page = usePage();

let removeFinishEventListener = router.on("finish", () => {
    if (page.props.flash.message) {
        items.value.unshift({
            message: page.props.flash.message,
            type: page.props.flash.message_type,
            key: Symbol(),
        });
    }
});

onUnmounted(() => {
    removeFinishEventListener();
});
const remove = (index) => {
    items.value.splice(index, 1);
};
</script>

<template>
    <TransitionGroup
        tag="div"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
        class="fixed right-5 top-5 z-50 w-full max-w-xs space-y-3"
    >
        <ToastListItem
            v-for="(item, index) in items"
            :key="item.key"
            :message="item.message"
            :type="item.type"
            @remove="remove(index)"
        />
    </TransitionGroup>
</template>
