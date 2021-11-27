<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            Distributor List
        </template>

        <add-new-button :href="route('distributions.create')" />

        <data-table :collections="distributions" :filters="filters" :dateFilter="true">
            <template #head>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-center">Address</th>
                <th class="py-3 px-2 text-center">Phone</th>
                <th class="py-3 px-2 text-center">Email</th>
                <th class="py-3 px-2 text-center">Type</th>
                <th class="py-3 px-2 text-center">Active</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: distribution }">
                <td class="py-3 px-2 text-left">{{ distribution.id }}</td>
                <td class="py-3 px-2 text-left">{{ distribution.name }}</td>
                <td class="py-3 px-2 text-center">{{ distribution.address }}</td>
                <td class="py-3 px-2 text-center">{{ distribution.phone }}</td>
                <td class="py-3 px-2 text-center">{{ distribution.email }}</td>
                <td class="py-3 px-2 text-center">{{ distribution.typeName }}</td>
                <td class="py-3 px-2 text-center">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': distribution.active, 'bg-red-500': !distribution.active }">
                        {{ distribution.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('distributions.show', distribution.id)" />
                        <action-button-edit :href="route('distributions.edit', distribution.id)" />
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
        distributions: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
};
</script>
