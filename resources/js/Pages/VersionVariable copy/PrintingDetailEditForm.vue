<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded mb-4">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mb-4">
                <div>
                    <Label  for="name" value="Subcategory Name" />
                    <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                </div>
                {{ data.printingDetailsCategoryValue.printing_details_category_key_id }}
                <div>
                    <active-input v-model="form.active" />
                </div>
            </div>
            <div class="flex justify-between">
                <slot name="footer">
                    <Link :href="route('version-variables.index')" class="px-2 py-0.5 border rounded bg-red-600 text-white">Cancel</Link>
                </slot>
                <button class="px-2 py-0.5 border rounded bg-blue-600 text-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import ActiveInput from "@/Components/ActiveInput.vue";
import DataTable from "@/Components/DataTable.vue";
import GoToList from "@/Components/GoToList.vue";
import Select from "@/Components/Select.vue";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        Textarea,
        DataTable,
        ActiveInput
    },

    props: {

        moduleAction: String,

        buttonValue: {
            type: String,
            default: "Submit",
        },
        data: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.printingDetailsCategoryValue.name || '',
                printing_details_category_key_id: this.data.printingDetailsCategoryValue.printing_details_category_key_id || '',
                active: this.data.printingDetailsCategoryValue.active || '',
                moduleAction: this.moduleAction
            }),
        };
    },

    methods: {
        submit() {
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("printing-detail-categories.update", this.form.printing_details_category_key_id)
                );
            }
        },
    },
};
</script>
