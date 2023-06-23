<script setup>
import FixedFormWrapper from "./FixedFormWrapper.vue";
import PrimaryButton from "../../PrimaryButton.vue";
import InputLabel from "../../InputLabel.vue";
import Textarea from "../../Textarea.vue";
import useCreateDiscussion from "../../../Composeables/useCreatePost.js";
import InputError from "../../InputError.vue";
import Svg from "../../Svg.vue";
import useCreatePost from "../../../Composeables/useCreatePost.js";
import {Mentionable} from "vue-mention";
import useMentionSearch from "../../../Composeables/useMentionSearch.js";

const {postVisible, hideCreatePostForm, discussionContext, form} = useCreatePost()
const { mentionSearchResults, mentionSearch } = useMentionSearch()

const createPost = () => {
    form.post(route('posts.store', discussionContext.value), {
        onSuccess: () => {
            form.reset()
            hideCreatePostForm()
        }
    })
}
</script>
<template>
    <FixedFormWrapper v-if="postVisible" v-on:submit.prevent="createPost" :form="form">
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">
                    Replying to {{ discussionContext?.title }}
                </h1>
                <button v-on:click="hideCreatePostForm">
                    <Svg name="icon-close" class="w-5 h-5"/>
                </button>
            </div>
        </template>
        <template v-slot:main="{ markdownPreviewEnabled }">
            <div>
                <InputLabel for="content" value="Content" class="sr-only"/>
                <Mentionable :keys="['@']" offset="6" v-on:search="mentionSearch" :items="mentionSearchResults">
                    <Textarea
                        v-if="!markdownPreviewEnabled"
                        v-model="form.body"
                        rows="6"
                        class="w-full h-48 align-top"
                        id="content"/>
                </Mentionable>
                <InputError :message="form.errors.body" class="mt-2"/>
            </div>
        </template>
        <template v-slot:button>
            <PrimaryButton>
                Reply
            </PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
