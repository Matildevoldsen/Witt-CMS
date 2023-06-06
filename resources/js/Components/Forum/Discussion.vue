<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    discussion: Object
})
</script>
<template>
    <Link :href="route('discussions.show', discussion)" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-900 flex items-center space-x-6">
            <div class="flex-grow">
                <div class="flex items-center space-x-3">
                    <template v-if="discussion.is_pinned">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pinned" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 4v6l-2 4v2h10v-2l-2 -4v-6"/>
                            <path d="M12 16l0 5"/>
                            <path d="M8 4l8 0"/>
                        </svg>
                    </template>
                    <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600">
                        {{ discussion.topic.name }}
                    </span>
                    <h1 class="text-lg font-medium">
                        {{ discussion.title }}
                    </h1>
                </div>
            </div>
            <div>
                avatars
            </div>
        </div>
    </Link>
</template>
