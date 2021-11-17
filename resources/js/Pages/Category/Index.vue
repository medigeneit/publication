<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            User List
        </template>

        <add-new-button :href="route('categories.create')" />

        <data-table :collections="categories" :filters="filters">
            <template #head>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-left">Parent</th>
                <th class="py-3 px-2 text-left">Active</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: category }">
                <td class="py-3 px-2 text-left">{{ category.id }}</td>
                <td class="py-3 px-2 text-left">{{ category.name }}</td>
                <td class="py-3 px-2 text-left">{{ category.parentName }}</td>
                <td class="py-3 px-2 text-left">{{ category.active ? "Active" : "InActive" }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('categories.show', category.id)" />
                        <action-button-edit :href="route('categories.edit', category.id)" />
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
        categories: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
};
</script>
