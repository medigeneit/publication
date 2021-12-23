<template>
    <Head title="Price Category" />

    <app-layout>
        <template #header>
            Price Category List
        </template>

        <add-new-button :href="route('price-categories.create')" />

        <data-table :collections="priceCategories" :filters="filters">
            <template #head>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template>
            <template #default="{ item: priceCategory }">
                <td class="py-3 px-2 text-left">{{ priceCategory.name }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('price-categories.show', priceCategory.id)" />
                        <action-button-edit :href="route('price-categories.edit', priceCategory.id)" />
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
        priceCategories: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
};
</script>
