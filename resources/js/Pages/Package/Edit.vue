<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Edit Product
        </template>
        
        <form-component :data="{ product, productList, categoryList, productType, productCategories, categoryProduct, categories, category_ids, product_ids }" module-action="update" />
    </app-layout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        FormComponent,
    },

    props: {
        product: { 
            type: Object, 
            default: {} 
        },
        productList: {
            type:Object,
            default: {}
        },
        categoryList: {
            type: Object,
            default: {}
        },
        categories: {
            type: Object,
            default: {}
        },
        category_ids: {
            type: Array,
            default: []
        },
        product_ids: {
            type: Array,
            default: []
        },
        productCategories: {
            type: Object,
            default: {}
        },
        categoryProduct: {
            type: Object,
            default: {}
        },
        productType: { 
            type: Object, 
            default: {} 
        },
    }, 
};
</script>
