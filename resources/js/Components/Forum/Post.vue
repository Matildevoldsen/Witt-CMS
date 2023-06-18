<script setup>
import useCreatePost from "../../Composeables/useCreatePost.js";
import { ref } from "vue";
import EditPostForm from "./Partials/EditPostForm.vue";
import {router} from "@inertiajs/vue3";

const { showCreatePostForm } = useCreatePost()
const props = defineProps({
    post: Object,
    isSolution: Boolean
})

const editing = ref(false)

const destroyPost = () => {
    if (window.confirm('Are you sure?')) {
        router.delete(route('posts.destroy', props.post), {
            preserveScroll: true
        })
    }
}
</script>
<template>
    <div
        :id="`post-${post?.id}`"
        :class="{ '!border-gray-800 dark:border-gray-100': isSolution, 'border-transparent': !isSolution }"
        class="relative border-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 text-gray-900 space-x-3 flex items-start">
        <div class="w-7 flex-shrink-0">
            <img v-if="post.user"
                 :src="post.user?.avatar_url"
                 class="w-7 h-7 rounded-full"
                 :alt="post.user?.name + ' profile photo'"/>
        </div>
        <div class="w-full">
            <div>
                <div class="dark:text-gray-100">
                    <template v-if="post.user">
                        {{ post.user?.name }}
                        <span class="ml-1 text-sm text-gray-600 dark:text-gray-300">
                            @{{ post.user?.username }}
                        </span>
                    </template>
                    <template v-else>
                        <span class="text-gray-600 dark:text-gray-300">[Deleted User]</span>
                    </template>
                </div>
                <div class="text-sm dark:text-gray-300 text-gray-600">
                    Posted
                    <time :datetime="post.created_at.dateTime"
                          :title="post.created_at.dateTime">
                        {{ post.created_at.human }}
                    </time>
                </div>

                <div class="editing">
                    <EditPostForm @close="editing = false" v-if="editing" :post="post"/>
                    <div v-else v-html="post.body_markdown" class="markdown"></div>
                </div>

                <ul class="flex items-center space-x-3 mt-6">
                    <li v-if="post?.discussion?.user_can.reply">
                        <button
                            v-on:click.prevent="showCreatePostForm(post.discussion)"
                            class="text-indigo-500 text-sm">
                            Reply
                        </button>
                    </li>

                    <li v-if="post?.user_can.edit">
                        <button
                            v-on:click.prevent="editing = !editing"
                            class="text-indigo-500 text-sm"
                            type="button">
                            {{ editing ? 'Cancel Edit' : 'Edit' }}
                        </button>
                    </li>

                    <li v-if="post?.user_can.destroy">
                        <button
                            v-on:click.prevent="destroyPost"
                            class="text-indigo-500 text-sm"
                            type="button">
                            Delete
                        </button>
                    </li>

                    <li v-if="post?.discussion.user_can.solve">
                        <button
                            v-on:click.prevent="router.patch(route('discussions.solutions.patch', post.discussion),
                            { post_id: isSolution ? null : post.id}, { preserveScroll: true
                            })"
                            class="text-indigo-500 text-sm"
                            type="button">
                            {{ isSolution ? 'Unmark as Solution' : 'Mark as Solution'}}
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div
            v-if="isSolution"
            class="absolute right-0 top-0 bg-gray-800 text-gray-100 dark:bg-gray-100 dark:text-gray-900 tracking-wide rounded-bl shadow-sm font-semibold px-3 py-1 text-xs uppercase">
            Best answer
        </div>
    </div>
</template>
