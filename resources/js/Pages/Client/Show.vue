<template>
    <Head title="Client" />

    <app-layout>
        <template #header>
            {{ client.name }}
        </template>

        <add-new-button :href="route('clients.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{
                    client.id
                }}</show-table-row>

                <show-table-row heading="Name">{{
                    client.name
                }}</show-table-row>

                <show-table-row heading="Name">{{
                    client.address
                }}</show-table-row>

                <show-table-row heading="Name">{{
                    client.phone
                }}</show-table-row>

                <show-table-row heading="Name">{{
                    client.email
                }}</show-table-row>

                <show-table-row heading="Name">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': client.active,
                            'bg-red-500': !client.active,
                        }"
                    >
                        {{ client.activeValue }}
                    </span>
                </show-table-row>

                <show-table-row heading="Created By">{{
                    client.createdBy
                }}</show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('clients.edit', client.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('clients.index')" />
        </div>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import GoToList from "@/Components/GoToList.vue";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

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
        client: { type: Object, default: {} },
    },
};
</script>
