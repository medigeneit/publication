<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            {{ distribution.name }}
        </template>

        <add-new-button :href="route('distributions.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ distribution.id }}</show-table-row>

                <show-table-row heading="Name">{{ distribution.name }}</show-table-row>

                <show-table-row heading="Name">{{ distribution.address }}</show-table-row>

                <show-table-row heading="Name">{{ distribution.phone }}</show-table-row>

                <show-table-row heading="Name">{{ distribution.email }}</show-table-row>

                <show-table-row heading="Name">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': distribution.active, 'bg-red-500': !distribution.active }">
                        {{ distribution.activeValue }}
                    </span>
                </show-table-row>

                <show-table-row heading="Created By">{{ distribution.createdBy }}</show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('distributions.edit', distribution.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('distributions.index')"/>
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
        distribution: { type: Object, default: {} },
    },
};
</script>
