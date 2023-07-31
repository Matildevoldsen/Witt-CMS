<template>
    <input type="text"
               :value="displayPrice"
               @input="updatePrice"
               @blur="formatPrice"
               placeholder="E.g., 10"/>
</template>

<script setup>
import {ref, computed, watch, defineEmits} from 'vue';
import TextInput from "../TextInput.vue";
import InputLabel from "../InputLabel.vue";

let rawPrice = ref('');
let displayPrice = ref('');

const emit = defineEmits(['update:modelValue']);

watch(rawPrice, (value) => {
    emit('update:modelValue', value);
});
const updatePrice = (event) => {
    rawPrice.value = event.target.value.replace(/[^\d\.]/g, '');
    displayPrice.value = rawPrice.value;
}

const formatPrice = () => {
    displayPrice.value = rawPrice.value ? parseFloat(rawPrice.value).toFixed(2) : '';
}

</script>
