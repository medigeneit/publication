<template>
    <div v-if="! mainParent" class="absolute -left-2 md:-left-4 top-0 bottom-16 border-l-2"></div>
    <li v-for="(item, index) in collection" :key="index" class="mb-4 relative">
        <div v-if="! mainParent" class="absolute -left-2 md:-left-4 w-2 md:w-4 h-10 -top-4 border-l-2 border-b-2 rounded-bl-3xl"></div>
        <div class="parent flex items-center bg-white shadow rounded border p-2" draggable="true">
            <div v-if="! lastChild">
                <svg v-if="item.subcategories.length" @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                </svg>
            </div>
            <div class="w-full flex justify-between">
                <div class="px-2">{{ item.name }}</div>
                <div v-if="! lastChild" class="flex justify-center items-center cursor-pointer text-green-600" @click="addNewSubcategory(item.id, item.name)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <ul v-if="item.subcategories.length" class="mb-2 ml-4 md:ml-8 hidden relative py-4">
            <slot :item="item" />
        </ul>
    </li>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Input from '@/Components/Input.vue';

export default {
    components: {
        Link,
        Input,
    },
    props: {
        collection: {
            type: Object,
            default: {}
        },
        mainParent: {
            type: Boolean,
            default: false,
        },
        lastChild: {
            type: Boolean,
            default: false,
        },
        addNewSubcategory: Function,
    },
    data() {
        return {
        }
    },
    methods: {
        itemClickHandler(event) {
            const category = event.target.closest('.parent');

            const subcategoryContainer = category.nextElementSibling;

            if(subcategoryContainer) {
                subcategoryContainer.classList.toggle('hidden');
            }

            category.firstElementChild.firstElementChild.classList.toggle('rotate-180');
        },
    }

}
</script>