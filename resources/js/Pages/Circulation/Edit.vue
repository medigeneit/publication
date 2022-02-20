<template>
    <Head title="Circulation" />

    <app-layout>
        <template #header>
            Edit Circulation
        </template>
        
        <form-component :data="{ circulation, outlets, products }" module-action="update" />
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
        circulation: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        products: { type: Object, default: {} },
    },
};
</script>
