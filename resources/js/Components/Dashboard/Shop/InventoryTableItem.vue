<template>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
        <template v-if="editing">
            <TextInput type="text" v-model="form.name" placeholder="Name"/>
        </template>
        <template v-else>
            {{ item.name }}
        </template>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <template v-if="editing">
            <TextInput type="text" v-model="form.title" placeholder="Title"/>
        </template>
        <template v-else>
            {{ item.title }}
        </template>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <template v-if="editing">
            <TextInput type="number" class="w-20" v-model="form.price" placeholder="Price"/>
        </template>
        <template v-else>
            {{ item.price }}
        </template>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <template v-if="editing">
            <TextInput type="number" class="w-20" v-model="form.quantity" placeholder="Quantity"/>
        </template>
        <template v-else>
            {{ item.quantity }}
        </template>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <template v-if="editing">
            <TextInput type="text" v-model="form.sku" placeholder="SKU"/>
        </template>
        <template v-else>
            {{ item.sku }}
        </template>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <template v-if="editing">
            <TextInput type="number" class="w-20" v-model="form.delivery_fee" placeholder="Delivery Fee"/>
        </template>
        <template v-else>
            {{ item.delivery_fee }}
        </template>
    </td>
    <!--                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ item.description }}</td>-->
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        <a v-if="!editing" v-on:click="editing = true" href="#" class="text-indigo-600 hover:text-indigo-900">
            Edit<span class="sr-only">, {{ item.name }}</span>
        </a>
        <div class="space-x-2">
            <a v-if="editing" v-on:click="editing = false" href="#" class="text-indigo-600 hover:text-indigo-900">
                Cancel<span class="sr-only">, {{ item.name }}</span>
            </a>
            <a v-if="editing" v-on:click="save" href="#" class="text-indigo-600 hover:text-indigo-900">
                Save<span class="sr-only">, {{ item.name }}</span>
            </a>
        </div>
    </td>
</template>
<script setup>
import {defineProps, defineEmits, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "../../TextInput.vue";

const props = defineProps({
    item: Object
})

const editing = ref(false)

const form = useForm({
    name: props.item.name,
    title: props.item.title,
    price: props.item.price,
    quantity: props.item.quantity,
    sku: props.item.sku,
    delivery_fee: props.item.delivery_fee,
    // description: ''
})

const save = () => {
    form.post(route('dashboard.shop.inventory.update', props.item.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            editing.value = false
        }
    })
}
</script>
