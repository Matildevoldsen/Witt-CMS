<script setup>
import Svg from "../../Svg.vue";
</script>
<template>
    <markdown-toolbar class="flex items-center">
        <md-bold class="cursor-pointer py-1.5 px-1">
            <Svg name="icon-bold" class="w-5 h-5"/>
        </md-bold>
        <md-italic class="cursor-pointer py-1.5 px-1">
            <Svg name="icon-italic" class="w-5 h-5"/>
        </md-italic>
        <md-code class="cursor-pointer py-1.5 px-1">
            <Svg name="icon-code" class="w-5 h-5"/>
        </md-code>
        <md-link class="cursor-pointer py-1.5 px-1">
            <Svg name="icon-link" class="w-5 h-5"/>
        </md-link>
        <md-mention class="cursor-pointer py-1.5 px-1">
            <Svg name="icon-at" class="w-5 h-5"/>
        </md-mention>
    </markdown-toolbar>
</template>
