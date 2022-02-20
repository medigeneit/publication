<template>
    <Head title="Circulation" />

    <app-layout>
        <template #header>
            {{ circulation.name }}
        </template>

        <add-new-button :href="route('circulations.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ circulation.id }}</show-table-row>

                <show-table-row heading="Outlet Name">{{ circulation.outletName }}</show-table-row>

                <show-table-row heading="Product Name">{{ circulation.productName }}</show-table-row>

                <show-table-row heading="Quantity">{{ circulation.quantity }}</show-table-row>

                <show-table-row heading="Alert Quantity">{{ circulation.alert_quantity }}</show-table-row>

                <show-table-row heading="Created By">{{ circulation.createdBy }}</show-table-row>


                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('circulations.edit', circulation.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('circulations.index')"/>
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
        circulation: { type: Object, default: {} },
    },
};
</script>
