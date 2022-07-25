<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            Distributor List
        </template>

        <add-new-button :href="route('distributors.create')" />

        <data-table :collections="distributors" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: distributor }">
                <td class="py-3 px-2 text-left">{{ distributor.id }}</td>
                <td class="py-3 px-2 text-left">{{ distributor.name }}</td>
                <td class="py-3 px-2 text-center">{{ distributor.address }}</td>
                <td class="py-3 px-2 text-center">{{ distributor.phone }}</td>
                <td class="py-3 px-2 text-center">{{ distributor.email }}</td>
                <td class="py-3 px-2 text-center">{{ distributor.typeName }}</td>
                <td class="py-3 px-2 text-center">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': distributor.active, 'bg-red-500': !distributor.active }">
                        {{ distributor.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('distributors.show', distributor.id)" />
                        <action-button-edit :href="route('distributors.edit', distributor.id)" />
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
        distributors: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
           columns: [
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Name', align: 'left', sortable: 'name'},
                    {title: 'Address', align: 'center', sortable: 'address'},
                    {title: 'Phone', align: 'center', sortable: 'phone'},
                    {title: 'Email', align: 'center', sortable: 'email'},
                    {title: 'Type', align: 'center', sortable: 'type'},
                    {title: 'Active', align: 'center', sortable: 'active'},
                    {title: 'Action', align: 'center'},
                ],
        }
    },
};
</script>
