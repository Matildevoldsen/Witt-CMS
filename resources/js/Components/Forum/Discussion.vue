<script setup>
defineProps({
    discussion: Object
})
</script>
<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-900 flex items-center space-x-6">
            <div class="flex-grow">
                <div class="flex items-center space-x-3">
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
    </div>
</template>
