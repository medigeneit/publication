<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Edit Product
        </template>
        
        <form-component :data="{proPackage,productList, priceCategories, total_costs}" module-action="update" />
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
        proPackage: { 
            type: Object, 
            default: {} 
        },
        productList: { 
            type: Object, 
            default: {} 
        },
        priceCategories: { 
            type: Object, 
            default: {} 
        },
        total_costs: { 
            type: Object, 
            default: {} 
        },
    }, 
};
</script>
