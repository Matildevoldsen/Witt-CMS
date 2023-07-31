<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
                                <div class="flex h-16 shrink-0 justify-center items-center">
                                    <ApplicationLogo/>
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <Link :href="item.route ? route(item.route) : ''" :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div v-if="teams?.length >= 0" class="text-xs font-semibold leading-6 text-indigo-200">Your teams</div>
                                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                                <li v-for="team in teams" :key="team.name">
                                                    <a :href="team.href" :class="[team.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">{{ team.initial }}</span>
                                                        <span class="truncate">{{ team.name }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mt-auto">
                                            <Link :href="route('dashboard.settings.show')" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                                <Cog6ToothIcon class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white" aria-hidden="true" />
                                                Settings
                                            </Link>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center justify-center">
                    <ApplicationLogo/>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li
                                    v-for="item in navigation"
                                    v-on:click="item.showDropDown = !item.showDropDown"
                                    :class="item.showDropDown ? 'text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-sm' : ''"
                                    :key="item.name">
                                    <Link
                                        v-if="!item?.children"
                                        :href="item.route ? route(item.route) : ''"
                                        :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white', 'hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                        {{ item.name }}

                                        <ChevronDownIcon v-if="item?.children" class="flex-shrink-0 ml-auto h-5 w-5 text-indigo-300 group-hover:text-white" aria-hidden="true" />
                                    </Link>

                                    <a
                                        v-if="item?.children"
                                        href="#"
                                        :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white', 'hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                        {{ item.name }}

                                        <ChevronDownIcon v-if="item?.children.length" class="flex-shrink-0 ml-auto h-5 w-5 text-indigo-300 group-hover:text-white" aria-hidden="true" />
                                    </a>

                                    <ul class="flex flex-grow flex-col" :class="item.showDropDown ? '' : 'hidden'">
                                        <li class="group flex-grow flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold" v-for="child in item.children">
                                            <Link
                                                :href="child.route ? route(child.route) : ''"
                                                :class="[child.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'ml-5 hover:bg-indigo-600 flex-grow group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                <component v-if="child?.icon" :is="child.icon" :class="[child.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                                {{ child.name }}
                                            </Link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div v-if="teams.length >= 1" class="text-xs font-semibold leading-6 text-indigo-200">Your teams</div>
                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                <li v-for="team in teams" :key="team.name">
                                    <a :href="team.href" :class="[team.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">{{ team.initial }}</span>
                                        <span class="truncate">{{ team.name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            <Link :href="route('dashboard.settings.show')" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
                                <Cog6ToothIcon class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white" aria-hidden="true" />
                                Settings
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-72">
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="relative flex flex-1" action="#" method="GET">
                        <label for="search-field" class="sr-only">Search</label>
                        <MagnifyingGlassIcon class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" aria-hidden="true" />
                        <input id="search-field" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." type="search" name="search" />
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Separator -->
                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true" />

                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative">
                            <MenuButton class="-m-1.5 flex items-center p-1.5">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full bg-gray-50" :src="$page.props.auth?.user?.profile_photo_url" :alt="`Profile photo of ${$page.props.auth.user.name}`" />
                                <span class="hidden lg:flex lg:items-center">
                                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ $page.props.auth.user.name }}</span>
                                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                                </span>
                            </MenuButton>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <Link v-if="item.method == 'get'" :href="route(item.route)" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">{{ item.name }}</Link>
                                        <button v-else="item.method == 'post'" v-on:click="logout" type="button" class="flex w-full" :class="[active ? 'bg-gray-50' : '', 'px-3 py-1 text-sm leading-6 text-gray-900']">{{ item.name }}</button>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import {Link, router} from "@inertiajs/vue3";
import { ref } from 'vue'
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon, DocumentPlusIcon,
    FolderIcon,
    HomeIcon, ShoppingBagIcon,
    UsersIcon,
    ChevronUpIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import {ChevronDownIcon, MagnifyingGlassIcon, PencilIcon, PencilSquareIcon} from '@heroicons/vue/20/solid'
import ApplicationLogo from "../ApplicationLogo.vue";

const navigation = ref([
    { name: 'Dashboard', route: 'dashboard', icon: HomeIcon, current: true, showDropDown: false },
    { name: 'Pages', route: 'dashboard', icon: DocumentPlusIcon, current: false, showDropDown: false },
    { name: 'Posts', route: 'dashboard', icon: PencilSquareIcon, current: false, showDropDown: false },
    {
        name: 'Shop', route: 'dashboard', icon: ShoppingBagIcon, current: false, showDropDown: false,
        children: [
            { name: 'Inventory', route: 'dashboard.shop.inventory', icon: null, current: false },
            { name: 'Products', route: 'dashboard.shop.products', icon: null, current: false },
            { name: 'Orders', route: 'dashboard.shop.orders', icon: null, current: false },
            { name: 'Customers', route: 'dashboard.shop.customers', icon: null, current: false },
            { name: 'Reports', route: 'dashboard.shop.reports', icon: null, current: false },
        ]
    },
    {
        name: 'Users', route: 'dashboard', icon: UsersIcon, current: false, children: [
            { name: 'All Users', route: 'dashboard', icon: null, current: false },
            { name: 'Roles', route: 'roles.show', icon: null, current: false },
        ]
    },
])

const teams = [
    // { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    // { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    // { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]
const userNavigation = [
    { name: 'Your profile', route: 'profile.show', method: 'get' },
    { name: 'Sign out', route: 'logout', method: 'post' },
]

const sidebarOpen = ref(false)

const logout = () => {
    router.post(route('logout'));
};
</script>
