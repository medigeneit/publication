<template>
    <Head title="Print" />

    <app-layout>

        <add-new-button :href="route('printing-costs.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">


            <table class="table-auto">
                <show-table-row heading="ID">
                    {{ printing_cost.id }}
                </show-table-row>

                <show-table-row heading="Order Date">
                    {{ printing_cost.order_date }}
                </show-table-row>

                <show-table-row heading="Page Amount">
                    {{ printing_cost.page_amount }} pages
                </show-table-row>

                <show-table-row heading="Page Amount">
                    {{ printing_cost.copy_quantity }} pc
                </show-table-row>

                <show-table-row heading="Press">
                    {{ printing_cost.press }} 
                </show-table-row>

                <show-table-row heading="Building Cost">
                    {{ printing_cost.buinding_type }}
                </show-table-row>

                <show-table-row heading="Version Cost">
                      {{ printing_cost.version_cost }} 
                </show-table-row>

                <show-table-row heading="Printing Details">
                      {{ printing_cost.printing_details }} 
                </show-table-row>

                <show-table-row heading="Printing Contributors">
                      {{ printing_cost.printing_contributors }} 
                </show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('printing-costs.edit', printing_cost.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('printing-costs.index')"/>
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
        printing_cost: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
};
</script>
