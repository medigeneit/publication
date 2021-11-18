<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            Edit Storage
        </template>
        
        <form-component :storage="storage" :storageType="storageType" module-action="update" />
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
        storage: { type: Object, default: {} },
        storageType: { type: Object, default: {} },
    },
};
</script>
