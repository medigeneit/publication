<template>
    <div v-if="!mainParent" class="absolute -left-2 md:-left-4 -top-1 bottom-11 border-l-2"></div>
    <li v-for="(item, index) in collection" :key="index" class="my-1 relative">
        <div v-if="! mainParent" class="absolute -left-2 md:-left-4 w-2 md:w-4 h-7 -top-1 border-l-2 border-b-2 rounded-bl-3xl"></div>
        <div class="parent flex items-center bg-white shadow rounded border p-2" draggable="true">
            <div v-if="!lastChild">
                <svg v-if="item.values.length" @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform rotate-180 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform rotate-180 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                </svg>
            </div>
            <div class="w-full flex justify-between">
                <div class="px-2">{{ item.name }}</div>
                <div v-if="!lastChild" class="flex justify-center items-center cursor-pointer text-green-600">
                   <!-- <add-new-icon :href="route('printing-detail-categories.create')" @click="addNewSubcategoryHandlar($event, item.id, item.name)"/> -->
                   <div v-if="!lastChild" class="flex">
                        <div v-if="!lastChild" class="flex justify-center items-center cursor-pointer text-green-600" @click="addNewSubcategoryHandlar($event, item.id, item.name)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <action-button-edit :href="route('printing-detail-categories.edit', item.id)" />
                        <action-button-delete :href="route('printing-detail-categories.destroy', item.id)" /> 
                   </div>
                </div>
                <div class="flex" v-if="lastChild">
                    <action-button-edit :href="route('printing-detail-categories.edit', item.id)" />
                    <action-button-delete :href="route('printing-detail-categories.destroy', item.id)" />
                </div>
            </div>
        </div>
        <ul v-show="item.values.length" class="ml-4 md:ml-8 hidden relative">
            <slot :item="item" />
        </ul>
    </li>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Input from '@/Components/Input.vue';
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonDelete from "@/Components/ActionButtonDelete.vue";
import AddNewIcon from '@/Components/AddNewIcon.vue';

export default {
    components: {
        Link,
        Input,
        ActionButtonEdit,
        ActionButtonDelete,
        AddNewIcon
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
        itemClickHandler(event, expand = 'toggle') {
            const category = event.target.closest('.parent');

            const subcategoryContainer = category.nextElementSibling;

            if(! subcategoryContainer) {
                return;
            }

            let method = expand;

            if(expand == 'open') {
                method = 'remove';
            }

            if(expand == 'close') {
                method = 'remove';
            }

            subcategoryContainer.classList[method]('hidden');
            category.firstElementChild.firstElementChild.classList[method]('rotate-180');

        },
        addNewSubcategoryHandlar(event, id, name) {
            this.itemClickHandler(event, 'open');
            this.addNewSubcategory(id, name);
        }
    }

}
</script>