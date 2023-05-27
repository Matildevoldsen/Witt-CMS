<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
    <AppLayout>
        <div class="py-12 mx-auto gap-6 sm:px-6 px-8 md:space-y-0 space-y-6 sm:px-6 lg:px-8 max-w-7xl md:grid grid-cols-7">
            <div class="col-span-2">
                <slot name="side"/>
            </div>
            <div class="col-span-5">
                <slot/>
            </div>
        </div>
    </AppLayout>
</template>
