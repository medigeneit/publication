<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Create Product
        </template>
        
        <form-component :data="{ product, productList, publisherList, productType, productCategories }" module-action="store" />
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
        // categoryList: {
        //     type: Object,
        //     default: {}
        // },
        productType: { 
            type: Object, 
            default: {} 
        },
    },
};
</script>
