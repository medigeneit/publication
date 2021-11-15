<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            {{ user.name }}
        </template>

        <add-new-button :href="route('users.create')" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ user.id }}</show-table-row>

                <show-table-row heading="Name">{{ user.name }}</show-table-row>

                <show-table-row heading="Email">{{ user.email }}</show-table-row>

                <show-table-row heading="Phone">{{ user.phone }}</show-table-row>

                <show-table-row heading="Type">{{ user.typeName }}</show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('users.edit', user.id)" />
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
        user: { type: Object, default: {} },
    },
};
</script>
