<template>
    <div class="bg-white">
        <div class="pb-16 pt-6 sm:pb-24">
<!--            <nav aria-label="Breadcrumb" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">-->
<!--                <ol role="list" class="flex items-center space-x-4">-->
<!--                    <li v-for="breadcrumb in product.breadcrumbs" :key="breadcrumb.id">-->
<!--                        <div class="flex items-center">-->
<!--                            <a :href="breadcrumb.href" class="mr-4 text-sm font-medium text-gray-900">{{ breadcrumb.name }}</a>-->
<!--                            <svg viewBox="0 0 6 20" aria-hidden="true" class="h-5 w-auto text-gray-300">-->
<!--                                <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />-->
<!--                            </svg>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="text-sm">-->
<!--                        <a :href="product.href" aria-current="page" class="font-medium text-gray-500 hover:text-gray-600">{{ product.name }}</a>-->
<!--                    </li>-->
<!--                </ol>-->
<!--            </nav>-->
            <div class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                    <div class="lg:col-span-5 lg:col-start-8">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-medium text-gray-900">{{ product.title }}</h1>
                            <p class="text-xl font-medium text-gray-900">{{ product.price.formatted }}</p>
                        </div>
                    </div>

                    <!-- Image gallery -->
                    <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                        <h2 class="sr-only">Images</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                            <img v-for="image in product.images" :key="image.id" :src="image.original_url" :alt="product.title" :class="[image.primary ? 'lg:col-span-2 lg:row-span-2' : 'hidden lg:block', 'rounded-lg']" />
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="mt-10 lg:col-span-5">
                        <h2 class="text-sm font-medium text-gray-900">Description</h2>

                        <div class="prose prose-sm mt-4 text-gray-500" v-html="product.description" />
                    </div>

                    <div class="mt-8 lg:col-span-5">
                        <form>
                            <!-- Color picker -->
                            <div v-if="product.variants && product.variants[0].type != 'default'">
                                <h2 class="text-sm font-medium text-gray-900">Color</h2>

                                <RadioGroup v-model="selectedColor" class="mt-2">
                                    <RadioGroupLabel class="sr-only">Choose a color</RadioGroupLabel>
                                    <div class="flex items-center space-x-3">
                                        <RadioGroupOption as="template" v-for="color in product.colors" :key="color.name" :value="color" v-slot="{ active, checked }">
                                            <div :class="[color.selectedColor, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', 'relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none']">
                                                <RadioGroupLabel as="span" class="sr-only">{{ color.name }}</RadioGroupLabel>
                                                <span aria-hidden="true" :class="[color.bgColor, 'h-8 w-8 rounded-full border border-black border-opacity-10']" />
                                            </div>
                                        </RadioGroupOption>
                                    </div>
                                </RadioGroup>
                            </div>

                            <!-- Size picker -->
                            <div class="mt-8" v-if="product.variants && product.variants[0].type != 'default'">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-sm font-medium text-gray-900">Size</h2>
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See sizing chart</a>
                                </div>

                                <RadioGroup v-model="selectedSize" class="mt-2">
                                    <RadioGroupLabel class="sr-only">Choose a size</RadioGroupLabel>
                                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                        <RadioGroupOption as="template" v-for="size in product.sizes" :key="size.name" :value="size" :disabled="!size.inStock" v-slot="{ active, checked }">
                                            <div :class="[size.inStock ? 'cursor-pointer focus:outline-none' : 'cursor-not-allowed opacity-25', active ? 'ring-2 ring-indigo-500 ring-offset-2' : '', checked ? 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700' : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50', 'flex items-center justify-center rounded-md border py-3 px-3 text-sm font-medium uppercase sm:flex-1']">
                                                <RadioGroupLabel as="span">{{ size.name }}</RadioGroupLabel>
                                            </div>
                                        </RadioGroupOption>
                                    </div>
                                </RadioGroup>
                            </div>

                            <button type="submit" class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add to cart</button>
                        </form>

                        <!-- Policies -->
                        <section aria-labelledby="policies-heading" class="mt-10">
                            <h2 id="policies-heading" class="sr-only">Our Policies</h2>

                            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                                <div v-for="policy in policies" :key="policy.name" class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
                                    <dt>
                                        <component :is="policy.icon" class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                        <span class="mt-4 text-sm font-medium text-gray-900">{{ policy.name }}</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">{{ policy.description }}</dd>
                                </div>
                            </dl>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { CurrencyDollarIcon, GlobeAmericasIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
})

const policies = [
    { name: 'Return Policy', icon: GlobeAmericasIcon, description: 'Not happy? We offer 30 days return policy, no questions asked!' },
]
</script>
