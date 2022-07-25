<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            Create Distributor
        </template>
        
        <form-component :data="data"  module-action="store" />
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
        data: { type: Object, default: {} },
    },
};
</script>
