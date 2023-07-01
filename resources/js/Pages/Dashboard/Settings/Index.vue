<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import TextInput from "../../../Components/TextInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import InputLabel from "../../../Components/InputLabel.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import InputError from "../../../Components/InputError.vue";
import FormSection from "../../../Components/FormSection.vue";
import ActionMessage from "../../../Components/ActionMessage.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";

const props = defineProps({
    settings: Object
});

const photoPreview = ref(null);
const photoInput = ref(null);

const form = useForm({
    _method: 'PUT',
    name: props.settings.name,
    email: props.settings.email,
    address: props.settings.address,
    phone: props.settings.phone,
    logo_path: null,
    description: props.settings.description
});

const updateSiteSettings = () => {
    if (photoInput.value) {
        form.logo_path = photoInput.value.files[0];
    }

    console.log(form.logo_path);

    form.post(route("dashboard.settings.update"), {
        preserveScroll: true,
        onSuccess: () => {
            console.log("success");
        },
        onError: () => {
            console.log("error");
        }
    });
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>
<template>
    <DashboardLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 rounded-md mt-2">
            <FormSection @submitted="updateSiteSettings">
                <template #title>
                    Site Settings
                </template>

                <template #description>
                    Update your site's settings. E.g., name, logo, description, e.t.c.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Name" />
                        <TextInput v-model="form.name"
                                   type="text"
                                   id="name"
                                   class="mt-1 block w-full"
                                   placeholder="Name"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput v-model="form.email"
                                   type="email"
                                   id="email"
                                   class="mt-1 block w-full"
                                   placeholder="Email"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="address" value="Address" />
                        <TextInput
                            v-model="form.address"
                            type="text"
                            id="address"
                            class="mt-1 block w-full"
                            placeholder="Address"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="phone" value="Phone" />
                        <TextInput
                            v-model="form.phone"
                            type="tel"
                            id="phone"
                            class="mt-1 block w-full"
                            placeholder="Phone"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="description" value="Description" />
                        <TextInput
                            v-model="form.description"
                            type="text"
                            id="description"
                            class="mt-1 block w-full"
                            placeholder="Description"/>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description for your site. Recommended between 120 and 158 characters.
                            This description will appear on search engines' results, on the home page, and when no other description is available.
                        </p>
                    </div>

                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input
                            ref="photoInput"
                            type="file"
                            class="hidden"
                            @change="updatePhotoPreview"
                        >

                        <InputLabel for="photo" value="Photo"/>

                        <!-- Current Profile Photo -->
                        <div v-show="! photoPreview" class="mt-2">
                            <img :src="'/' + $page.props.settings.logo_path" class="rounded-full h-20 w-20 object-cover">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                        </div>

                        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                            Select A New Photo
                        </SecondaryButton>

                        <InputError :message="form.errors.logo_path" class="mt-2"/>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </DashboardLayout>
</template>
