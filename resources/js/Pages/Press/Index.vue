<template>
    <Head title="Publisher" />

    <app-layout>
        <template #header> Publisher List </template>

        <add-new-button :href="route('presses.create')" />

        <data-table
            :collections="presses"
            :filters="filters"
            :columns="columns"
            :latest="true"
        >
            <template #default="{ item: press }">
                <td class="py-3 px-2 text-left">{{ press.name }}</td>
                <td class="py-3 px-2 text-left">{{ press.phone }}</td>
                <td class="py-3 px-2 text-left">{{ press.email }}</td>
                <td class="py-2 px-2 text-center">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': press.active,
                            'bg-red-500': !press.active,
                        }"
                    >
                        {{ press.active }}
                    </span>
                </td>
                <td class="py-2.5 px-2">
                    <div
                        class="flex justify-center items-center gap-1 md:gap-2"
                    >
                        <action-button-show
                            :href="route('presses.show', press.id)"
                        />
                        <action-button-edit
                            :href="route('presses.edit', press.id)"
                        />
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
import AddNewButton from "@/Components/AddNewButton.vue";

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
        presses: {
            type: Object,
            default: {},
        },
        filters: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            columns: [
                { title: "Name", align: "left", sortable: "name" },
                { title: "Phone", align: "left", sortable: "phone" },
                { title: "Email", align: "left", sortable: "email" },
                { title: "Active", align: "center", sortable: "active" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
