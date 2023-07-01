<template>
    <DashboardLayout>
        <InventoryTable :inventory="inventory">
            <template #header>
                <h1 class="text-base font-semibold leading-6 text-gray-900">Inventory</h1>
                <p class="mt-2 text-sm text-gray-700">Manage your {{ inventoryItems }} inventory items, import inventory or export all item's. {{ item }}</p>

                <div>
                    <input type="search"
                           v-model="searchQuery"
                           id="search"/>
                </div>
            </template>
            <template #action>
                <button type="button"
                        v-on:click="showImporter = !showImporter"
                        class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Import CSV
                </button>
            </template>
        </InventoryTable>
        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="transform opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="transform opacity-0"
        >
            <CSVImporter :open="showImporter" :importer="importer" @close="showImporter = false" v-if="showImporter"/>
        </transition>
    </DashboardLayout>
</template>
<script setup>
import CSVImporter from "../../../Components/CSVImporter.vue";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import InventoryTable from "../../../Components/Dashboard/Shop/InventoryTable.vue";
import {ref, watch} from "vue";
import _debounce from "lodash.debounce";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    inventory: {
        type: Array,
        required: true
    },
    inventoryItems: {
        type: Number,
        required: true
    },
    query: {
        required: false
    },
    importer: {
        required: false
    }
})

const searchQuery = ref(props.query.search || '')

const handleSearchInput = _debounce((value) => {
    router.reload({
        data: { search: value },
        preserveScroll: true
    })
}, 300)

watch(searchQuery, (value) => {
    handleSearchInput(value)
})

const showImporter = ref(false)

if (props.importer) {
    setInterval(() => {
        router.reload(['importer'])
    }, 2000);

    showImporter.value = true
}
</script>
