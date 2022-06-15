<template>

    <Head title="Role" />

    <app-layout>
        <template #header>
            Role List
        </template>

        <add-new-button :href="route('roles.create')" />

        <data-table :collections="roles" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: role }">
                <td class="py-3 px-2 text-left">{{ role.id }}</td>
                <td class="py-3 px-2 text-left">{{ role.name }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('roles.show', role.id)" />
                        <action-button-edit :href="route('roles.edit', role.id)" />
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
        roles: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Name', align : 'left', sortable : 'name'},
                // {title: 'Accoutable', align : 'left', sortable : 'roleable_id'},
                // {title: 'Purpose', align : 'left', sortable : 'purpose'},
                // {title: 'Amount', align : 'left', sortable : 'amount'},
                // {title: 'Type', align : 'left', sortable : 'type'},
                {title: 'Action', align : 'center'},
            ]
        }
    },
};
</script>
