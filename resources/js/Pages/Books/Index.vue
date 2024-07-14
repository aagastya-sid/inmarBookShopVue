<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    books: Array
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Books</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white">
                        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                            <h2 class="text-xl font-bold text-gray-900">Customers also bought</h2>

                            <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                                <div v-for="book in books" :key="book.id">
                                    <div class="relative">
                                        <div class="relative h-72 w-full overflow-hidden rounded-lg">
                                            <img :src="book.image" :alt="book.imageAlt" class="h-full w-full object-cover object-center" />
                                        </div>
                                        <div class="relative mt-4">
                                            <h3 class="text-sm font-medium text-gray-900">{{ book.title }}</h3>
                                        </div>
                                        <div class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
                                            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
                                            <p class="relative text-lg font-semibold text-white">{{ book.price }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <a :href="book.href" class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                                        >Add to bag<span class="sr-only">, {{ book.name }}</span></a
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
