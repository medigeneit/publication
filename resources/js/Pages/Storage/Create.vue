<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            Create Storage
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
                storage: this.storage,
                outlets: this.outlets,
                products: this.products
            }
        }
    },

    props: {
        storage: { type: Object, default: {} },
        // storageType: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        products: { type: Object, default: {} }
    },
};
</script>
