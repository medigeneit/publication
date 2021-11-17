<template>
    <Head title="Sale" />

    <app-layout>
        <template #header>
            Edit Sale
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
                sale : this.sale,
                saleList: this.saleList
            }
        }
    },

    props: {
        sale: { 
            type: Object, 
            default: {} 
        },
        saleList: {
            type:Object,
            default: {}
        }
    },
};
</script>
