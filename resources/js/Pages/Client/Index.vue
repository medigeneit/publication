<template>
    <Head title="Client" />

    <app-layout>
        <template #header> Client List </template>

        <add-new-button :href="route('clients.create')" />

        <data-table
            :collections="clients"
            :filters="filters"
            :dateFilter="true"
            :top-links="true"
            :columns="columns"
            :latest="true"
        >
            <template #default="{ item: client }">
                <td class="py-3 px-2 text-left">{{ client.id }}</td>
                <td class="py-3 px-2 text-left">{{ client.name }}</td>
                <td class="py-3 px-2 text-center">{{ client.address }}</td>
                <td class="py-3 px-2 text-center">{{ client.phone }}</td>
                <td class="py-3 px-2 text-center">{{ client.email }}</td>
                <td class="py-3 px-2 text-center">
                    {{ client.typeName }}
                </td>
                <td class="py-3 px-2 text-center">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': client.active,
                            'bg-red-500': !client.active,
                        }"
                    >
                        {{ client.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2">
                    <div
                        class="flex justify-center items-center gap-1 md:gap-2"
                    >
                        <action-button-show
                            :href="route('clients.show', client.id)"
                        />
                        <action-button-edit
                            :href="route('clients.edit', client.id)"
                        />
                    </div>
                </td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import DataTable from "@/Components/DataTable.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

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
        clients: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns: [
                { title: "ID", align: "left", sortable: "id" },
                { title: "Name", align: "left", sortable: "name" },
                { title: "Address", align: "center", sortable: "address" },
                { title: "Phone", align: "center", sortable: "phone" },
                { title: "Email", align: "center", sortable: "email" },
                { title: "Type", align: "center", sortable: "type" },
                { title: "Active", align: "center", sortable: "active" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
