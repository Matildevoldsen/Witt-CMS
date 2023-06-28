<script setup>
import {useForm} from "@inertiajs/vue3";
import {onMounted, ref, watch, watchEffect} from "vue";
import slugify from "slugify";
import ResizeTextarea from "../../Components/ResizeTextarea.vue";
import Editor from "../../Components/Editor.vue";
import _debounce from "lodash.debounce";
import dayjs from "dayjs";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import ArticleSettings from "../../Components/Blog/ArticleSettings.vue";
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    article: {
        type: Object,
        updated_at: String,
    }
})


const form = useForm({
    slug: slugify(props.article.slug, {strict: true}),
    title: props.article.title,
    body: props.article.body,
})

const replaceSlug = () => {
    const slug = form.slug

    if (slug.charAt(slug.length - 1) === ' ') {
        return
    }

    form.slug = slug ? slugify(slug, {strict: true}) : post.value.uuid
}

const savePost = _debounce(() => {
    form.patch(route('article.patch', props.article), {
        preserveScroll: true,
        preserveState: true,
    })
}, 1000)

watch(() => form.slug, replaceSlug)

onMounted(async () => {
    watchEffect(() => {
        replaceSlug()
    })

    watch(form, () => {
        console.log(form.body)
        savePost()
    })
})


const updatePost = async () => {
    await patchPost(props.uuid)
    lastSaved.value = dayjs()
}

const publish = async () => {
    savePost()
    axios.patch(route('article.publish', props.article)).then((response) => {

    });
}
</script>
<template>
    <div class="flex justify-between p-4">
        <div class="flex-grow flex items-center">
            <span class="mr-1">/</span>
            <input
                name="slug"
                v-model="form.slug"
                autofocus
                class="p-0 border-none focus:ring-0 w-full shadow-none"
                type="text"
                id="slug"/>
        </div>
        <div class="flex items-center space-x-3">
            <div v-if="article.updated_at.human">
                <time :datetime="article.updated_at.dateTime" :title="article.updated_at.dateTime"
                      class="text-gray-800">
                    Saved {{ article.updated_at.human }}
                </time>
            </div>
            <Link :href="route('article.show', article.slug)">
                Preview
            </Link>
            <PrimaryButton
                v-on:click="publish"
                :class="{
                    'bg-indigo-500 focus:bg-indigo-600 hover:bg-indigo-600': !article.is_published,
                    'bg-gray-300 focus:bg-gray-400 hover:bg-gray-400': article.is_published,
                }"
                type="button">
                {{ article.is_published ? 'Retract' : 'Publish' }}
            </PrimaryButton>
            <div>
                <ArticleSettings/>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center">
        <div>
            <ResizeTextarea v-if="form.title">
                <template v-slot:default="{ resize, el }">
                    <textarea :ref="el" v-model="form.title" v-on:input="resize"
                              class="w-full text-center text-4xl lg:text-6xl leading-10 font-extrabold tracking-tight text-gray-900 border-none focus:ring-0 resize-none p-0"
                              rows="1"></textarea>
                </template>
            </ResizeTextarea>
        </div>

        <div class="mx-auto w-1/2">
            <Editor v-model="form.body" class="mt-16"/>
        </div>
    </div>
</template>
