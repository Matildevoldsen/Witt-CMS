<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    query: Object
})
</script>
<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <nav class="space-y-3">
                <ul class="space-y-2">
                    <li>
                        <Link :class="{ 'font-bold': !query?.filter && route().current('forum') }"
                              :href="route('forum')">
                            All Discussions
                        </Link>
                    </li>
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.noreplies }"
                              :href="route('forum') + '?filter[noreplies]=1'">
                            No Replies
                        </Link>
                    </li>
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.solved }"
                              :href="route('forum') + '?filter[solved]=1'">
                            Solved
                        </Link>
                    </li>
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.unresolved }"
                              :href="route('forum') + '?filter[unresolved]=1'">
                            Unresolved
                        </Link>
                    </li>
                </ul>

                <ul class="space-y-2 border-t border-t-gray-500 pt-3" v-if="$page.props.auth.user">
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.mine }"
                              :href="route('forum') + '?filter[mine]=1'">
                            My Discussions
                        </Link>
                    </li>
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.participating }"
                              :href="route('forum') + '?filter[participating]=1'">
                            Participating
                        </Link>
                    </li>
                    <li>
                        <Link :class="{ 'font-bold': query?.filter?.mentioned }"
                              :href="route('forum') + '?filter[mentioned]=1'">
                            Mentioned
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
