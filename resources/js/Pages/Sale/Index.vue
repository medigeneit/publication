<template>
    <Head title="Sales" />

    <app-layout>
        <template #header>
            User Sales
        </template>

        <add-new-button :href="route('sales.create')" />

        <data-table :collections="sales" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: sale }">
                <td class="py-3 px-2 text-left">{{ sale.id}}</td>
                <td class="py-3 px-2 text-left">{{ sale.outletName }}</td>
                <td class="py-3 px-2 text-left">{{ sale.customerName }}</td>
                <td class="py-3 px-2 text-left">{{ sale.customerPhone }}</td>
                <td class="py-3 px-2 text-left">{{ sale.customerAddress }}</td>
                <td class="py-3 px-2 text-left">{{ sale.subTotal }}</td>
                <td class="py-3 px-2 text-left">{{ sale.discount }}</td>
                <td class="py-3 px-2 text-left">{{ sale.discountPurpose }}</td>
                <td class="py-3 px-2 text-left">{{ sale.amount }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('sales.show', sale.id)" />
                        <action-button-edit :href="route('sales.edit', sale.id)" />
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
        sales: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Outlet', align : 'left', sortable : 'outlet.outlet_id'},
                {title: 'Customer Name', align : 'left', sortable : 'customer_name'},
                {title: 'Customer Phone', align : 'left', sortable : 'customer_phone'},
                {title: 'Customer Address', align : 'left', sortable : 'customer_address'},
                {title: 'Subtotal', align : 'left', sortable : 'subtotal'},
                {title: 'Discount', align : 'left', sortable : 'discount'},
                {title: 'Discount Purpose', align : 'left', sortable : 'discount_purpose'},
                {title: 'Amount', align : 'left', sortable : 'amount'},
                {title: 'Action', align : 'center'},
            ]
        }
    },
};
</script>
