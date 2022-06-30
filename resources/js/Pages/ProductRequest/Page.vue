<template>
    <Head title="Request Page" />

    <app-layout>
        <template #header> Request </template>
        <div class="grid grid-cols-12 gap-2">
            <div
                class="col-span-6 md:col-span-4 lg:col-span-2 p-6 bg-white rounded-lg border border-white-200 shadow-md dark:bg-white-800 dark:border-white-700"
                v-for="(item, index) in items"
                :key="index"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-white-900"
                    >
                        Outlet {{ index }}
                    </h5>
                </a>
                <div class="mb-3 font-extrabold">
                    {{ item.product }}
                </div>
                <div class="mb-3 text-sm">
                    requested <span class="text-sm font-extrabold">10 pcs</span>
                </div>
                <div class="mb-3">
                    <p class="font-extrabold text-sm unde">Expected Date:</p>
                    {{ item.expectedDate }}
                </div>
                <div
                    href="#"
                    class="inline-flex ite-ms-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                    @click="modalShow($event, index)"
                >
                    See
                    <svg
                        class="ml-2 -mr-1 w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>

                <div class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-7xl bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Circulations</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <!-- <div class="py-1.5 flex gap-2" v-for="(category, index) in product.categories"
                                        :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500"
                                            :href="route('categories.show', category.id)">{{ category.name }}</Link>
                                    </div> -->
                                    dfdfdfjkdhfjkdhf
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40"
                                    @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Head,
        Link,
        AppLayout,
    },

    data() {
        return {
            items: {
                1: {
                    product: "Last Hour",
                    expectedDate: "06-06-2022",
                },
                2: {
                    product: "Residency Pearl",
                    expectedDate: "16-06-2022",
                },
                3: {
                    product: "Surgeon Profile",
                    expectedDate: "26-07-2022",
                },
                4: {
                    product: "Amar Bangla Boi",
                    expectedDate: "06-07-2022",
                },
            },
        };
    },
    methods: {
        modalShow(event, index) {
            console.log(event.target.nextElementSibling);
            event.target.nextElementSibling.classList.toggle('hidden');
            console.log(this.items[index]);
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');

        },
    },
};
</script>
