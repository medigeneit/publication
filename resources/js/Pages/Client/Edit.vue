<template>
    <Head title="Client" />

    <app-layout>
        <template #header>
            Edit Client
        </template>
        
        <form-component :data="{ client, clientType }" module-action="update" />
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
        client: { type: Object, default: {} },
        clientType : {type: Object, default: {}},
    },
};
</script>
