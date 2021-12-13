<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            Account List
        </template>

        <add-new-button :href="route('expenses.create')" />

        <data-table :collections="expenses" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: expense }">
                <td class="py-3 px-2 text-left">{{ expense.id }}</td>
                <td class="py-3 px-2 text-left">{{ expense.accountableType }}</td>
                <td class="py-3 px-2 text-left">{{ expense.publisherName }}</td>
                <td class="py-3 px-2 text-left">{{ expense.purpose }}</td>
                <td class="py-3 px-2 text-left">{{ expense.amount }}</td>
                <td class="py-3 px-2 text-left">{{ expense.typeName }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('expenses.show', expense.id)" />
                        <action-button-edit :href="route('expenses.edit', expense.id)" />
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
        expenses: { type: Object, default: {} },
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
