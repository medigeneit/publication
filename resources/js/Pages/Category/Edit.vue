<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            Edit Category
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

    data() {
        return {
            data: {
                category : this.category,
                categoryList: this.categoryList
            }
        }
    },

    props: {
        category: { 
            type: Object, 
            default: {} 
        },
        categoryList: {
            type:Object,
            default: {}
        }
    },
};
</script>
