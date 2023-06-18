<script setup>
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Select from "../../Components/Select.vue";
import InputLabel from "../../Components/InputLabel.vue";
import Discussion from "../../Components/Forum/Discussion.vue";
import Pagination from "../../Components/Pagination.vue";
import Navigation from "@/Components/Forum/Navigation.vue";
import {router} from "@inertiajs/vue3";
import _omitBy from "lodash.omitBy";
import _isEmpty from "lodash.isEmpty";
import useCreateDiscussion from "../../Composeables/useCreateDiscussion.js";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import TextInput from "../../Components/TextInput.vue";
import {ref, watch} from "vue";
import _debounce from 'lodash.debounce';

const props = defineProps({
    discussions: Object,
    query: Object
})

const filterTopic = (e) => {
    router.visit(route('forum'), {
        data: _omitBy({
            'filter[topic]': e.target.value
        }, _isEmpty),
        preserveScroll: true,
        preserveState: true
    })
}

const {visible, showCreateDiscussionForm} = useCreateDiscussion()

const searchQuery = ref(props.query.search || '')

const handleSearchInput = _debounce((value) => {
    router.reload({
        data: { search: value },
        preserveScroll: true
    })
}, 300)

watch(searchQuery, (value) => {
    handleSearchInput(value)
})
</script>

<template>
    <ForumLayout title="Forum">
        <template #side>
            <PrimaryButton v-if="$page.props.auth.user" v-on:click="showCreateDiscussionForm"
                           class="w-full flex justify-center h-10">
                Start a Discussion
            </PrimaryButton>

            <Navigation :query="query"/>
        </template>

        <div class="space-y-6">
            <div class="bg-white flex space-x-3 justify-between dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 flex-grow items-center flex">
                    <div class="flex-grow">
                        <InputLabel for="search" class="sr-only" value="Search"/>
                        <TextInput
                            id="search"
                            type="search"
                            name="search"
                            class="w-full"
                            placeholder="Search discussions..."
                            v-model="searchQuery"
                        />
                    </div>
                </div>
                <div class="p-6 text-gray-900" v-if="$page.props.topics">
                    <div>
                        <InputLabel for="topic" class="sr-only" value="Topic"/>
                        <Select
                            id="topic"
                            v-on:change="filterTopic">
                            <option value="">All Topics</option>
                            <option
                                v-for="topic in $page.props.topics"
                                :value="topic.slug"
                                :selected="query.filter?.topic === topic.slug"
                                :key="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <Discussion v-for="discussion in discussions.data" :key="discussion.id" :discussion="discussion"/>
                <Pagination class="!mt-6" :pagination="discussions.meta"/>
            </div>
        </div>
    </ForumLayout>
</template>
