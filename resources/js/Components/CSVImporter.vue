<template>
    <Sidepanel @close="$emit('close')" :open="open">
        <template #header>
            <div class="flex items-center justify-between">
                <DialogTitle class="text-base font-semibold leading-6 text-white">
                    Import CSV
                </DialogTitle>
                <div class="ml-3 flex h-7 items-center">
                    <button type="button"
                            class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            @click="$emit('close')">
                        <span class="sr-only">Close panel</span>
                        <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                    </button>
                </div>
            </div>
            <div class="mt-1">
                <p class="text-sm text-indigo-300">Import CSV to the database.</p>
            </div>
        </template>

        <div v-if="importer?.completed_at" class="flex flex-col w-full items-center p-3">
            <h2 class="text-lg">All {{ importer.total_rows }} imported</h2>
            <CheckBadgeIcon class="w-16 text-green-500"/>
        </div>

        <form enctype="multipart/form-data" class="p-4 sm:p-6">
            <div>
                <!-- File drop -->
                <div v-if="!importer" class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                             viewBox="0 0 24 24"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file"
                                   class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a file</span>
                                <input @input="selectFile" id="file" name="file" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            CSV file up to 50MB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Column selection -->
            <div class="mt-8" v-if="!importer">
                <h2 class="font-medium">Match columns</h2>

                <div class="mt-4 space-y-5" v-for="header in headers" :key="header">
                    <div class="grid grid-cols-4 gap-4 items-start">
                        <label for="" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 col-span-1">
                            {{ header }}
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-3">
                            <select @input="addHeader(header)" type="text" :name="header" :id="header"
                                    class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                <option value="">Don't import</option>
                                <option :value="header">{{ header }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <ProgressBar v-if="importer" :processed_rows="importer.processed_rows" :total_rows="importer.total_rows"/>
            <!-- End columns selection -->
        </form>

        <template #action>
            <div v-if="importer" class="text-sm">
                Importing <strong>{{importer.formatted_processed_rows}}</strong> of <strong>{{importer.formatted_total_rows}}</strong>. This could take a while as the import is running in the background. You can refresh the page.
            </div>
            <PrimaryButton v-if="!importer" v-on:click="submit">Submit</PrimaryButton>
        </template>
    </Sidepanel>
</template>
<script setup>
import Sidepanel from "./Sidepanel.vue";
import PrimaryButton from "./PrimaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import {Dialog, DialogPanel, DialogTitle} from '@headlessui/vue'
import {CheckBadgeIcon} from "@heroicons/vue/24/outline/index.js";
import ProgressBar from "./Dashboard/ProgressBar.vue";
import {XMarkIcon} from "@heroicons/vue/24/outline";

defineEmits(["close"]);

const props = defineProps({
    csv: {
        type: Array,
        required: false
    },
    importer: {
        required: false
    },
    open: {
        type: Boolean,
        required: true
    }
})

const form = useForm({
})

const csv = ref(null)
const selectFile = (e) => {
    csv.value = e.target.files[0];

    uploadCSVFile()
}

const headers = ref([])
const filePath = ref('')
const totalRows = ref(0)

const uploadCSVFile = () => {
    const formData = new FormData();
    formData.append('csv', csv.value);
    axios.post(route('dashboard.shop.inventory.upload'), {
        csv: formData.get('csv')
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        headers.value = response.data.headers
        filePath.value = response.data.file_path
    }).catch((error) => {
        console.log(error)
    })
}

const selectedHeaders = []
const addHeader = (header) => {
    selectedHeaders.push(header)
}
const submit = () => {
    const formData = new FormData();
    formData.append('csv', csv.value);
    formData.append('headers', selectedHeaders);

    axios.post(route('dashboard.shop.inventory.import'), {
        headers: formData.get('headers'),
        csv: formData.get('csv')
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        totalRows.value = response.data.total_rows
        console.log(response.data.importer)
        router.visit(route('dashboard.shop.inventory.progress', response.data.importer), {
            preserveScroll: true
        })
    }).catch((error) => {
        console.log(error)
    })
}


</script>
