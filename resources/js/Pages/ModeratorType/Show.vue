<template>
    <Head title="Price Category" />

    <app-layout>
        <template #header>
            <!-- {{ priceCategory.name }} -->
        </template>

        <add-new-button :href="route('moderator-types.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ ModeratorType.id }}</show-table-row>
                <show-table-row heading="Name">{{ ModeratorType.name }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('moderator-types.edit', ModeratorType.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('moderator-types.index')"/>
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
        ModeratorType: { type: Object, default: {} },
    },
};
</script>
