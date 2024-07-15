<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import {Head, router, useForm} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const props = defineProps({
    book: {
        type: Object,
        required: false,
        default: () => ({})
    },
});

const alert = ref({
    show: false,
    message: ''
});

const formData = ref({
    book_title: props.book.title ?? '',
    book_author: props.book.author ?? '',
    book_price: props.book.price ?? '',

});

const creating = ref(false);


function createBook() {
    router.post(route('admin.books.store'), formData.value, {
        preserveScroll: true,
        onSuccess: (res) => {
            console.log(res);
            alert.value.show = true;
            alert.value.message = 'Book created successfully.'
        },
        onError: () => {
            console.log('Error creating book');
            alert.value.show = true;
            alert.value.message = 'Error creating book.'
        }
    });
}

function updateBook() {
    router.patch(route('admin.books.update', {book: props.book.id}), formData.value, {
        preserveScroll: true,
        onSuccess: (res) => {
            console.log(res);
            alert.value.show = true;
            alert.value.message = 'Book updated successfully.'
        },
        onError: () => {
            console.log('Error updating book');
            alert.value.show = true;
            alert.value.message = 'Error updating book.'
        }
    });
}

const handleFormSubmit = (event) => {
    event.preventDefault();

    creating.value = !props.book.id;

    if (creating.value) {
        createBook();
    } else {
        updateBook();
    }

    router.patch(route('admin.books.update', {book: props.book.id}), formData.value, {
        preserveScroll: true,
        onSuccess: (res) => {
            console.log(res);
            alert.value.show = true;
            alert.value.message = 'Book updated successfully.'
        },
        onError: () => {
            console.log('Error updating book');
            alert.value.show = true;
            alert.value.message = 'Error updating book.'
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

                            <div class="rounded-md bg-green-50 p-4 my-4"
                                    v-if="alert.show"
                                 >
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            {{ alert.message }}
                                        </p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button type="button"
                                                    @click="alert.show = false"
                                                    class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                                <span class="sr-only">Dismiss</span>
                                                <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form @submit="handleFormSubmit">
                                <div class="space-y-12">

                                    <div class="border-b border-gray-900/10 pb-12">
                                        <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                                        <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>

                                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                            <div class="sm:col-span-3">
                                                <label for="book-title" class="block text-sm font-medium leading-6 text-gray-900">Book name</label>
                                                <div class="mt-2">
                                                    <input type="text" name="book-title" id="book-title" autocomplete="book-title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    v-model="formData.book_title"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="book-author" class="block text-sm font-medium leading-6 text-gray-900">Book Author</label>
                                                <div class="mt-2">
                                                    <input type="text" name="book-author" id="book-author" autocomplete="book-author" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    v-model="formData.book_author"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label for="book-price" class="block text-sm font-medium leading-6 text-gray-900">Quantity</label>
                                                <div class="mt-2">
                                                    <input id="book-price" name="book-price" type="number" autocomplete="book-price" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    v-model="formData.book_price"
                                                    />
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <NavLink :href="route('admin.books.index')" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</NavLink>
                                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
