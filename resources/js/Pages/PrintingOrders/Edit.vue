<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header>
            Edit Outlet
        </template>
        
        <form-component :outlet="outlet" :outletType="outletType" module-action="update" />
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
        outlet: { type: Object, default: {} },
        outletType: { type: Object, default: {} },
    },
};
</script>
