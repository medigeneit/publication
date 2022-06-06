<template>

    <Head title="Category Tree" />
    <app-layout>
        <template #header>
            Category Tree
        </template>
        <div class="w-auto mx-auto max-w-3xl bg-white p-4 rounded-lg shadow border">
            <Form v-if="openForm" :data="data">
                <template #footer>
                    <button class="px-2 py-0.5 border rounded bg-red-600 text-white" type="button"
                        @click="openForm = false">Cancel</button>
                </template>
            </Form>

            <button v-show="!openForm" class="px-2 py-0.5 border rounded bg-gray-600 text-white mb-4"
                @click="addNewSubcategory(0)">
                + Add New Category
            </button>

            <ul v-show="!openForm">
                <category-tree :main-parent="true" :collection="categories.data"
                    :add-new-subcategory="addNewSubcategory" :actionButton="true">
                    <template #default="{ item: subcategory  }">
                        <category-tree :collection="subcategory.subcategories" :add-new-subcategory="addNewSubcategory"
                            :actionButton="true">
                            <template #default="{ item: subcategory  }">
                                <category-tree :collection="subcategory.subcategories"
                                    :add-new-subcategory="addNewSubcategory" :actionButton="true">
                                    <template #default="{ item: subcategory  }">
                                        <category-tree :collection="subcategory.subcategories" :lastChild="true"
                                            :actionButton="true">
                                        </category-tree>
                                    </template>
                                </category-tree>
                            </template>
                        </category-tree>
                    </template>
                </category-tree>
            </ul>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/App.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import GoToList from '@/Components/GoToList.vue';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import CategoryTree from '@/Components/CategoryTree.vue';
import Form from './Form.vue';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        GoToList,
        Button,
        Input,
        Label,
        CategoryTree,
        Form,
    },
    props: {
        categories: {
            type: Object,
            default: {}
        }
    },

    updated() {
        this.openForm = false;
    },

    data() {
        return {
            openForm: false,
            data: {
                parent: {
                    id: 0,
                    name: '',
                },
            }
        }
    },

    methods: {
        addNewSubcategory(parentId = 0, parentName = '') {
            console.log(parentId);
            this.openForm = true;
            this.data.parent.id = parentId;
            this.data.parent.name = parentName;
        },
    }
}
</script>