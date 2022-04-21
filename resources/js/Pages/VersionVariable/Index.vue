<template>
    <Head title="Publisher" />

    <app-layout>
        <template #header> Publisher List </template>

       <div class="w-full mx-auto">
        <ValidationErrors class="mb-4" />
        <div class="grid grid-cols-2 gap-2">
            <div class="bg-white border shadow rounded p-4">Printing Details Category Key
                 <data-table
                    :collections="costCategories"
                    :filters="filters"
                    :columns="columns1"
                    :latest="true">
                    <template #default="{ item: costCategorie }">
                        <td class="py-3 px-2 text-left">{{ costCategorie.name }}</td>
                        <td class="py-3 px-2 text-left">{{ costCategorie.active }}</td>
                    </template>
                </data-table>
            </div>
            <div class="bg-white border shadow rounded p-4">Printing Details Category Value
                <div class="w-auto mx-auto max-w-3xl bg-white p-4 rounded-lg shadow border">
                    <Form v-if="openForm" :data="data">
                        <template #footer>
                            <button class="px-2 py-0.5 border rounded bg-red-600 text-white" type="button" @click="openForm = false">Cancel</button>
                        </template>
                    </Form>

                    <button v-show="!openForm" class="px-2 py-0.5 border rounded bg-gray-600 text-white mb-4" @click="addNewSubcategory(0)">
                        + Add New Category
                    </button>

                    <ul v-show="!openForm">
                        <category-tree :main-parent="true" :collection="printingDetailsCategoryValue.data" :add-new-subcategory="addNewSubcategory" >
                            <template #default="{ item: subcategory  }">
                                <category-tree :collection="subcategory.values" :lastChild="true">
                                </category-tree>
                            </template>
                        </category-tree>
                    </ul>
                </div>

            </div>
        </div>

    </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import CategoryTree from '@/Components/PrintingDetailCaterory.vue';
import Form from './Form.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        CategoryTree,
        Form
    },
    props: {
        costCategories: {
            type: Object,
            default: {},
        },

        printingDetailsCategoryValue: {
            type: Object,
            default: {},
        },

        filters: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            columns1: [
                { title: "Name", align: "left", sortable: "name" },
                { title: "Active", align: "left" },
                { title: "Action", align: "left" },
            ],
            openForm: false,
            data: {
                parent: {
                    id: 0,
                    name: '',
                },
            }
            // columns2: [
            //     { title: "Name", align: "left", sortable: "name" },
            //     { title: "Aalue", align: "left" },
            //     { title: "Active", align: "left" },
            //     { title: "Action", align: "left" },
            // ],
        };
    },

    updated() {
        this.openForm = false;
    },

     methods: {
        addNewSubcategory(parentId = 0, parentName = '') {
            console.log(parentId);
            this.openForm = true;
            this.data.parent.id = parentId;
            this.data.parent.name = parentName;
        },
    }
};
</script>


    
   
