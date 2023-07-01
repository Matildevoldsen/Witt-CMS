<template>
    <div>
        <div class="p-6">
            <div>
                <h2 class="font-medium">Importing CSV file</h2>
                <span class="text-gray-700 text-sm">Imported {{ processed_rows }}/{{ total_rows }} rows</span>
                <div class="w-full bg-indigo-100 rounded">
                    <div class="mt-2 w-full bg-indigo-500 rounded h-2" :style="`width: ${ (processed_rows / total_rows) * 100 }%`"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    total_rows: {
        type: Number,
        required: true
    },
    processed_rows: {
        type: Number,
        required: true
    }
})
</script>
