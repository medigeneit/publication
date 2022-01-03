<template>
    <Head title="Author Type" />

    <app-layout>
        <template #header>
            Edit Author Type
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
            data:{
                authorType: this.authorType,
            }
        }
    },

    props: {
        authorType: { 
            type: Object,
            default: {}
        }
    },
};
</script>
