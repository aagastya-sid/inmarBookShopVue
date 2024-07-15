<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';

defineProps({
    books: Array
})

const addToCart = (book) => {
    console.log(book);

    router.post(route('cart.store'), {
        book_id: book.id
    },
    {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Book added to cart');
        },
        onError: () => {
            console.log('Error adding book to cart');
        }
    });

}

const removeFromCart = (book) => {
    console.log(book);

    router.delete(route('cart.destroy', {cart: book.cart_id}),
    {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Book removed from cart');
        },
        onError: () => {
            console.log('Error removing book from cart');
        }
    });
}

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
                                            <h3 class="text-sm font-medium text-gray-900">{{ book.title.substring(0, 20) }}...</h3>
                                        </div>
                                        <div class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
                                            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
                                            <p class="relative text-lg font-semibold text-white">{{ book.priceString }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <button @click="book.cart_id ? removeFromCart(book) : addToCart(book)"
                                                class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900"
                                                :class="book.cart_id ? 'bg-red-500 hover:bg-red-200' : 'bg-green-500 hover:bg-green-200'"
                                            >
                                            {{ book.cart_id ? 'Remove from cart' : 'Add to cart' }}
                                            <span class="sr-only">, {{ book.title }}</span>
                                        </button
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
