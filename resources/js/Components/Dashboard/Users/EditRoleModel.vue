<script setup>
import DialogModal from "../../DialogModal.vue";
import PrimaryButton from "../../PrimaryButton.vue";
import {defineProps, reactive, watch} from 'vue';
import TextInput from "../../TextInput.vue";
import InputError from "../../InputError.vue";
import InputLabel from "../../InputLabel.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    role: Object,
    show: Boolean,
    permissions: Object
});

const hasPermission = (id) => {
    return props.role.permissions.some(permission => permission.id === id);
};

let form = useForm({
    name: props.role.name,
    permissions: props.permissions.reduce((acc, permission) => {
        acc[permission.id] = hasPermission(permission.id);
        return acc;
    }, {}),
});

const submitForm = () => {
    form.post(route('roles.permissions.assign', props.role), {
        preserveScroll: true,
        onSuccess: () => {
            props.show = false;
        }
    });
};
</script>
<template>
    <DialogModal :show="show">
        <template #title>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                Edit {{ role.name }} role's permissions
            </h3>
        </template>
        <template #content>
            <div class="mt-2">
                <fieldset class="border-b border-t border-gray-00">
                    <legend class="sr-only">Permissions for {{ role.name }}</legend>
                    <div v-for="permission in permissions" class="divide-y divide-gray-200">
                        <div class="relative flex items-start pb-4 pt-3.5">
                            <div class="min-w-0 flex-1 text-sm leading-6">
                                <label for="comments" class="font-medium text-gray-900">{{ permission.name }}</label>
                                <p id="comments-description" class="text-gray-500">
                                    {{ permission.description }}
                                </p>
                            </div>
                            <div class="ml-3 flex h-6 items-center">
                                <input :id="permission.name" :aria-describedby="permission.description" :name="permission.name"
                                       type="checkbox"
                                       v-model="form.permissions[permission.id]"
                                       :checked="hasPermission(permission.id)"
                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"/>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </template>
        <template #footer>
            <PrimaryButton v-on:click="submitForm">Save</PrimaryButton>
        </template>
    </DialogModal>
</template>
