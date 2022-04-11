<template>
    <Head title="Contributor" />

    <app-layout>
        <template #header>
            Edit Contributor
        </template>
        
        <form-component :data="{ Contributor, ContributionType }" module-action="update" />
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
        Contributor: { type: Object, default: {} },
        ContributionType: { type: Object, default: {} },
    },
};
</script>
