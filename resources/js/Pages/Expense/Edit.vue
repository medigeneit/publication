<template>
    <Head title="Expense" />

    <app-layout>
        <template #header>
            Edit Expense
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
                expense: this.expense,
                publishers: this.publishers,
                accountType: this.accountType,
                incomeCategoryList: this.incomeCategoryList,
                expenseCategoryList: this.expenseCategoryList,
            }
        }
    },

    props: {
        expense: { 
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
        expenseCategoryList: { 
            type: Object, 
            default: {} 
        },
    },
};
</script>
