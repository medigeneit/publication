<template>
    <Head title="Price Category" />

    <app-layout>
        <template #header>
            Create Contributor Type
        </template>
        
        <form-component :data="data" module-action="store" />
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
                ContributionType: this.ContributionType,
            }
        }
    },

    props: {
        ContributionType: { 
            type: Object,
            default: {}
        }
    },
};
</script>
