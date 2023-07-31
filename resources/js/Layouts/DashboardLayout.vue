<template>
    <SidebarNavigation>
        <Head :title="title"/>

        <slot/>
    </SidebarNavigation>
</template>
<script setup>
import ApplicationLogo from "../Components/ApplicationLogo.vue";
import CSVImporter from "../Components/CSVImporter.vue";
import SidebarNavigation from "../Components/Dashboard/SidebarNavigation.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    title: String
})
</script>
