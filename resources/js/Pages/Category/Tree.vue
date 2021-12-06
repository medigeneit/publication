<template>
    <Head title="Category Tree"/>
    <app-layout>
        <template #header>
            Category Tree
        </template>
        <div class="w-auto mx-auto max-w-3xl bg-white p-4 rounded-lg shadow border">
            <form class="mb-4" @submit.prevent="submit" v-if="openForm">
                <div class="mb-4" v-if="parentName">
                    <Label for="parent_name" value="Parent Name" />
                    <div class="px-3 py-2 border border-gray-300 rounded-md shadow-sm mt-1 block w-full">
                        {{ parentName }}
                    </div>
                </div>
                <div class="mb-4">
                    <Label v-if="!parentName" for="name" value="Category Name" />
                    <Label v-else for="name" value="Subcategory Name" />
                    <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                </div>
                <div class="flex justify-between">
                    <button class="px-2 py-0.5 border rounded bg-red-600 text-white" @click="openForm = false">Cancel</button>
                    <button class="px-2 py-0.5 border rounded bg-blue-600 text-white" type="submit">Submit</button>
                </div>
            </form>
            <ul class="" v-show="!openForm">
                <button class="px-2 py-0.5 border rounded bg-gray-600 text-white mb-4" @click="addNewCategory(0)">+ Add New Category</button>
                <li v-for="(category, index) in categories.data" :key="index" class="mb-4 relative">
                    <div class="parent flex gap-1 bg-white shadow rounded border p-2" draggable="true">
                        <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700 cursor-pointer transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                        <div class="w-full flex justify-between">
                            <div class="">{{ category.name }}</div>
                            <div class="flex justify-center items-center cursor-pointer text-green-600" @click="addNewCategory(category.id, category.name)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <ul class="mb-8 ml-4 md:ml-8 hidden relative py-4">
                        <li v-for="(subcategory, index) in category.subcategories" :key="index" class="mb-4 relative">
                            <div class="parent flex gap-1 bg-white shadow rounded border p-2" draggable="true">
                                <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700 cursor-pointer transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                </svg>
                                <div class="w-full flex justify-between">
                                    <div class="">{{ subcategory.name }}</div>
                                    <div class="flex justify-center items-center cursor-pointer text-green-600" @click="addNewCategory(subcategory.id, subcategory.name)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <ul class="mb-8 ml-4 md:ml-8 hidden relative py-4">
                                <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="mb-4 relative">
                                    <div class="parent flex gap-1 bg-white shadow rounded border p-2" draggable="true">
                                        <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700 cursor-pointer transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                        </svg>
                                        <div class="w-full flex justify-between">
                                            <div class="">{{ subcategory.name }}</div>
                                            <div class="flex justify-center items-center cursor-pointer text-green-600" @click="addNewCategory(subcategory.id, subcategory.name)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="mb-8 ml-4 md:ml-8 hidden relative py-4">
                                        <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="mb-4 relative">
                                            <div class="flex gap-1 bg-white shadow rounded border px-2 py-1" draggable="true">
                                                <div>{{ subcategory.name }}</div>
                                            </div>
                                            <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-10 -top-4 border-l-2 border-b-2 rounded-bl-3xl"></div>
                                        </li>
                                        <div class="absolute -left-2 md:-left-4 top-0 bottom-16 border-l-2"></div>
                                    </ul>
                                    <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-10 -top-4 border-l-2 border-b-2 rounded-bl-3xl"></div>
                                </li>
                                <div class="absolute -left-2 md:-left-4 top-0 bottom-16 border-l-2"></div>
                            </ul>
                            <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-10 -top-4 border-l-2 border-b-2 rounded-bl-3xl"></div>
                        </li>
                        <div class="absolute -left-2 md:-left-4 top-0 bottom-16 border-l-2"></div>
                    </ul>
                </li>
            </ul>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import GoToList from '@/Components/GoToList.vue';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        GoToList,
        Button,
        Input,
        Label,
    },
    props: {
        categories: {
            type: Object,
            default: {}
        }
    },
    updated() {
        this.openForm = false;
        this.parentName = '';
        this.form.name = '';
        this.form.parent_id = 0;
    },
    methods: {
        itemClickHandler(event) {
            const category = event.target.closest('.parent');

            const subcategoryContainer = category.nextElementSibling;

            if(subcategoryContainer) {
                subcategoryContainer.classList.toggle('hidden');
            }

            category.firstElementChild.classList.toggle('rotate-180');
        },
        submit() {
            return this.form.post(this.route('categories.store'));
        },
        addNewCategory(parentId = 0, parentName = '') {
            this.openForm = true;
            this.form.parent_id = parentId;
            this.parentName = parentName;
        },
    },
    data() {
        return {
            openForm: false,
            parentName: '',
            form: this.$inertia.form({
                name: '',
                parent_id: 0,
            })
        }
    },
}
</script>