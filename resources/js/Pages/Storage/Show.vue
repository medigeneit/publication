<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            {{ storage.name }}
        </template>

        <add-new-button :href="route('storages.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ storage.id }}</show-table-row>

                <show-table-row heading="Outlet Name">{{ storage.outletName }}</show-table-row>

                <show-table-row heading="Product Name">{{ storage.productName }}</show-table-row>

                <show-table-row heading="Quantity">{{ storage.quantity }}</show-table-row>


                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('storages.edit', storage.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('storages.index')"/>
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
        storage: { type: Object, default: {} },
    },
};
</script>
