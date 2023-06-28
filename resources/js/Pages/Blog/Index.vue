<script setup>

import AppLayout from "../../Layouts/AppLayout.vue";

defineProps({
    article: {
        type: Object,
    }
})
</script>
<template>
    <AppLayout>
        <div class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white">
            <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
                <article
                    class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                    <header class="mb-4 lg:mb-6 not-format">
                        <address class="flex items-center mb-6 not-italic">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                <img class="mr-4 w-16 h-16 rounded-full"
                                     :src="article?.user?.avatar_url"
                                     :alt="article?.user?.name">
                                <div>
                                    <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">{{ article?.user?.name }}</a>
                                    <p class="text-base font-light text-gray-500 dark:text-gray-400">
                                        <time pubdate :datetime="article.created_at.dateTime" :title="article.created_at.dateTime">
                                            {{ article.created_at.human }}
                                        </time>
                                    </p>
                                </div>
                            </div>
                        </address>
                        <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                            {{ article.title }}
                        </h1>
                    </header>

                    <div v-html="article.body"></div>
                </article>
            </div>
        </div>
    </AppLayout>
</template>
