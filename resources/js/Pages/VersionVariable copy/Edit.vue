<template>
    <Head title="Press" />

    <app-layout>
        <template #header> Edit Press </template>

        <form-component :data="{ printingDetailsCategoryValue }" module-action="update" />
        <!-- <form-component :data="{ printingDetailsCategoryValue, parent }" module-action="update" /> -->
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
// import FormComponent from "./PrintingDetailEditForm.vue";
import FormComponent from "./Form.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        FormComponent,
    },

    props: {
        printingDetailsCategoryValue: {
            type: Object,
            default: {},
        },
       
    },
};
</script>
