<template>
    <Head title="Version" />

    <app-layout>
        <template #header>
            Version List
        </template>

        <add-new-button :href="route('versions.create')" />

        <data-table :collections="versions" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: version }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('versions.show', version.id)" />
                        <action-button-edit :href="route('versions.edit', version.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ version.id }}</td>
                <td class="py-3 px-2 text-left">{{ version.typeName }}</td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': version.active, 'bg-red-500': !version.active }">
                        {{ version.activeValue }}
                    </span>
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
        versions: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    methods: {
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        }
    },
    data() {
        return {
           columns: [
                    {title: 'Action', align: 'center'},
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Type', align: 'left', sortable: 'type'},
                    {title: 'Active', align: 'left', sortable: 'active'},
                ],
        }
    },
};
</script>
