<script setup>
import Textarea from "../../Textarea.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "../../InputLabel.vue";
import InputError from "../../InputError.vue";
import PrimaryButton from "../../PrimaryButton.vue";
import MarkdownShortcutToolbar from "./MarkdownShortcutToolbar.vue";
import {defineEmits} from "vue";
import useMentionSearch from "../../../Composeables/useMentionSearch.js";
import {Mentionable} from "vue-mention";

const props = defineProps({
    post: {
        type: Object
    }
})

const emits = defineEmits(['close'])

const editForm = useForm({
    body: props.post.body
})
const {mentionSearchResults, mentionSearch} = useMentionSearch()
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
            <Mentionable :keys="['@']" offset="6" v-on:search="mentionSearch" :items="mentionSearchResults">
                <Textarea v-model="editForm.body" id="content" class="w-full" rows="8"/>
            </Mentionable>
            <InputError :message="editForm.errors.body"/>
        </div>

        <div>
            <PrimaryButton>
                Edit Post
            </PrimaryButton>
        </div>
    </form>
</template>
