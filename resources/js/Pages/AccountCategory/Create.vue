<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            Create User
        </template>
        
        <form-component :data="{ accountCategory, accountCategoryType }" module-action="store" />
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
        accountCategory: { type: Object, default: {} },
        accountCategoryType: { type: Object, default: {} },
    },
};
</script>
