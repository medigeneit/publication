<template>
    <Head title="Press" />

    <app-layout>
        <template #header> Edit Press </template>

            <!-- <div>
                <Label value="Raw Product" />
                <Select
                    class="mt-1 block w-full"
                    v-model="form.production_id"
                    required
                >
                    <option value="">-- Select Production --</option>
                    <option
                        :value="productionId"
                        v-for="(productionName, productionId) in data.productionList"
                        :key="productionId"
                    >
                        {{ productionName }}
                    </option>
                </Select>
            </div> -->

            <div>
                <Label value="Edition" />
                <Input
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                />
            </div>
            <div>
                <Label value="Edition" />
                <Select class="mt-1 block w-full" v-model="form.active">
                    <option value="">-- Select Production --</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>s
                </Select>
            </div>

        {{ printingDetailsCategoryValue.name }}

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

     data() {
        return {
            form: this.$inertia.form({
                name: this.printingDetailsCategoryValue.id || '',
                active: this.printingDetailsCategoryValue.active || '',
            }),
        };
    },

    props: {
        printingDetailsCategoryValue: {
            type: Object,
            default: {},
        },
    },
};
</script>
