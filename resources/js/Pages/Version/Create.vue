<template>
    <Head title="Version" />

    <app-layout>
        <template #header> Create Version </template>

        <form-component
            :data="{
                version,
                productionList,
                productList,
                versionType,
                product_ids,
                authors,
                moderatorTypes
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
        version: {
            type: Object,
            default: {},
        },
        versionType: {
            type: Object,
            default: {},
        },
        productionList: {
            type: Object,
            default: {},
        },
        productList: {
            type: Object,
            default: {},
        },
        product_ids: {
            type: Array,
            default: [],
        },
        authors: {
            type: Array,
            default: [],
        },
        moderatorTypes: {
            type: Array,
            default: [],
        },
        // categories: {
        //     type: Object,
        //     default: {}
        // },
    },
};
</script>
