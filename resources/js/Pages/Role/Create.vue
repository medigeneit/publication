<template>
    <Head title="Account" />

    <app-layout>
        <template #header>
            Create Account
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
                role: this.role,
                permissions: this.permissions,
            }
        }
    },

    props: {
        role: { 
            type: Object,
            default: {}
        },
        permissions: { 
            type: Object,
            default: {}
        },
    },
};
</script>
