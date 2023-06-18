<script setup>
import { ref, watch } from 'vue';
import MarkdownShortcutToolbar from "./MarkdownShortcutToolbar.vue";

const markdownPreviewEnabled = ref(false);
const markdownPreviewHTML = ref('');
const markdownPreviewLoading = ref(false);

const props = defineProps({
    form: {
        required: true,
    },
});

watch(markdownPreviewEnabled, (toggled) => {
    if (!toggled) {
        return;
    }

    markdownPreviewLoading.value = true;

    axios.post(route('markdown.preview'), {
        body: props.form?.body
    }).then((response) => {
        markdownPreviewHTML.value = response?.data?.html;
        markdownPreviewLoading.value = false;
    });
});
</script>
<template>
    <form class="fixed shadow-sm bottom-0 w-full bg-white p-6 border-t-4 border-gray-200 space-y-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4">
                <slot name="header"/>
            </div>

            <div class="space-y-3">
                <slot name="main" :markdownPreviewEnabled="markdownPreviewEnabled"/>

                <div class="h-48 bg-gray-100 rounded-lg px-3 py-2 overflow-y-scroll border-gray-300 shadow-sm"
                     v-html="markdownPreviewHTML"
                     :class="{'opacity-50': markdownPreviewLoading}"
                     v-if="markdownPreviewEnabled">

                </div>

                <div class="flex items-center justify-between">
                    <MarkdownShortcutToolbar for="content"/>
                    <button class="text-sm text-indigo-500"
                            type="button"
                            v-on:click="markdownPreviewEnabled = !markdownPreviewEnabled">
                        {{ markdownPreviewEnabled ? 'Turn off' : 'Turn on' }} Markdown preview
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <slot name="button"/>
            </div>
        </div>
    </form>
</template>
