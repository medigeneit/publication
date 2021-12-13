<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            Account List
        </template>

        <add-new-button :href="route('accounts.create')" />

        <data-table :collections="accounts" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: account }">
                <td class="py-3 px-2 text-left">{{ account.id }}</td>
                <td class="py-3 px-2 text-left">{{ account.accountableType }}</td>
                <td class="py-3 px-2 text-left">{{ account.publisherName }}</td>
                <td class="py-3 px-2 text-left">{{ account.purpose }}</td>
                <td class="py-3 px-2 text-left">{{ account.amount }}</td>
                <td class="py-3 px-2 text-left">{{ account.typeName }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('accounts.show', account.id)" />
                        <action-button-edit :href="route('accounts.edit', account.id)" />
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
        accounts: { type: Object, default: {} },
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
