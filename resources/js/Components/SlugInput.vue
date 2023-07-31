<template>
    <input
        :value="computedValue"
        @input="updateInput"
        type="text"
    />
</template>

<script setup>
import {ref, computed, watch} from 'vue'
import slugify from 'slugify'

const props = defineProps({
    modelValue: String
})

const emit = defineEmits(['update:modelValue'])

const rawText = ref(props.modelValue)

watch(rawText, (newVal) => {
    emit('update:modelValue', newVal)
})

const updateInput = (event) => {
    rawText.value = slugify(event.target.value, {
        lower: true,
        strict: true,
        remove: /[*+~.()'"!:@]/g
    })
}

const computedValue = computed({
    get: () => rawText.value,
    set: (newValue) => {
        rawText.value = slugify(newValue, {
            lower: true,
            strict: true,
            remove: /[*+~.()'"!:@]/g
        })
    }
})
</script>
