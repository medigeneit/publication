<template>
    <Head title="Author Type" />

    <app-layout>
        <template #header>
            Author Type List
        </template>

        <add-new-button :href="route('author-types.create')" />

        <data-table :collections="authorTypes" :filters="filters" :columns="columns" :latest="true">
            <!-- <template #head>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template> -->
            <template #default="{ item: authorType }">
                <td class="py-3 px-2 text-left">{{ authorType.name }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('author-types.show', authorType.id)" />
                        <action-button-edit :href="route('author-types.edit', authorType.id)" />
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
        authorTypes: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
         columns: [
            {title: 'Name', align: 'left'},
            {title: 'Action', align: 'center'},
         ]   
        }
    }
};
</script>
