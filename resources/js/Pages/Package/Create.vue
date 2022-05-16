<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Create Product
        </template>

        <form-component :data="{productList, priceCategories}" module-action="store" />
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
        productList: {
            type: Object,
            default: {}
        },
        priceCategories: {
            type: Object,
            default: {}
        },
    },

    // data() {
    //     return {
    //         data: {
    //             productList : this.productList,
    //         }
    //     }
    // }
};
</script>
