<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            Account List
        </template>

        <add-new-button :href="route('incomes.create')" />

        <data-table :collections="incomes" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: income }">
                <td class="py-3 px-2 text-left">{{ income.id }}</td>
                <td class="py-3 px-2 text-left">{{ income.accountableType }}</td>
                <td class="py-3 px-2 text-left">{{ income.publisherName }}</td>
                <td class="py-3 px-2 text-left">{{ income.purpose }}</td>
                <td class="py-3 px-2 text-left">{{ income.amount }}</td>
                <td class="py-3 px-2 text-left">{{ income.typeName }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('incomes.show', income.id)" />
                        <action-button-edit :href="route('incomes.edit', income.id)" />
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
        incomes: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Accoutable Type', align : 'left', sortable : 'accountable_type'},
                {title: 'Accoutable', align : 'left', sortable : 'accountable_id'},
                {title: 'Purpose', align : 'left', sortable : 'purpose'},
                {title: 'Amount', align : 'left', sortable : 'amount'},
                {title: 'Type', align : 'left', sortable : 'type'},
                {title: 'Action', align : 'center'},
            ]
        }
    },
};
</script>
