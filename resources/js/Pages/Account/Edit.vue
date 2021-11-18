<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            Edit Account
        </template>
        
        <form-component :account="account" :publishers="publishers" module-action="update" />
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
        account: { 
            type: Object,
            default: {}
        },
        publishers: { 
            type: Object,
            default: {}
        },
    },
};
</script>
