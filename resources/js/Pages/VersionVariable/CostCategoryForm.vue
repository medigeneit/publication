<template>
    <Head title="Press" />

    <app-layout>
        <template #header> Create Press </template>
        <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded mb-4">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mb-4">
                <Label  for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full rounded" v-model="form.name" required />
            </div>
            <!-- <active-input v-model="form.active" /> -->
            <button class="px-2 py-0.5 border rounded bg-blue-600 text-white" type="submit">Submit</button>
        </form>
    </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import Input from "@/Components/Input.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import ActiveInput from "@/Components/ActiveInput.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ValidationErrors,
        Label,
        Button,
        Input,
        ActiveInput
    },
     data() {
        return {
            form:this.$inertia.form({
                name: '',
            }),
        };
    },

    methods:{
        submit() {
            console.log(this.form)
            return this.form.post(this.route("cost-categories.store"));
       },
    }
};
</script>
