<template>
    <Head title="Author" />

    <app-layout>
        <template #header>
            Edit Author
        </template>
        
        <form-component :data="{ author, ModeratorType }" module-action="update" />
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
        ModeratorType: { type: Object, default: {} },
    },
};
</script>
