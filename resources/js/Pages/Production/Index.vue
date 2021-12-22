<template>
    <Head title="Production" />

    <app-layout>
        <template #header>
            Production List
        </template>

        <add-new-button :href="route('productions.create')" />

        <data-table :collections="productions" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: production }">
                <td class="py-2 px-2 text-left">{{ production.id }}</td>
                <td class="py-2 px-2 text-left">{{ production.name }}</td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('productions.show', production.id)" />
                        <action-button-edit :href="route('productions.edit', production.id)" />
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
        productions: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
        data() {
        return {
            columns: [
                {title: 'ID', align: 'left', sortable: 'id'},
                {title: 'Name', align: 'left', sortable: 'name'},
                {title: 'Action', align: 'center'},
            ],
        }
    },
};
</script>
