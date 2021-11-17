<template>
    <Head title="outlet" />

    <app-layout>
        <template #header>
            Create outlet
        </template>
        
        <form-component :data="data"  module-action="store" />
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

    data() {
        return {
            data: {
                outlet: this.outlet,
                outletType: this.outletType,
            }
        }
    },

    props: {
        outlet: { type: Object, default: {} },
        outletType: { type: Object, default: {} },
    },
};
</script>
