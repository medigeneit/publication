<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            Create Distributor
        </template>
        
        <form-component :data="{distribution, distributionType}"  module-action="store" />
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
        distribution: { type: Object, default: {} },
        distributionType : {type: Object, default: {}},
    },
};
</script>
