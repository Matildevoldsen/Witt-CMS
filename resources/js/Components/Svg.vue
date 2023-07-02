<template>
    <img v-if="image" :src="image"/>
</template>
<script setup>
import {ref, onMounted} from 'vue';

let image = ref(null);

onMounted(async () => {
    try {
        image.src = `/${$page.props.settings.logo_path}`;
    } catch (e) {
        console.log(e);
    }
})
</script>
