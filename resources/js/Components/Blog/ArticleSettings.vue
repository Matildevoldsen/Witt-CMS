<template>
    <Menu as="div" class="z-50 relative inline-block text-left">
        <div>
            <MenuButton
                class="inline-flex w-full justify-center rounded-md bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
                <Cog8ToothIcon
                    class="ml-2 -mr-1 h-5 w-5 text-violet-800 hover:text-violet-900"/>
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <button
                            :class="[
                                  active ? 'bg-violet-500 text-white' : 'text-gray-900',
                                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                ]"
                        >
                            Edit metadata and header
                        </button>
                    </MenuItem>
                </div>
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <button
                            :class="[
                  active ? 'bg-violet-500 text-white' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                ]"
                        >
                            Schedule
                        </button>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <button
                            :class="[
                  active ? 'bg-violet-500 text-white' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                ]"
                        >
                            Archive
                        </button>
                    </MenuItem>
                </div>

                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <button
                            :class="[
                  active ? 'bg-red-900 text-white' : 'text-gray-900',
                  'group flex w-full items-center bg-red-600 text-white rounded-md px-2 py-2 text-sm',
                ]"
                        >
                            Delete
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue'
import {Cog8ToothIcon} from "@heroicons/vue/20/solid/index.js";
</script>
