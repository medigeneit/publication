<template>
    <Head title="Distributor" />

    <app-layout>
        <template #header>
            Edit Distributor
        </template>
        
        <form-component :data="{ distributor, distributorType }" module-action="update" />
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
        distributor: { type: Object, default: {} },
        distributorType : {type: Object, default: {}},
    },
};
</script>
