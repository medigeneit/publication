<template>
    <Head title="Price Category" />

    <app-layout>
        <template #header>
            Create Price Category 
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
                priceCategory: this.priceCategory,
                types: this.types,
            }
        }
    },

    props: {
        priceCategory: { 
            type: Object,
            default: {}
        },
        types: { 
            type: Array,
            default: []
        }
    },
};
</script>
