<template>
    <Head title="Publisher" />

    <app-layout>
        <template #header> Create Publisher </template>

        <form-component :data="{ publisher }" module-action="store" />
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
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
        publisher: {
            type: Object,
            default: {},
        },
    },
};
</script>
