<template>
    <DashboardLayout :title="form.recentlySuccessful ? 'Saving... ' : 'Home'">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 rounded-md mt-2">
            <FormSection @submitted="saveProduct">
                <template #title>
                    Create New Product
                </template>

                <template #description>
                    Create a new product for your shop. Specify variations, price, title and other details.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        {{ form }}
                        <InputLabel for="title" value="Title"/>
                        <TextInput type="text"
                                   id="title"
                                   v-model="form.title"
                                   class="mt-1 block w-full"
                                   placeholder="Product Title, e.g., Spiderman 3"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="slug" value="Slug"/>
                        <SlugInput v-model="form.slug" placeholder="E.g., spiderman-3" id="slug" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"/>
                        <p class="mt-2 text-sm text-gray-500">
                            E.g., <span class="font-mono">{{ $page.props.appURL }}/products/<span class="text-indigo-500">spiderman-3</span></span>. This will be used to generate the URL for this product after /products/.
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="dp-input-live_at" value="Live at"/>
                        <VueDatePicker v-model="form.live_at" uid="live_at"></VueDatePicker>
                        <p class="mt-2 text-sm text-gray-500">
                            The date and time this product will be available for purchase.
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="price" value="Price"/>
                        <PriceInput v-model="form.price" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="price"/>
                        <p class="mt-2 text-sm text-gray-500">
                            The price of the product in your selected currency.
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="description" value="Description"/>
                        <Editor v-model="form.description"
                            editorClasses="h-[300px] !border-2 !border-gray-200 !dark:border-gray-800 dark:bg-gray-900 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"/>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description for your product. Please select the text to modify it's format.
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover
                            photo</label>
                        <div
                            v-on:dragenter="toggleDropActive"
                            v-on:dragleave="toggleDropActive"
                            v-on:dragover.prevent
                            v-on:drop.prevent="uploadImage"
                            :class="{'border-indigo-500 border-2': toggleDrop}"
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true"/>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="file-upload"
                                           class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only"/>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>

                        <div class="mt-4 space-x-2 flex">
                            <div v-for="fileUrl in files" :key="fileUrl">
                                <img :src="fileUrl" alt="Uploaded File Preview" class="w-24 h-24 object-cover rounded-md shadow-md">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4 flex justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Variations</h2>
                            <p class="mt-1 text-sm text-gray-500">Add variations to your product.</p>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <div class="mt-5">
                            <Variants v-model="variants"/>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create Product
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from "../../../../Layouts/DashboardLayout.vue";
import InputError from "../../../../Components/InputError.vue";
import TextInput from "../../../../Components/TextInput.vue";
import ActionMessage from "../../../../Components/ActionMessage.vue";
import PrimaryButton from "../../../../Components/PrimaryButton.vue";
import InputLabel from "../../../../Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import Editor from "../../../../Components/Editor.vue";
import PriceInput from "../../../../Components/Shop/PriceInput.vue";
import {defineAsyncComponent, ref, watch} from "vue";
import {PhotoIcon} from "@heroicons/vue/20/solid/index.js";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import 'moment'
import SecondaryButton from "../../../../Components/SecondaryButton.vue";
import Variants from "../../../../Components/Shop/Variants.vue";
import slugify from "slugify";
import SlugInput from "../../../../Components/SlugInput.vue";

const FormSection = defineAsyncComponent(() => import('../../../../Components/FormSection.vue'),);

const toggleDrop = ref(false);

const props = defineProps({
    product: Object,
});

const variants = ref([]);

const form = useForm({
    title: '',
    slug: '',
    price: '',
    description: '',
    live_at: '',
});

const saveProduct = () => {
    addVariants()

    form.put(route('dashboard.shop.products.save', props.product), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
}

const addVariants = () => {
    axios.post(route('dashboard.shop.products.variants.store'), {
        variants: JSON.parse(JSON.stringify(variants.value)),
        product_id: props.product.id
    }).then(response => {
        console.log(response);
    }).catch(error => {
        console.log(error);
    });

    variants.value = [];
}

const files = ref([]);

const uploadImage = async (e) => {
    toggleDrop.value = false;

    const filesToUpload = e.dataTransfer ? e.dataTransfer.files : e.target.files;

    let formData = new FormData();

    for(let i = 0; i < filesToUpload.length; i++) {
        let file = filesToUpload[i];
        formData.append('file['+ i +']', file);
    }

    try {
        let response = await axios.post(route('dashboard.shop.products.image.store', props.product), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        // assuming the server returns an array of file paths
        files.value = [...files.value, ...response.data.file_paths];

    } catch (error) {
        console.log(error);
    }
}


const toggleDropActive = () => {
    toggleDrop.value = !toggleDrop.value;
    console.log(toggleDrop.value);
}
</script>
<style type="scss">
.tiptapEditor {
    @apply p-6;
}

.tiptapEditor div {
    max-height: 300px;
}
</style>
