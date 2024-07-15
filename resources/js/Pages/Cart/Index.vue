<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {CheckCircleIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {ref} from "vue";

const props = defineProps({
    cartItems: Object,
    orderSummary: Object
})

const shippingInfo = ref({
    address: '',
    city: '',
    state: '',
    postalCode: '',
    phone: ''
});

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

const handlePlaceOrder = () => {
    console.log('Place order');

    //show confirm before placing order
    if (confirm('Are you sure you want to place this order?')) {
        router.post(route('orders.store'), {
            shippingInfo: shippingInfo.value
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Order placed successfully');
            },
            onError: () => {
                console.log('Error placing order');
            }
        });
    }
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

                            <div class="bg-gray-50">
                                <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">

                                    <div v-if="cartItems.length === 0" class="text-center">
                                        <CheckCircleIcon class="h-12 w-12 text-gray-400 mx-auto" aria-hidden="true" />
                                        <h2 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h2>
                                        <p class="mt-1 text-sm text-gray-500">Start adding books to your cart by clicking the "Add to Cart" button on the book page.</p>
                                    </div>

                                    <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16"
                                          v-if="cartItems.length > 0"
                                          @submit.prevent="handlePlaceOrder">
                                        <div>
                                            <div class="mt-10 border-t border-gray-200 pt-10">
                                                <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                                                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

                                                    <div class="sm:col-span-2">
                                                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                                        <div class="mt-1">
                                                            <input type="text"
                                                                   v-model="shippingInfo.address"
                                                                   name="address" id="address" autocomplete="street-address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                                        <div class="mt-1">
                                                            <input type="text"
                                                                     v-model="shippingInfo.city"
                                                                   name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
                                                        <div class="mt-1">
                                                            <input type="text"
                                                                   v-model="shippingInfo.state"
                                                                   name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                                                        <div class="mt-1">
                                                            <input type="text"
                                                                   v-model="shippingInfo.postalCode"
                                                                   name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                                        <div class="mt-1">
                                                            <input type="text"
                                                                   v-model="shippingInfo.phone"
                                                                   name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order summary -->
                                        <div class="mt-10 lg:mt-0">
                                            <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                                            <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                                                <h3 class="sr-only">Items in your cart</h3>
                                                <ul role="list" class="divide-y divide-gray-200">
                                                    <li v-for="(cartItem, cartItemIdx) in cartItems" :key="cartItem.id" class="flex px-4 py-6 sm:px-6">
                                                        <div class="flex-shrink-0">
                                                            <img :src="cartItem.image" :alt="cartItem.imageAlt" class="w-20 rounded-md" />
                                                        </div>

                                                        <div class="ml-6 flex flex-1 flex-col">
                                                            <div class="flex">
                                                                <div class="min-w-0 flex-1">
                                                                    <h4 class="text-sm">
                                                                        <p class="font-medium text-gray-700 hover:text-gray-800">{{ cartItem.title }}</p>
                                                                    </h4>
                                                                </div>

                                                                <div class="ml-4 flow-root flex-shrink-0">
                                                                    <div type="button"
                                                                         @click="removeFromCart(cartItem)"
                                                                         class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                                                        <span class="sr-only">Remove</span>
                                                                        <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="flex flex-1 items-end justify-between pt-2">
                                                                <p class="mt-1 text-sm font-medium text-gray-900">{{ cartItem.priceString }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                                                    <div class="flex items-center justify-between">
                                                        <dt class="text-sm">Subtotal</dt>
                                                        <dd class="text-sm font-medium text-gray-900">{{ orderSummary.subTotal }}</dd>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <dt class="text-sm">Shipping</dt>
                                                        <dd class="text-sm font-medium text-gray-900">{{ orderSummary.shippingString }}</dd>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <dt class="text-sm">Taxes</dt>
                                                        <dd class="text-sm font-medium text-gray-900">{{ orderSummary.taxString }}</dd>
                                                    </div>
                                                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                                        <dt class="text-base font-medium">Total</dt>
                                                        <dd class="text-base font-medium text-gray-900">{{ orderSummary.grandTotalString }}</dd>
                                                    </div>
                                                </dl>

                                                <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                                    <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                                        Confirm order</button>
                                                </div>
                                            </div>
                                        </div>
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

