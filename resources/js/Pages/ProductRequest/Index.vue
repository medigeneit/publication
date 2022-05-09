<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header>
            Outlet List
        </template>

        <add-new-button :href="route('outlets.create')" />

        <data-table :collections="productRequests" :filters="filters" :columns="columns" :latest="true">
            <template #default="{ item: productRequest }">
                <td class="py-3 px-2 text-left">{{ productRequest.productQuantity }}</td>
                <td class="py-3 px-2 text-center">{{ formatDate(productRequest.expectedDate)}}</td>
                <td class="py-3 px-2 text-center">{{ productRequest.storage.outlet.name ?? '' }}</td>
                <td class="py-3 px-2 text-center">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': productRequest.pending, 'bg-red-500': !productRequest.pending }">
                        {{ productRequest.pending == 1 ? 'Completed' : 'Pending' }}
                    </span>
                </td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('product-requests.show', productRequest.id)" />
                        <action-button-edit :href="route('product-requests.edit', productRequest.id)" />
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
        productRequests: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
           columns: [
                    {title: 'Request Quantity', align: 'left'},
                    {title: 'Expected Date', align: 'center'},
                    {title: 'Outlet', align: 'center'},
                    {title: 'Status', align: 'center'},
                    {title: 'Action', align: 'center'},
                ],
        }
    },
    methods: {
        formatDate(input) {

            console.log(input)

            let date = new Date(input);
            let month = '' + (date.getMonth() + 1);
            let day = '' + date.getDate();
            let year = date.getFullYear();

            if (month.length < 2) {
                month = '0' + month;
            }

            if (day.length < 2) {
                day = '0' + day;
            }

            return [year, month, day].join('-');
        },
    }
};
</script>
