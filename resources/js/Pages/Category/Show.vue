<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            {{ category.name }}
        </template>

        <add-new-button :href="route('categories.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ category.id }}</show-table-row>

                <show-table-row heading="Name">{{ category.name }}</show-table-row>

                <show-table-row heading="Parent">{{ category.parentName }}</show-table-row>

                <show-table-row heading="Active">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': category.active, 'bg-red-500': !category.active }">
                        {{ category.activeValue }}
                    </span>
                </show-table-row>

                <show-table-row heading="Created By">{{ category.createdBy }}</show-table-row>
                
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('categories.edit', category.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('categories.index')"/>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from '@/Components/GoToList.vue';
import AddNewButton from '@/Components/AddNewButton.vue';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
    },
    props: {
        category: { type: Object, default: {} },
    },
};
</script>
