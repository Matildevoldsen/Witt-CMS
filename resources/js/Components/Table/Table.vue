<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <slot name="title"/>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <slot name="actions"/>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                        <tr>
                            <slot name="headers"/>
                        </tr>
                        </thead>
                        <tbody>
                            <slot name="rows"/>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
</script>
