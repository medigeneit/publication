<template>
    <Head title="Price Category" />

    <app-layout>
        <template #header>
            <!-- {{ priceCategory.name }} -->
        </template>

        <add-new-button :href="route('price-categories.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{
                    priceCategory.id
                }}</show-table-row>
                <show-table-row heading="Name">{{
                    priceCategory.name
                }}</show-table-row>
                <show-table-row heading="Special Price">{{
                    priceCategory.type ? "Yes" : "No"
                }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit
                            :href="
                                route('price-categories.edit', priceCategory.id)
                            "
                        />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('price-categories.index')" />
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
        priceCategory: { type: Object, default: {} },
    },
};
</script>
