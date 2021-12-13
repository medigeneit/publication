<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header>
            Outlet List
        </template>

        <add-new-button :href="route('outlets.create')" />

        <data-table :collections="outlets" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: outlet }">
                <td class="py-3 px-2 text-left">{{ outlet.id }}</td>
                <td class="py-3 px-2 text-left">{{ outlet.name }}</td>
                <td class="py-3 px-2 text-center">{{ outlet.address }}</td>
                <td class="py-3 px-2 text-center">{{ outlet.phone }}</td>
                <td class="py-3 px-2 text-center">{{ outlet.email }}</td>
                <td class="py-3 px-2 text-center">{{ outlet.typeName }}</td>
                <td class="py-3 px-2 text-center">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': outlet.active, 'bg-red-500': !outlet.active }">
                        {{ outlet.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('outlets.show', outlet.id)" />
                        <action-button-edit :href="route('outlets.edit', outlet.id)" />
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
        outlets: { type: Object, default: {} },
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
