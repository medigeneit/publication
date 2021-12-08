<template>
    <Head title="Income" />

    <app-layout>
        <template #header>
            {{ income.name }}
        </template>

        <add-new-button :href="route('accounts.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ income.id }}</show-table-row>
                <show-table-row heading="Account Type">{{ income.accountableType }}</show-table-row>
                <show-table-row heading="Account Id">{{ income.publisherName }}</show-table-row>
                <show-table-row heading="Purpose">{{ income.purpose ?? '' }}</show-table-row>
                <show-table-row heading="Amount">{{ income.amount }}</show-table-row>
                <show-table-row heading="Type ">{{ income.typeName }}</show-table-row>
                <show-table-row heading="Created By ">{{ income.createdBy }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('incomes.edit', income.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('incomes.index')"/>
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
        income: { type: Object, default: {} },
    },
};
</script>
