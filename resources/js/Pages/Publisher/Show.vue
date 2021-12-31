<template>
    <Head title="Publisher" />

    <app-layout>
        <template #header>
            {{ publisher.name }}
        </template>

        <add-new-button :href="route('publishers.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">
                    {{ publisher.id }}
                </show-table-row>

                <show-table-row heading="Name">
                    {{ publisher.name }}
                </show-table-row>

                <show-table-row heading="Phone">
                    {{ publisher.phone }}
                </show-table-row>

                <show-table-row heading="Email">
                    {{ publisher.email }}
                </show-table-row>

                <show-table-row heading="Address">
                    <div class="whitespace-pre-wrap">
                        {{ publisher.address }}
                    </div>
                </show-table-row>

                <show-table-row heading="Active">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': publisher.active,
                            'bg-red-500': !publisher.active,
                        }"
                    >
                        {{ publisher.active ? "Yes" : "No" }}
                    </span>
                </show-table-row>

                <show-table-row heading="Created By">
                    {{ publisher.createdBy }}
                </show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('publishers.edit', publisher.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('publishers.index')" />
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
        publisher: { type: Object, default: {} },
    },
};
</script>
