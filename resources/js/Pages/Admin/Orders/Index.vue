<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import { CheckCircleIcon } from '@heroicons/vue/20/solid'
import {ref} from "vue";

const props = defineProps({
    orders: Object,
});

const updateOrderStatus = (order) => {
    console.log(order);

    router.patch(route('admin.orders.update', {order: order.id}), {
        status: order.status
    },
    {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Order status updated');
        },
        onError: () => {
            console.log('Error updating order status');
        }
    });

};

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white">
                        <div class="mx-auto px-4 py-16 sm:px-6 sm:py-10 lg:max-w-7xl lg:px-8">

                            <div
                                v-if="orders.length === 0"
                                class="mt-8 text-center">
                                <CheckCircleIcon class="h-12 w-12 text-gray-400 mx-auto" aria-hidden="true" />
                                <h2 class="mt-2 text-lg font-medium text-gray-900">
                                    No orders
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    No orders have been placed yet.
                                </p>
                            </div>


                            <div v-if="orders.length > 0" class="mx-auto max-w-7xl sm:px-2 lg:px-8 mb-16">
                                <div class="mx-auto max-w-7xl sm:px-2 lg:px-8 mb-16">
                                    <div class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
                                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                            All Orders
                                        </h1>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Check the status of recent orders, manage returns, and discover similar products.
                                        </p>
                                    </div>
                                </div>
                                <h2 class="sr-only">Recent orders</h2>

                                <div class="mx-auto max-w-7xl sm:px-2 lg:px-8">
                                    <div class="mx-auto max-w-2xl space-y-8 sm:px-4 lg:max-w-4xl lg:px-0">
                                        <div v-for="order in orders" :key="order.number" class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border mb-4">
                                            <h3 class="sr-only">
                                                Order placed on <time :datetime="order.createdDatetime">{{ order.createdDate }}</time>
                                            </h3>

                                            <div class="flex items-center border-b border-gray-200 p-4 sm:grid sm:grid-cols-4 sm:gap-x-6 sm:p-6">
                                                <dl class="grid flex-1 gap-x-8 text-sm sm:col-span-5 sm:grid-cols-5">
                                                    <div>
                                                        <dt class="font-medium text-gray-900">User Name</dt>
                                                        <dd class="mt-1 text-gray-500">{{ order.userName }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-900">Order number</dt>
                                                        <dd class="mt-1 text-gray-500">{{ order.number }}</dd>
                                                    </div>
                                                    <div class="hidden sm:block">
                                                        <dt class="font-medium text-gray-900">Date placed</dt>
                                                        <dd class="mt-1 text-gray-500">
                                                            <time :datetime="order.createdDatetime">{{ order.createdDate }}</time>
                                                        </dd>
                                                    </div>
                                                    <div class="hidden sm:block">
                                                        <dt class="font-medium text-gray-900">Order Total</dt>
                                                        <dd class="mt-1 text-gray-500">{{ order.total }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-900">Address</dt>
                                                        <dd class="mt-1 font-medium text-gray-900">{{ order.full_address }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-900">Current Status</dt>
                                                        <dd class="mt-1 font-medium text-gray-900">{{ order.status }}</dd>
                                                    </div>
                                                    <div>
                                                        <select name="changeStatus" id="changeStatus"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm sm:leading-5"
                                                                v-model="order.status" @change="updateOrderStatus(order)">
                                                            <option value="pending">Pending</option>
                                                            <option value="processing">Processing</option>
                                                            <option value="completed">Completed</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                </dl>
                                            </div>

                                            <!-- Products -->
                                            <h4 class="sr-only">Items</h4>
                                            <ul role="list" class="divide-y divide-gray-200">
                                                <li v-for="product in order.books" :key="product.id" class="p-4 sm:p-6">
                                                    <div class="flex items-center sm:items-start">
                                                        <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 sm:h-20 sm:w-20">
                                                            <img :src="product.image" :alt="product.title" class="h-full w-full object-cover object-center" />
                                                        </div>
                                                        <div class="ml-6 flex-1 text-sm">
                                                            <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                                                                <h5>{{ product.title }}</h5>
                                                                <p class="mt-2 sm:mt-0">{{ product.priceString }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
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
