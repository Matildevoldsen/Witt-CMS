<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <slot name="header"/>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <slot name="action"/>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <InventoryHeaders/>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="item in inventory.data" :key="inventory.id">
                                <InventoryTableItem :item="item"/>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Pagination :pagination="inventory.meta"/>
    </div>
</template>

<script setup>
import Pagination from "../../Pagination.vue";
import InventoryTableItem from "./InventoryTableItem.vue";
import InventoryHeaders from "./InventoryHeaders.vue";

defineProps({
    inventory: {
        type: Array,
        required: true
    }
})
</script>
