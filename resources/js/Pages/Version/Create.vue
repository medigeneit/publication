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
                moderatorTypes,
                presses,
                printing_details_category_keys,
                printingDetails
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
            type: Object,
            default: {},
        },
        moderatorTypes: {
            type: Object,
            default: {},
        },
        presses: {
            type: Object,
            default: {},
        },
        printing_details_category_keys: {
            type: Array,
            default: [],
        },
        printingDetails: {
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
