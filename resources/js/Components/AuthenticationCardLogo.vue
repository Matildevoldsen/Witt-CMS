<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from "./ApplicationLogo.vue";
</script>

<template>
    <Link :href="'/'">
        <ApplicationLogo style="width: 250px;"/>
    </Link>
</template>
