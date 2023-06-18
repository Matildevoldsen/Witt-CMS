<script setup>
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Post from "@/Components/Forum/Post.vue";
import Navigation from "@/Components/Forum/Navigation.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import useCreatePost from "../../Composeables/useCreatePost.js";
import {onMounted, onUpdated, nextTick} from "vue";
import  VueScrollTo from 'vue-scrollto'

const props = defineProps({
    discussion: Object,
    posts: Object,
    query: Object,
    postId: Number
})

const { showCreatePostForm } = useCreatePost()

const scrollToPost = (postId) => {
    if (!postId) {
        return;
    }

    nextTick(() => {
        VueScrollTo.scrollTo(`#post-${postId}`, 500, {offset: -50})
    })
}

onMounted(() => {
    scrollToPost(props.postId)
})

onUpdated(() => {
    scrollToPost(props.postId)
})
</script>

<template>
    <ForumLayout :title="discussion.title">
        <template #side>
            <PrimaryButton v-if="discussion.user_can.reply" v-on:click="showCreatePostForm(discussion)" class="w-full flex justify-center h-10">
                Reply to discussion
            </PrimaryButton>

            <Navigation :query="query"/>
        </template>

        <div class="space-y-3">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <template v-if="discussion?.is_pinned">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pinned"
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 4v6l-2 4v2h10v-2l-2 -4v-6"/>
                                <path d="M12 16l0 5"/>
                                <path d="M8 4l8 0"/>
                            </svg>
                        </template>
                        <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600">
                        {{ discussion?.topic?.name }}
                    </span>
                        <h1 class="text-lg font-medium dark:text-white">
                            {{ discussion?.title }}
                        </h1>
                    </div>
                    <div class="text-sm">
                        {{ discussion?.replies_count }}
                    </div>
                </div>
            </div>

            <Post v-for="post in posts?.data" :key="post?.id" :post="post" :isSolution="discussion?.solution?.id === post.id"/>
            <Pagination class="!mt-6" :pagination="posts?.meta"/>
        </div>

    </ForumLayout>
</template>
