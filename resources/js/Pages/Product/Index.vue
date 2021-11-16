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
                <th class="py-3 px-2 text-left">Author Percentage</th>
                <th class="py-3 px-2 text-left">MRP</th>
                <th class="py-3 px-2 text-left">Wholesale Price</th>
                <th class="py-3 px-2 text-left">Retail Price</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: product }">
                <td class="py-3 px-2 text-left">{{ product.id }}</td>
                <td class="py-3 px-2 text-left">{{ product.name }}</td>
                <td class="py-3 px-2 text-left">{{ product.type }}</td>
                <td class="py-3 px-2 text-left">{{ product.publisherId ?? '' }}</td>
                <td class="py-3 px-2 text-left">{{ product.authorPercentage }}%</td>
                <td class="py-3 px-2 text-left">{{ product.mrp }}</td>
                <td class="py-3 px-2 text-left">{{ product.wholesalePrice }}</td>
                <td class="py-3 px-2 text-left">{{ product.retailPrice }}</td>
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
        filters: { type: Object, default: {} },
    },
};
</script>
