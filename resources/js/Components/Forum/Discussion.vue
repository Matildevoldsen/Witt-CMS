<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    discussion: Object
})

const participants = computed(() => props.discussion.participants.slice(0, 3))
</script>
<template>
    <Link :href="route('discussions.show', discussion)"
          class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="text-gray-900 flex items-center space-x-6">
            <div class="flex-grow">
                <div class="flex items-center space-x-3">
                    <template v-if="discussion.is_pinned">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pinned" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 4v6l-2 4v2h10v-2l-2 -4v-6"/>
                            <path d="M12 16l0 5"/>
                            <path d="M8 4l8 0"/>
                        </svg>
                    </template>
                    <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600">
                        {{ discussion.topic?.name }}
                    </span>
                    <h1 class="text-lg font-medium">
                        {{ discussion.title }}
                    </h1>
                </div>
            </div>
            <div class="flex-shrink-0 flex-col flex items-end">
                <div class="flex justify-start -space-x-1 overflow-hidden">
                    <div class="flex items-center space-x-3">
                        <img
                            class="inline-block h-6 w-6 rounded-full ring-2 ring-white first-of-type:w-7 first-of-type:h-7"
                            v-for="participant in participants"
                            :src="participant?.avatar_url" :key="participant.id"
                            :title="participant?.username"
                            :alt="'Profile photo of ' + participant?.name"/>
                        <span class="!ml-1 text-gray-500 text-sm"
                              v-if="discussion.participants.length > 3">+ {{ discussion.participants.length - 3 }} more</span>
                    </div>
                </div>
                <div class="text-sm mt-3">
                    {{ discussion.replies_count }}
                </div>
            </div>
        </div>

        <div class="text-gray-500 text-sm mt-3 line-clamp-1"
             v-if="discussion.post && discussion.post.body_preview">
            {{ discussion.post.body_preview }}
        </div>

        <Link :href="`${route('discussions.show', discussion)}?post=${discussion?.latest_post?.id}`"
              class="text-sm mt-3 inline-block">
            Last post by {{ discussion?.latest_post?.user?.username || '[Deleted user]' }} at
            <time :datetime="discussion?.latest_post?.created_at?.dateTime" :title="discussion?.latest_post?.dateTime">
                {{ discussion?.latest_post?.created_at.human }}
            </time>
        </Link>
    </Link>
</template>
