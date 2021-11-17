<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            {{ product.name }}
        </template>

        <add-new-button :href="route('products.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ product.id }}</show-table-row>
                <show-table-row heading="Name">{{ product.name }}</show-table-row>
                <show-table-row heading="Type">{{ product.type }}</show-table-row>
                <show-table-row heading="Publisher Name">{{ product.publisherId ?? '' }}</show-table-row>
                <show-table-row heading="Author Percentage">{{ product.authorPercentage }}%</show-table-row>
                <show-table-row heading="MRP ">{{ product.mrp }}</show-table-row>
                <show-table-row heading="Wholesale Price">{{ product.wholesalePrice }}</show-table-row>
                <show-table-row heading="Retail Price">{{ product.retailPrice }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('users.index')"/>
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
        product: { type: Object, default: {} },
    },
};
</script>
