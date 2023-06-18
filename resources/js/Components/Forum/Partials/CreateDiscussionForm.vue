<script setup>
import FixedFormWrapper from "./FixedFormWrapper.vue";
import TextInput from "../../TextInput.vue";
import Select from "../../Select.vue";
import PrimaryButton from "../../PrimaryButton.vue";
import InputLabel from "../../InputLabel.vue";
import Textarea from "../../Textarea.vue";
import useCreateDiscussion from "../../../Composeables/useCreateDiscussion.js";
import InputError from "../../InputError.vue";
import Svg from "../../Svg.vue";
import {Mentionable} from "vue-mention";
import useMentionSearch from "../../../Composeables/useMentionSearch.js";

const { mentionSearchResults, mentionSearch } = useMentionSearch()
const {visible, hideCreateDiscussionForm, form} = useCreateDiscussion()

const createDiscussion = () => {
    form.post(route('discussions.store'), {
        onSuccess: () => {
            form.reset()
            hideCreateDiscussionForm()
        }
    })
}
</script>
<template>
    <FixedFormWrapper v-if="visible" v-on:submit.prevent="createDiscussion" :form="form">
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">New Discussion</h1>
                <button v-on:click="hideCreateDiscussionForm">
                    <Svg name="icon-close" class="w-5 h-5"/>
                </button>
            </div>
        </template>
        <template v-slot:main="{ markdownPreviewEnabled }">
            <div class="flex items-start space-x-3">
                <div class="flex-grow">
                    <div>
                        <InputLabel for="title" value="Title" class="sr-only"/>
                        <TextInput
                            v-model="form.title"
                            name="title"
                            id="title"
                            placeholder="Title"
                            type="text"
                            class="w-full"/>
                        <InputError :message="form.errors.title" class="mt-2"/>
                    </div>
                </div>

                <div>
                    <InputLabel for="topic" value="Topic" class="sr-only"/>
                    <select
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        id="topic"
                        v-model="form.topic_id">
                        <option selected disabled>Choose a topic</option>
                        <option
                            v-for="topic in $page.props.topics"
                            :value="topic.id"
                            :key="topic.id">
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-2"/>
                </div>
            </div>

            <div class="mt-4">
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
                Start Discussion
            </PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
