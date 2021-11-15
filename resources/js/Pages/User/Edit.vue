<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            Edit User
        </template>
        
        <form-component :user="user" :user-type="userType" module-action="update" />
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
        user: { type: Object, default: {} },
        userType: { type: Object, default: {} },
    },
};
</script>
