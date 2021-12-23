<template>
    <Head title="Account Category" />

    <app-layout>
        <template #header>
            Account Category List
        </template>

        <add-new-button :href="route('account-categories.create')" />

        <data-table :collections="accountCategories" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: accountCategory }">
                <td class="py-3 px-2 text-left">{{ accountCategory.id }}</td>
                <td class="py-3 px-2 text-left">{{ accountCategory.name }}</td>
                <td class="py-3 px-2 text-left">{{ accountCategory.typeName }}</td>
                <td class="py-3 px-2 text-left">
                     <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500' : accountCategory.active, 'bg-red-500' : !accountCategory.active }">
                        {{ accountCategory.activeValue }}
                     </span>
                </td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('account-categories.show', accountCategory.id)" />
                        <action-button-edit :href="route('account-categories.edit', accountCategory.id)" />
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
        accountCategories: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Name', align : 'left', sortable : 'name'},
                {title: 'Type', align : 'left', sortable: 'type'},
                {title: 'Active', align : 'left', sortable: 'active'},
                {title: 'Action', align : 'center'},
            ]
        }
    },
};
</script>
