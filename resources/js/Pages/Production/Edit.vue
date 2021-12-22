<template>
    <Head title="Production" />

    <app-layout>
        <template #header>
            Edit Production
        </template>
        
        <form-component :data="{ production }" module-action="update" />
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
        production: { type: Object, default: {} },
    },
};
</script>
