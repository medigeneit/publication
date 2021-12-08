<template>
    <Head title="Income" />

    <app-layout>
        <template #header>
            Edit Income
        </template>
        
        <form-component :data="data" module-action="update" />
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
            data:{
                income: this.income,
                publishers: this.publishers,
                accountType: this.accountType,
                incomeCategoryList: this.incomeCategoryList,
                expenseCategoryList: this.expenseCategoryList,
            }
        }
    },

    props: {
        income: { 
            type: Object,
            default: {}
        },
        publishers: { 
            type: Object,
            default: {}
        },
         accountType: { 
            type: Object, 
            default: {} 
        },
        incomeCategoryList: { 
            type: Object, 
            default: {} 
        },
        expenseCategoryList: { 
            type: Object, 
            default: {} 
        },
    },
};
</script>
