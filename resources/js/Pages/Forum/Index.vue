<script setup>
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Select from "../../Components/Select.vue";
import InputLabel from "../../Components/InputLabel.vue";
import Discussion from "../../Components/Forum/Discussion.vue";

defineProps({
    discussions: Object,
})
</script>

<template>
    <ForumLayout title="Forum">
        <template #side>
            {{ }}
        </template>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900" v-if="$page.props.topics">
                    <div>
                        <InputLabel for="topic" class="sr-only" value="Topic"/>
                        <Select id="topic">
                            <option value="">All Topics</option>
                            <option v-for="topic in $page.props.topics" :value="topic.slug" :key="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <Discussion v-for="discussion in discussions.data" :key="discussion.id" :discussion="discussion"/>
            </div>
        </div>
    </ForumLayout>
</template>
