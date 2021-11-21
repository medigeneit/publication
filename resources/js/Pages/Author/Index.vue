<template>
    <Head title="Author" />

    <app-layout>
        <template #header>
            Author List
        </template>

        <add-new-button :href="route('authors.create')" />

        <data-table :collections="authors" :filters="filters" :dateFilter="true">
            <template #head>
                <th class="py-2 px-2 text-left">ID</th>
                <th class="py-2 px-2 text-left">Name</th>
                <th class="py-2 px-2 text-center">Active</th>
                <th class="py-2 px-2 text-right w-8">Honorarium</th>
                <th class="py-2 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: author }">
                <td class="py-2 px-2 text-left">{{ author.id }}</td>
                <td class="py-2 px-2 text-left">{{ author.name }}</td>
                <td class="py-2 px-2 text-center">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500' : author.active, 'bg-red-500' : !author.active }">
                        {{ author.activeValue }}
                    </span>
                </td>
                <td class="py-2 px-2 text-right">{{ author.honorarium }} TK</td>
                <td class="py-2.5 px-2"> 
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('authors.show', author.id)" />
                        <action-button-edit :href="route('authors.edit', author.id)" />
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
        authors: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
};
</script>
