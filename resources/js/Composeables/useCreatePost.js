import { ref } from 'vue'
import { useForm } from "@inertiajs/vue3";

const postVisible = ref(false)
const discussionContext = ref(null)

const form = useForm({
    body: ''
})
export default () => {
    const showCreatePostForm = (discussion) => {
        postVisible.value = true
        discussionContext.value = discussion
    }
    const hideCreatePostForm = () => {
        postVisible.value = false
    }

    return {
        postVisible,
        showCreatePostForm,
        hideCreatePostForm,
        form,
        discussionContext
    }
}
