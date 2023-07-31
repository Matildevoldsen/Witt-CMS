<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    isLast: {
        type: Boolean,
        default: false
    }

});
</script>
<template>
    <td :class="{'sm:pr-8 lg:pr-8': isLast}"
        class="whitespace-nowrap hidden sm:pl-6 lg:pl-8 px-3 py-4 text-sm text-gray-500 sm:table-cell">
        <slot/>
    </td>
</template>
