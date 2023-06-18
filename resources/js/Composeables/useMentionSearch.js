import {ref} from "vue";
import { MeiliSearch } from "meilisearch";

const client = new MeiliSearch({
    host: import.meta.env.VITE_MEILISEARCH_HOST,
    apiKey: import.meta.env.VITE_MEILISEARCH_API_KEY
})
const mentionSearchResults = ref([])

export default () => {
    const index = client.index('users')

    const mentionSearch = async (query) => {
        mentionSearchResults.value = (await index.search(query, { limit: 20})).hits
    }

    return {
        mentionSearch,
        mentionSearchResults
    }
}
