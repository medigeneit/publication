<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Create Product
        </template>
        
        <form-component :data="{ product, productList, categoryList, publisherList, productList, productType, productCategories, categoryProduct }" module-action="store" />
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

    data() {
        return {
            data: {
                product: this.product,
                productList: this.productList,
                publisherList: this.publisherList,
                categoryList: this.categoryList,
                categoryProduct: this.categoryProduct,
                productType: this.productType
            }
        }
    },

    props: {
        product: { 
            type: Object,
            default: {}
        },
        productList: {
            type: Object,
            default: {}
        },
        publisherList: {
            type: Object,
            default: {}
        },
        productList: {
            type: Object,
            default: {}
        },
        categoryList: {
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
