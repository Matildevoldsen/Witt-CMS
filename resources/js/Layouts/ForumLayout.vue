<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateDiscussionForm from "@/Components/Forum/Partials/CreateDiscussionForm.vue";
import useCreateDiscussion from "../Composeables/useCreateDiscussion.js";
import CreatePostForm from "../Components/Forum/Partials/CreatePostForm.vue";
import useCreatePost from "../Composeables/useCreatePost.js";

const { visible } = useCreateDiscussion()
const { postVisible } = useCreatePost()
</script>
<template>
    <AppLayout>
        <div class="py-12 mx-auto gap-6 sm:px-6 px-8 md:space-y-0 space-y-6 sm:px-6 lg:px-8 max-w-7xl md:grid grid-cols-7">
            <div class="col-span-2 space-y-3">
                <slot name="side"/>
            </div>
            <div class="col-span-5">
                <slot/>
            </div>
        </div>
    </AppLayout>

    <CreateDiscussionForm v-if="visible"/>
    <CreatePostForm v-if="postVisible"/>
</template>
