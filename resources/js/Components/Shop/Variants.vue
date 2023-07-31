<template>
    <div class="variants">
        <Draggable v-model="variants" class="dragArea" handle=".handle" :group="{ pull: true, put: true }">
            <div v-for="(variant, index) in variants" :key="variant.id" class="variant handle">
                <div class="self-end">
                    <svg xmlns="http://www.w3.org/2000/svg"  @click="removeVariant(index)" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <fieldset>
                    <legend class="block text-sm font-medium leading-6 text-gray-900">Variant Details</legend>
                    <div class="mt-2 -space-y-px rounded-md bg-white shadow-sm">
                        <div>
                            <label for="title" class="sr-only">Title</label>
                            <input type="text" v-model="variant.title" name="title" id="title" class="relative block w-full rounded-none rounded-t-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Title, e.g., size 6" />
                        </div>
                        <div>
                            <label for="variant_price" class="sr-only">Price</label>
                            <PriceInput v-model="variant.price" id="variant_price" placeholder="Price, e.g., 30" class="relative block w-full rounded-none rounded-t-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                        </div>
                        <div class="flex -space-x-px">
                            <div class="w-1/2 min-w-0 flex-1">
                                <label for="sku" class="sr-only">SKU Code</label>
                                <input type="text" name="sku" v-model="variant.sku" id="sku" class="relative block w-full rounded-none rounded-bl-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="SKU Code" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <label for="type" class="sr-only">Type</label>
                                <input type="text" v-model="variant.type" name="type" id="type" class="relative block w-full rounded-none rounded-br-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Type, e.g., colour" />
                            </div>
                        </div>
                    </div>
                </fieldset>

                <Draggable v-model="variant.children" class="dragArea w-full mt-3 handle" handle=".handle"
                           :group="{ pull: true, put: true }">
                    <div v-for="(child, childIndex) in variant.children" :key="child.id" class="variant">
                        <div class="self-end">
                            <svg xmlns="http://www.w3.org/2000/svg"  @click="removeChildVariant(index, childIndex)" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <fieldset>
                            <legend class="block text-sm font-medium leading-6 text-gray-900">Child Variant Details</legend>
                            <div class="mt-2 -space-y-px rounded-md bg-white shadow-sm">
                                <div>
                                    <label for="title" class="sr-only">Title</label>
                                    <input type="text" v-model="child.title" name="title" id="title" class="relative block w-full rounded-none rounded-t-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Title, e.g., size 6" />
                                </div>
                                <div>
                                    <label for="child_price" class="sr-only">Price</label>
                                    <PriceInput v-model="child.price" id="child_price" class="relative block w-full rounded-none rounded-t-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                </div>
                                <div class="flex -space-x-px">
                                    <div class="w-1/2 min-w-0 flex-1">
                                        <label for="sku" class="sr-only">SKU Code</label>
                                        <input type="text" name="sku" v-model="child.sku" id="sku" class="relative block w-full rounded-none rounded-bl-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="SKU Code" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <label for="type" class="sr-only">Type</label>
                                        <input type="text" v-model="child.type" name="type" id="type" class="relative block w-full rounded-none rounded-br-md border-0 bg-transparent py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Type, e.g., colour" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </Draggable>
                <SecondaryButton type="button" class="mt-5" @click="addChildVariant(index)">Add Child Variant</SecondaryButton>
            </div>
        </Draggable>
        <PrimaryButton type="button" @click="addVariant">Add Variant</PrimaryButton>
    </div>
</template>
<script>
import { ref, watch } from 'vue';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';
import PrimaryButton from "../PrimaryButton.vue";
import SecondaryButton from "../SecondaryButton.vue";
import PriceInput from "./PriceInput.vue";

export default {
    components: {
        PriceInput,
        SecondaryButton,
        PrimaryButton,
        Draggable
    },
    props: {
        modelValue: {
            type: Array,
            default: () => []
        }
    },
    setup(props, { emit }) {
        const variants = ref([...props.modelValue]);

        // Watch for changes in the internal variant list and emit updates to the parent component
        watch(variants, (newVariants) => {
            emit('update:modelValue', newVariants);
        }, { deep: true });

        const addVariant = () => {
            variants.value.push({price: '', type: '', sku: '', title: '', children: []});
        };

        const removeVariant = (index) => {
            variants.value.splice(index, 1);
        };

        const addChildVariant = (index) => {
            variants.value[index].children.push({price: '', type: '', sku: '', title: ''});
        };

        const removeChildVariant = (index, childIndex) => {
            variants.value[index].children.splice(childIndex, 1);
        };

        return {variants, addVariant, removeVariant, addChildVariant, removeChildVariant};
    }
}
</script>

<style scoped>
.dragArea {
    @apply flex flex-col flex-grow;
}

.variant {
    @apply flex flex-grow flex-col items-start justify-between mb-4 border border-gray-300 p-4 rounded;
}

.child-variant {
    @apply flex items-center justify-between mb-4 w-3/12;
}

.handle {
    @apply cursor-move mr-4;
}
</style>
