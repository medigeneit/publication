<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            Storage List
        </template>

        <add-new-button :href="route('storages.create')" />

        <data-table :collections="storages" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: storage }">
                <td class="py-3 px-2 text-left">{{ storage.id }}</td>
                <td class="py-3 px-2 text-left">{{ storage.outletName }}</td>
                <td class="py-3 px-2 text-left">{{ storage.productName }}</td>
                <td class="py-3 px-2 text-left">{{ storage.quantity }}</td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('storages.show', storage.id)" />
                        <action-button-edit :href="route('storages.edit', storage.id)" />
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
        storages: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Outlet Name', align : 'left', sortable : 'outlet.name'},
                {title: 'Product Name', align : 'left', sortable : 'product.name'},
                {title: 'Quantity', align : 'left', sortable : 'quantity'},
                {title: 'Action', align : 'center'},
            ]
        }
    },
};
</script>
