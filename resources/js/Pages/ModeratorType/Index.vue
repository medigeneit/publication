<template>
    <Head title="Author Type" />

    <app-layout>
        <template #header>
            Author Type List
        </template>

        <add-new-button :href="route('moderator-types.create')" />

        <data-table :collections="ModeratorTypes" :filters="filters" :columns="columns" :latest="true">
            <!-- <template #head>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template> -->
            <template #default="{ item: ModeratorType }">
                <td class="py-3 px-2 text-left">{{ ModeratorType.name }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('moderator-types.show', ModeratorType.id)" />
                        <action-button-edit :href="route('moderator-types.edit', ModeratorType.id)" />
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
        ModeratorTypes: { type: Object, default: {} },
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
