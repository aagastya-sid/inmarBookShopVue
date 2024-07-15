<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import { CheckIcon, ClockIcon, QuestionMarkCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import OrderSummary from "@/Pages/Cart/orderSummary.vue";

defineProps({
    cartItems: Object,
    orderSummary: Object
})

const removeFromCart = (cartItem) => {
    console.log(cartItem);

    router.delete(route('cart.destroy', {cart: cartItem.id}),
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Shopping Cart</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white">
                        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-0 lg:max-w-7xl lg:px-8">
                            <div class="bg-white">
                                <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                                    <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                                        <section aria-labelledby="cart-heading" class="lg:col-span-7">
                                            <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                                            <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                                                <li v-for="(cartItem, cartItemIdx) in cartItems" :key="cartItem.id" class="flex py-6 sm:py-10">
                                                    <div class="flex-shrink-0">
                                                        <img :src="cartItem.image" :alt="cartItem.title" class="h-15 w-15 rounded-md object-cover object-center sm:h-20 sm:w-20" />
                                                    </div>

                                                    <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                                        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                                            <div>
                                                                <div class="flex justify-between">
                                                                    <h3 class="text-sm">
                                                                        <a :href="cartItem.href" class="font-medium text-gray-700 hover:text-gray-800">{{ cartItem.title }}</a>
                                                                    </h3>
                                                                </div>
                                                                <p class="mt-1 text-sm font-medium text-gray-900">{{ cartItem.priceString }}</p>
                                                            </div>

                                                            <div class="mt-4 sm:mt-0 sm:pr-9">
                                                                <div class="absolute right-0 top-0">
                                                                    <button type="button" class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500"
                                                                        @click="removeFromCart(cartItem)"
                                                                    >
                                                                        <span class="sr-only">Remove</span>
                                                                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </section>

                                        <order-summary :orderSummary="orderSummary" />

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

