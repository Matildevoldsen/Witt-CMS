import { ref } from 'vue'
import axios from 'axios'

export default function useAdminPosts() {
    const destroyPost = async (uuid) => {
        await axios.delete(`/api/admin/posts/${uuid}`)
    }

    const patchPost = async (form) => {
        //
    }

    return {
        patchPost,
        destroyPost
    }
}
