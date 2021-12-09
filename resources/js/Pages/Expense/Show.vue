<template>
    <Head title="Expense" />

    <app-layout>
        <template #header>
            {{ expense.name }}
        </template>

        <add-new-button :href="route('expenses.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ expense.id }}</show-table-row>
                <show-table-row heading="Account Type">{{ expense.accountableType }}</show-table-row>
                <show-table-row heading="Account Id">{{ expense.publisherName }}</show-table-row>
                <show-table-row heading="Purpose">{{ expense.purpose ?? '' }}</show-table-row>
                <show-table-row heading="Amount">{{ expense.amount }}</show-table-row>
                <show-table-row heading="Type ">{{ expense.typeName }}</show-table-row>
                <show-table-row heading="Created By ">{{ expense.createdBy }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('expenses.edit', expense.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('expenses.index')"/>
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
        expense: { type: Object, default: {} },
    },
};
</script>
