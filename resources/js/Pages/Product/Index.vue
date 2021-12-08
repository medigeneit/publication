<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <add-new-button :href="route('products.create')" />

        <data-table :collections="products" :filters="filters">
            <template #head>
                <th class="py-3 px-2 text-center">Action</th>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-left">Type</th>
                <th class="py-3 px-2 text-left">Active</th>
                <th class="py-3 px-2 text-center">Categories</th>
                <th class="py-3 px-2 text-center">Package</th>
                <th class="py-3 px-2 text-left">Publisher Name</th>
                <th class="py-3 px-2 text-right">Cost</th>
                <th class="py-3 px-2 text-right">MRP</th>
                <th class="py-3 px-2 text-right">Wholesale</th>
                <th class="py-3 px-2 text-right">Retail</th>
                <th class="py-3 px-2 text-right">Distributor</th>
                <th class="py-3 px-2 text-right">Special</th>
                <th class="py-3 px-2 text-right">Outside Dhaka</th>
                <th class="py-3 px-2 text-right">Ecom Distribution</th>
                <th class="py-3 px-2 text-right">Ecom Wholesale</th>
                <th class="py-3 px-2 text-left">Alert</th>
            </template>
            <template #default="{ item: product }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('products.show', product.id)" />
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ product.id }}</td>
                <td class="py-3 px-2 text-left">{{ product.name }}</td>
                <td class="py-3 px-2 text-left">{{ product.typeName }}</td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': product.active, 'bg-red-500': !product.active }">
                        {{ product.activeValue }}
                    </span>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="product.categoryCount" @click="modalHandler" class="text-center border bg-indigo-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ product.categoryCount }} categories
                    </div>
                    <!-- <div v-else class="text-center border bg-indigo-500 text-white px-2 py-0.5 rounded">
                        {{ product.categoryCount }} categories
                    </div> -->
                    <div v-if="product.categoryCount" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Product Categories</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(category, index) in product.categories" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500" :href="route('categories.show', category.id)">{{ category.name }}</Link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="product.packageProductCount" @click="modalHandler" class="text-center border bg-yellow-600 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ product.packageProductCount }} products
                    </div>
                    <div v-if="product.packageProductCount" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Package Products</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(packageProduct, index) in product.packageProducts" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500" :href="route('categories.show', packageProduct.id)">{{ packageProduct.name }}</Link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ product.publisherName ?? '' }}</td>
                <td class="py-3 px-2 text-right">{{ product.productionCost }}</td>
                <td class="py-3 px-2 text-right">{{ product.mrp }}</td>
                <td class="py-3 px-2 text-right">{{ product.wholesalePrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.retailPrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.distributePrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.specialPrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.outsideDhakaPrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.ecomDistributePrice }}</td>
                <td class="py-3 px-2 text-right">{{ product.ecomWholesalePrice }}</td>
                <td class="py-3 px-2 text-left">
                    <!-- <span class="py-1 px-3 rounded-full text-white font-bold bg-gray-500"> -->
                        {{ product.alertQuantity }}
                    <!-- </span> -->
                </td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from '@/Components/AddNewButton.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
    },
    props: {
        products: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    methods: {
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        }
    }
};
</script>
