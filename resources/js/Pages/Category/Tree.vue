<template>
    <Head title="Category Tree"/>
    <app-layout>
        <template #header>
            Category Tree
        </template>
        <ul class="ml-4">
            <li v-for="(category, index) in categories" :key="index" class="list-decimal my-2">
                <div class="flex gap-1">
                    <span class="cursor-pointer" @click="itemClickHandler">[+]</span>
                    <span>{{ category.name }}</span>
                </div>
                <ul class="ml-4 hidden">
                    <li v-for="(subcategory, index) in category.subcategories" :key="index" class="list-decimal my-2">
                        <div class="flex gap-1">
                            <span class="cursor-pointer" @click="itemClickHandler">[+]</span>
                            <span>{{ subcategory.name }}</span>
                        </div>
                        <ul class="ml-4 hidden">
                            <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="list-decimal my-2">
                                <div class="flex gap-1">
                                    <span class="cursor-pointer" @click="itemClickHandler">[+]</span>
                                    <span>{{ subcategory.name }}</span>
                                </div>
                                <ul class="ml-4 hidden">
                                    <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="list-decimal my-2">
                                        {{ subcategory.name }}
                                    </li>
                                    <button class="px-2 py-0.5 border rounded bg-gray-600 text-white">+ Add</button>
                                </ul>
                            </li>
                            <button class="px-2 py-0.5 border rounded bg-gray-600 text-white">+ Add</button>
                        </ul>
                    </li>
                    <button class="px-2 py-0.5 border rounded bg-gray-600 text-white">+ Add</button>
                </ul>
            </li>
            <button class="px-2 py-0.5 border rounded bg-gray-600 text-white">+ Add</button>
        </ul>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import GoToList from '@/Components/GoToList.vue';
import Button from '@/Components/Button.vue';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        GoToList,
        Button,
    },
    props: {
        categories: {
            type: Object,
            default: {}
        }
    },
    methods: {
        itemClickHandler(event) {
            const category = event.target;

            const subcategoryContainer = category.parentElement.nextElementSibling;

            if(subcategoryContainer) {
                subcategoryContainer.classList.toggle('hidden');
            }

            category.innerText = category.innerText == '[-]' ? '[+]' : '[-]';
        }
    }
}
</script>