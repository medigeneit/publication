<template>
    <Head title="Version" />

    <app-layout>
        <template #header>
            {{ version.name }}
        </template>

        <add-new-button :href="route('versions.create')" class="mb-4" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">
                    {{ version.id }}
                </show-table-row>
                <show-table-row heading="Name">
                    {{ version.name }}
                </show-table-row>
                <show-table-row heading="Edition">
                    {{ version.edition }}
                </show-table-row>
                <show-table-row heading="Type">
                    {{ version.typeName }}
                </show-table-row>
                <!-- <show-table-row heading="Category">
                    <div v-for="(categoryName, index) of categories" :key="index">
                        {{ categoryName }}
                    </div>
                </show-table-row> -->
                <show-table-row heading="Publisher Name">
                    {{ version.publisherName ?? '' }}
                </show-table-row>
                <show-table-row heading="Production Cost">
                    {{ version.productionCost }}
                </show-table-row>
                <show-table-row heading="Volumes">
                    <div v-for="(volume, index) of volumes" :key="index">
                            name - {{ volume.name }},
                            isbn - {{ volume.isbn }},
                            crl - {{ volume.crl }}
                    </div>
                </show-table-row>
                <show-table-row heading="Active">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': version.active, 'bg-red-500': !version.active }">
                        {{ version.activeValue }}
                    </span>
                </show-table-row>
                <show-table-row heading="Created By">
                    {{ version.createdBy }}

                </show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('versions.edit', version.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('versions.index')"/>
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
        version: { type: Object, default: {} },
        volumes: { type: Object, default: {} },
    },
};
</script>
