<template>
    <Head title="Press" />

    <app-layout>
        <template #header>
            {{ press.name }}
        </template>

        <add-new-button :href="route('presses.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">
                    {{ press.id }}
                </show-table-row>

                <show-table-row heading="Name">
                    {{ press.name }}
                </show-table-row>

                <show-table-row heading="Phone">
                    {{ press.phone }}
                </show-table-row>

                <show-table-row heading="Email">
                    {{ press.email }}
                </show-table-row>

                <show-table-row heading="Address">
                    <div class="whitespace-pre-wrap">
                        {{ press.address }}
                    </div>
                </show-table-row>

                <show-table-row heading="Active">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': press.active,
                            'bg-red-500': !press.active,
                        }"
                    >
                        {{ press.active ? "Yes" : "No" }}
                    </span>
                </show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('presses.edit', press.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('presses.index')" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from "@/Components/GoToList.vue";
import AddNewButton from "@/Components/AddNewButton.vue";

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
        press: { type: Object, default: {} },
    },
};
</script>
