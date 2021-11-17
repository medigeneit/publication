<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header>
            Outlet List
        </template>

        <add-new-button :href="route('outlets.create')" />

        <data-table :collections="outlets" :filters="filters" :dateFilter="true">
            <template #head>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-center">Addres</th>
                <th class="py-3 px-2 text-center">Phone</th>
                <th class="py-3 px-2 text-center">Email</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: outlet }">
                <td class="py-3 px-2 text-left">{{ outlet.id }}</td>
                <td class="py-3 px-2 text-left">{{ outlet.name }}</td>
                <td class="py-3 px-2 text-left">{{ outlet.address }}</td>
                <td class="py-3 px-2 text-left">{{ outlet.phone }}</td>
                <td class="py-3 px-2 text-left">{{ outlet.email }}</td>
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
};
</script>
