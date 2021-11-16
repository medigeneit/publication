<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Create Product
        </template>
        
        <form-component :data="data" module-action="store" />
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
    },
};
</script>
