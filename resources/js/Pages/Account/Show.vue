<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            {{ account.name }}
        </template>

        <add-new-button :href="route('accounts.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ account.id }}</show-table-row>
                <show-table-row heading="Account Type">{{ account.accountableType }}</show-table-row>
                <show-table-row heading="Account Id">{{ account.publisherName }}</show-table-row>
                <show-table-row heading="Purpose">{{ account.purpose ?? '' }}</show-table-row>
                <show-table-row heading="Amount">{{ account.amount }}</show-table-row>
                <show-table-row heading="Type ">{{ account.typeName }}</show-table-row>
                <show-table-row heading="Created By ">{{ account.createdBy }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('accounts.edit', account.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('users.index')"/>
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
        account: { type: Object, default: {} },
    },
};
</script>
