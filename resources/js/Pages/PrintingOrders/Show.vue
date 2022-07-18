<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header>
            {{ productRequest.id }}
        </template>

        <add-new-button :href="route('outlets.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ productRequest.id }}</show-table-row>

                <show-table-row heading="Request Quantity">{{ productRequest.productQuantity }}</show-table-row>

                <show-table-row heading="Expected Date">{{ productRequest.expectedDate }}</show-table-row>

                <show-table-row heading="Requested By">{{ productRequest.storage.outlet.name ?? '' }}</show-table-row>

                <show-table-row heading="Active">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': productRequest.pending, 'bg-red-500': !productRequest.pending }">
                        {{ productRequest.pending == 1 ? 'Completed' : 'Pending' }}
                    </span>
                </show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('product-requests.edit', productRequest.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div v-for="circulation in productRequest.circulations" :key="circulation.id" class="max-w-4xl p-5">
                <show-table-row heading="Circulation">{{ circulation.id  }}</show-table-row>
                <show-table-row heading="OUTLET NAME	">{{ circulation.storage.outlet.name  }}</show-table-row>
                <show-table-row heading="PRODUCT NAME">{{ circulation.storage.product.product_name  }}</show-table-row>
                <show-table-row heading="QUANTITY" :class="{'text-red-500': circulation.quantity < 0, 'text-green-500': circulation.quantity > 0 }">{{ circulation.quantity  }}</show-table-row>
                <show-table-row heading="ALERT QUANTITY">{{ circulation.storage.alert_quantity  }}</show-table-row>
                <show-table-row heading="CREATED BY">{{ productRequest.storage.user.name }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('product-requests.edit', productRequest.id)" />
                    </div>
                </show-table-row>
        </div>
       
        <div class="w-full mt-4 flex">
            <go-to-list :href="route('product-requests.index')"/>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from '@/Components/GoToList.vue';
import AddNewButton from '@/Components/AddNewButton.vue';
import DataTable from "@/Components/DataTable.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
        DataTable
    },
    props: {
        productRequest: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },

    data() {
        return {
           columns: [
                {title: 'Circulation Of', align : 'left', sortable : 'outlet.name'},
                {title: 'Product Name', align : 'left', sortable : 'product.name'},
                {title: 'Quantity', align : 'left', sortable : 'quantity'},
                {title: 'From / To', align : 'left', sortable : 'outlet.name'},
                {title: 'Date', align : 'left', sortable : 'created_at'},
                ],
        }
    },
};
</script>
