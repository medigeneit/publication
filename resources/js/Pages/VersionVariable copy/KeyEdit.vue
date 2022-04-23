<template>
    <Head title="Press" />

    <app-layout>
        <template #header> Edit Press </template>
    <form @submit.prevent="submit" class="w-full max-w-7xl space-y-4">
            <div class="w-full flex gap-6">
                <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                    <h3 class="text-lg text-gray-600 font-bold">Version Information</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                    >

                        <div>
                            <Label value="Edition" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.edition"
                            />
                        </div>

                        <div>
                            <Label value="Release Date" />
                            <Input
                                type="date"
                                class="mt-1 block w-full"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
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
        press: {
            type: Object,
            default: {},
        },
    },
};
</script>
