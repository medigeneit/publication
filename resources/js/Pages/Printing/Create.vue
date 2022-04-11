<template>
    <Head title="Version" />

    <app-layout>
        <template #header> Create Version </template>
        <!-- {{ printing_details_category_keys.values }} -->
        <form-component
            :data="{ 
                printing_details_category_keys,
                printing,
                cost_categories,
                presses
            }"
            module-action="store"
        />
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
      
        printing: {
            type: Object,
            default: {},
        },
        
        printing_details_category_keys: {
            type: Object,
            default: {},
        },

        cost_categories: {
            type: Object,
            default: {},
        },
        presses: {
            type: Object,
            default: {},
        },
    },
};
</script>
