<script setup>
import StarterKit from '@tiptap/starter-kit'
import { BubbleMenu, Editor, EditorContent } from '@tiptap/vue-3'
import Blockquote from '@tiptap/extension-blockquote'
import Svg from "./Svg.vue";
import {BulletList} from "@tiptap/extension-bullet-list";
import ListItem from '@tiptap/extension-list-item'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import OrderedList from '@tiptap/extension-ordered-list'
import {watch} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    editorClasses: String
})

const editor = new Editor({
    extensions: [
        StarterKit,
        Blockquote,
        BulletList,
        Paragraph,
        ListItem,
        OrderedList,
        Text,
    ],
    content: props.modelValue
})
defineEmits(['update:modelValue']);
</script>
<template>
    <bubble-menu
        :editor="editor"
        :tippy-options="{ duration: 100 }"
        v-if="editor"
        id="bubble-menu"
        class="border-2 bg-white border-gray-200 rounded-md flex shadow-md z-50"
    >
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
            <Svg name="icon-bold" class="w-5 h-5"/>
        </button>
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
            <Svg name="icon-italic" class="w-5 h-5"/>
        </button>
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
            <Svg name="icon-strike" class="w-5 h-5"/>
        </button>
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }">
            <Svg name="icon-blockquote" class="w-10 h-5"/>
        </button>
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
            <Svg name="icon-bullet-list" class="w-10 h-5"/>
        </button>
        <button class="p-3 hover:bg-gray-50" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
            <Svg name="icon-numbered-list" class="w-10 h-5"/>
        </button>
    </bubble-menu>

    <EditorContent class="tiptapEditor"
                   :class="editorClasses"
                   @input="$emit('update:modelValue', $event.target.innerHTML)"
                   :editor="editor" />
</template>
