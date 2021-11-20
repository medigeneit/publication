<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            {{ sale.name }}
        </template>

        <add-new-button :href="route('sales.create')" class="mb-4" />


        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ sale.id }}</show-table-row>
                <show-table-row heading="Name">{{ sale.outletName }}</show-table-row>
                <show-table-row heading="Customer Name">{{ sale.customerName }}</show-table-row>
                <show-table-row heading="Phone">{{ sale.customerPhone }}</show-table-row>
                <show-table-row heading="Customer Adress">{{ sale.customerAddress }}</show-table-row>
                <show-table-row heading="Sub Total">{{ sale.subTotal }}</show-table-row>
                <show-table-row heading="Discount">{{ sale.discount }}</show-table-row>
                <show-table-row heading="Disount Purpose">{{ sale.discountPurpose }}</show-table-row>
                <show-table-row heading="Amount">{{ sale.amount }}</show-table-row>
                <show-table-row heading="Created By">{{ sale.createdBy }}</show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('sales.edit', sale.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('sales.index')"/>
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

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
    },
    props: {
        sale: { type: Object, default: {} },
    },
};
</script>
