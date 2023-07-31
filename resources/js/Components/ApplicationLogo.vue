<template>
    <img :src="'/' + $page?.props?.settings?.logo_path" :alt="`${$page?.props?.settings?.name} logo`" style="width: 150px;"/>
</template>
<script setup>
import {ref, onMounted} from 'vue';

let image = ref(null);

onMounted(async () => {
    try {
        image.src = `/${$page?.props?.settings?.logo_path}`;
    } catch (e) {
        console.log(e);
    }
})
</script>
