<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Edit Product
        </template>
        
        <form-component :data="data" module-action="update" />
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
        data: { 
            type: Object, 
            default: {} 
        },
    }, 
};
</script>
