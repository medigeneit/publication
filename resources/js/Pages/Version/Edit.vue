<template>
    <Head title="Version" />

    <app-layout>
        <template #header>
            Edit Version
        </template>
        
        <form-component :data="{ version, versionList, categoryList, publisherList, versionType, versionCategories, categoryVersion, categories, category_ids, version_ids }" module-action="update" />
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
        version: { 
            type: Object, 
            default: {} 
        },
        versionList: {
            type:Object,
            default: {}
        },
        publisherList: {
            type: Object,
            default: {}
        },
        versionList: {
            type: Object,
            default: {}
        },
        categoryList: {
            type: Object,
            default: {}
        },
        categories: {
            type: Object,
            default: {}
        },
        category_ids: {
            type: Array,
            default: []
        },
        version_ids: {
            type: Array,
            default: []
        },
        versionCategories: {
            type: Object,
            default: {}
        },
        categoryVersion: {
            type: Object,
            default: {}
        },
        versionType: { 
            type: Object, 
            default: {} 
        },
    }, 
};
</script>
