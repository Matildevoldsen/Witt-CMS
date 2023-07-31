<script setup>
import DialogModal from "@/Components/DialogModal.vue";
import { useForm } from 'laravel-precognition-vue-inertia';
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "./ActionMessage.vue";

const props = defineProps({
    settings: Object
});

const photoPreview = ref(null);
const photoInput = ref(null);

const form = useForm('post', route('create-site'), {
    name: '',
    email: '',
    address: '',
    phone: '',
    logo_path: null,
    description: ''
});

const createSite = () => {
    form.logo_path = photoInput.value.files[0];

    console.log(form.logo_path)


    form.submit({
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = (e) => {
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
    <form v-on:submit.prevent="createSite" enctype="multipart/form-data">
        <DialogModal :show="!$page.props.settings">
            <template #title>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    Start Building Your Dream Website: Tell Us About Your Site
                </h3>
            </template>

            <template #content>
                <div class="mt-2">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Name"/>
                        <TextInput v-model="form.name"
                                   type="text"
                                   id="name"
                                   @change="form.validate('name')"
                                   class="mt-1 block w-full"
                                   placeholder="Name"/>
                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="email" value="Email"/>
                        <TextInput v-model="form.email"
                                   type="email"
                                   id="email"
                                   @change="form.validate('email')"
                                   class="mt-1 block w-full"
                                   placeholder="Email"/>
                        <InputError :message="form.errors.email" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="address" value="Address"/>
                        <TextInput
                            v-model="form.address"
                            type="text"
                            id="address"
                            @change="form.validate('address')"
                            class="mt-1 block w-full"
                            placeholder="Address"/>
                        <InputError :message="form.errors.address" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="phone" value="Phone"/>
                        <TextInput
                            v-model="form.phone"
                            type="tel"
                            id="phone"
                            @change="form.validate('phone')"
                            class="mt-1 block w-full"
                            placeholder="Phone"/>
                        <InputError :message="form.errors.phone" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="description" value="Description"/>
                        <TextInput
                            v-model="form.description"
                            type="text"
                            @change="form.validate('description')"
                            id="description"
                            class="mt-1 block w-full"
                            placeholder="Description"/>
                        <InputError :message="form.errors.description" class="mt-2"/>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description for your site. Recommended between 120 and 158 characters.
                            This description will appear on search engines' results, on the home page, and when no other
                            description is available.
                        </p>
                    </div>

                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input
                            ref="photoInput"
                            type="file"
                            class="hidden"
                            @change="(e) => {
                                updatePhotoPreview(e)

                                form.forgetError('logo_path')
                            }">

                        <InputLabel for="photo" value="Photo"/>

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

                        <InputError :message="form.errors?.logo_path" class="mt-2"/>
                    </div>
                </div>
            </template>

            <template #footer>
                <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                    Your site is now ready!
                </ActionMessage>

                <PrimaryButton v-on:click="createSite" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create Site
                </PrimaryButton>
            </template>
        </DialogModal>
    </form>
</template>
