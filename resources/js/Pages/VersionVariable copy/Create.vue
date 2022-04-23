<template>
    <Head title="Press" />

    <app-layout>
        <template #header> Create Press </template>
         <form-component :data="data"  module-action="store" />
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
        printingDetailsCategoryValue: {
            type: Object,
            default: {},
        },
        parent: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
             
            parentName: this.data.parent.name || '',

            form: this.$inertia.form({
                name: '',
                printing_details_category_key_id: this.data.parent.id || 0,
            }),

            columns: [
                { title: "Name", align: "left", sortable: "name" },
            ],

            data: {
                printingDetailsCategoryValue: this.printingDetailsCategoryValue,
                parent: this.parent,
            }
        };
    },

    methods:{
        addPrintingValue() {
            this.form.values.push([]);
        },
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
    }
};
</script>
