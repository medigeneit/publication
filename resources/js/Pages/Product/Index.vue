<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <add-new-button :href="route('products.create')" />

        <data-table :collections="products" :filters="filters">
            <template #head>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-left">Type</th>
                <th class="py-3 px-2 text-left">Publisher Name</th>
                <th class="py-3 px-2 text-left">Production Cost</th>
                <th class="py-3 px-2 text-left">MRP</th>
                <th class="py-3 px-2 text-left">Wholesale Price</th>
                <th class="py-3 px-2 text-left">Retail Price</th>
                <th class="py-3 px-2 text-left">Distribute Price</th>
                <th class="py-3 px-2 text-left">Special Price</th>
                <th class="py-3 px-2 text-left">Outside Dhaka Price</th>
                <th class="py-3 px-2 text-left">Ecom Distribution Price</th>
                <th class="py-3 px-2 text-left">Ecom Wholesale Price</th>
                <th class="py-3 px-2 text-left">Alert</th>
                <th class="py-3 px-2 text-left">Active</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: product }">
                <td class="py-3 px-2 text-left">{{ product.id }}</td>
                <td class="py-3 px-2 text-left">{{ product.name }}</td>
                <td class="py-3 px-2 text-left">{{ product.typeName }}</td>
                <td class="py-3 px-2 text-left">{{ product.publisherName ?? '' }}</td>
                <td class="py-3 px-2 text-left">{{ product.productionCost }}</td>
                <td class="py-3 px-2 text-left">{{ product.mrp }}</td>
                <td class="py-3 px-2 text-left">{{ product.wholesalePrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.retailPrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.distributePrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.specialPrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.outsideDhakaPrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.ecomDistributePrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.ecomWholesalePrice }}</td>
                <td class="py-3 px-2 text-left">
                    <!-- <span class="py-1 px-3 rounded-full text-white font-bold bg-gray-500"> -->
                        {{ product.alertQuantity }}
                    <!-- </span> -->
                </td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': product.active, 'bg-red-500': !product.active }">
                        {{ product.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('products.show', product.id)" />
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
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
};
</script>
