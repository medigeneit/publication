<template>
    <Head title="Moderator" />

    <app-layout>
        <template #header>
            Edit Moderator
        </template>
        
        <form-component :data="{ moderator, moderatorType }" module-action="update" />
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
        moderator: { type: Object, default: {} },
        moderatorType: { type: Object, default: {} },
    },
};
</script>
