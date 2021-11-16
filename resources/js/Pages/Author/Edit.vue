<template>
    <Head title="Author" />

    <app-layout>
        <template #header>
            Edit Author
        </template>
        
        <form-component :author="author" :author-type="authorType" module-action="update" />
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
        author: { type: Object, default: {} },
        authorType: { type: Object, default: {} },
    },
};
</script>
