<script setup>
import {defineProps, defineEmits} from "vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    pagination: Object
})
</script>
<template>
    <nav class="relative flex justify-center">
        <Link
            v-for="link in pagination.links"
            :key="link?.label"
            preserve-scroll
            class="flex items-center justify-center px-3 py-2 text-sm rounded-lg dark:text-gray-200 text-gray-600"
            :class="{'bg-gray-200 dark:bg-gray-800': link?.active, 'opacity-50 dark:opacity-50': !link?.url}"
            :href="link?.url ?? ''"
            v-html="link?.label"/>
    </nav>
</template>
