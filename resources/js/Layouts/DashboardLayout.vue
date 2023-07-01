<template>
    <SidebarNavigation>
        <slot/>
    </SidebarNavigation>
</template>
<script setup>
import ApplicationLogo from "../Components/ApplicationLogo.vue";
import CSVImporter from "../Components/CSVImporter.vue";
import SidebarNavigation from "../Components/Dashboard/SidebarNavigation.vue";
</script>
