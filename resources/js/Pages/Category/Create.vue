<template>
    <Head title="Category" />

    <app-layout>
        <template #header>
            Create Category
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
                category: this.category,
                parent: this.parent,
            }
        }
    },

    props: {
        category: { 
            type: Object,
            default: {}
        },
        parent: {
            type: Object,
            default: {},
        }
    },
};
</script>
