<script setup>
defineProps({
    post: Object
})
</script>
<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 text-gray-900 space-x-3 flex items-start">
        <div class="w-7 flex-shrink-0">
            <img :src="post.user.avatar_url" class="w-7 h-7 rounded-full" :alt="post.user.name + ' profile photo'"/>
        </div>
        <div class="w-full">
            <div>
                <div class="dark:text-gray-100">
                    {{ post.user.name }} <span class="ml-1 text-sm text-gray-600 dark:text-gray-300">@{{ post.user.username }}</span>
                </div>
                <div class="text-sm dark:text-gray-300 text-gray-600">
                    Posted <time :datetime="post.created_at.dateTime" :title="post.created_at.dateTime">{{ post.created_at.human }}</time>
                </div>
            </div>
        </div>
    </div>
</template>
