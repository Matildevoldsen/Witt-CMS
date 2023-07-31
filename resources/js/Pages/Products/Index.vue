<template>
    <AppLayout>
        <Product :product="product"/>
    </AppLayout>
</template>
<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import Product from "../../Components/Shop/Product.vue";


defineProps({
    product: {
        type: Object,
        required: true,
    },
})
</script>
