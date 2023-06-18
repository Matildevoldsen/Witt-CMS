<script setup>
import Textarea from "../../Textarea.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "../../InputLabel.vue";
import InputError from "../../InputError.vue";
import PrimaryButton from "../../PrimaryButton.vue";
import MarkdownShortcutToolbar from "./MarkdownShortcutToolbar.vue";
import { defineEmits } from "vue";

const props = defineProps({
    post: {
        type: Object
    }
})

const emits = defineEmits(['close'])

const editForm = useForm({
    body: props.post.body
})
const editPost = () => {
    editForm.patch(route('posts.patch', props.post), {
        preserveScroll: true,
        onSuccess: () => {
            editForm.reset()
            emits('close')
        }
    })
}
</script>
<template>
    <form v-on:submit.prevent="editPost">
        <div>
            <InputLabel for="body" value="Content" class="sr-only"/>
            <MarkdownShortcutToolbar for="body"/>
            <Textarea v-model="editForm.body" id="body" class="w-full" rows="8"/>
            <InputError :message="editForm.errors.body"/>
        </div>

        <div>
            <PrimaryButton>
                Edit Post
            </PrimaryButton>
        </div>
    </form>
</template>
