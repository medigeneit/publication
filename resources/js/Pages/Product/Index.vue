<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <!-- <add-new-button :href="route('products.create')" /> -->

        <data-table :collections="products" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: product }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('products.show', product.id)" />
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ product.id }}</td>
                <td class="py-3 px-2 text-left">
                    <b>
                        <!-- {{ `${product.volume.version.production.name}, ${product.volume.version.edition} edition (${product.productable.name})` }} -->
                        {{ product.name }}
                    </b>
                </td>
                <td class="py-3 px-2 text-left">
                    {{ product.typeName }}
                </td>
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
                <td class="py-3 px-2 text-right">
                    <div v-if="Object.keys(product.prices).length" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ Object.keys(product.prices).length }} Prices
                    </div>
                    <div v-if="Object.keys(product.prices).length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Prices</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2 mr-10" v-for="(priceCategory, index) in product.priceCategories" :key="priceCategory">
                                        <span>{{ index + 1 }}.</span>
                                        {{ priceCategory }} : {{ product.prices[index] }}
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
                <td class="py-3 px-2 text-right">
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
        pricing: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    methods: {
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        }
    },
    data() {
        return {
           columns: [
                    {title: 'Action', align: 'center'},
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Name', align: 'left', sortable: 'name'},
                    {title: 'Type', align: 'left', sortable: 'type'},
                    {title: 'Active', align: 'left', sortable: 'active'},
                    {title: 'Categrories', align: 'center'},
                    {title: 'Package', align: 'center'},
                    {title: 'Publisher Name', align: 'left', sortable:'publisher.name'},
                    {title: 'Production Cost', align: 'right', sortable:'production_cost'},
                    {title: 'MRP', align: 'right', sortable: 'mrp'},
                    // {title: 'Wholesale', align: 'right', sortable: 'wholesale_price'},
                    // {title: 'Retail', align: 'right', sortable: 'retail_price'},
                    // {title: 'Distributor', align: 'right', sortable: 'distributor_price'},
                    // {title: 'Special', align: 'right', sortable: 'special_price'},
                    // {title: 'Outside Dhaka', align: 'right', sortable: 'outside_dhaka_price'},
                    // {title: 'Ecom Distribution', align: 'right', sortable: 'ecom_distribution_price'},
                    // {title: 'Ecom Wholesale', align: 'right', sortable: 'ecom_wholesale_price'},
                    {title: 'Prices', align: 'right'},
                    // {title: 'Prices', align: 'right'},
                    {title: 'Alert', align: 'right', sortable: 'alert_quantity'},
                ],
        }
    },
};
</script>
