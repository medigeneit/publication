<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <add-new-button :href="route('packages.create')" />

        <data-table :collections="packages" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: pack }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('packages.show', pack.id)" />
                        <action-button-edit :href="route('packages.edit', pack.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ pack.id }}</td>
                <td class="py-3 px-2 text-left">{{ pack.name }}</td>
                <td class="py-3 px-2 text-center">
                    <div v-if="pack.products.length" @click="modalHandler" class="text-center border bg-indigo-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ pack.products.length }} products
                    </div>
                    <div v-if="pack.products.length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">pack products</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(product, index) in pack.products" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500" :href="route('products.show', pack.product_ids[index])">{{ product }}</Link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from '@/Components/AddNewButton.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
    },
    props: {
        packages: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    methods: {
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        }
    },
    data() {
        return {
           columns: [
                    {title: 'Action', align: 'center'},
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Name', align: 'left', sortable: 'name'},
                    {title: 'Products', align: 'left'},
                ],
        }
    },
};
</script>
