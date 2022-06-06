<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded mb-4">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mb-4" v-if="parentName">
                <Label for="parent_name" value="Parent Name" />
                <div class="px-3 py-2 border border-gray-300 rounded-md shadow-sm mt-1 block w-full">
                    {{ parentName }}
                </div>
            </div>
            <div class="mb-4">
                <Label v-if="!parentName" for="name" value="Category Name" />
                <Label v-else for="name" value="Subcategory Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
            </div>
            <div class="flex justify-between">
                <slot name="footer">
                    <Link :href="route('categories.index')" class="px-2 py-0.5 border rounded bg-red-600 text-white">
                    Cancel</Link>
                </slot>
                <button class="px-2 py-0.5 border rounded bg-blue-600 text-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import GoToList from '@/Components/GoToList.vue';
import Select from '@/Components/Select.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        Link,
    },
    props: {
        moduleAction: String,
        buttonValue: { 
            type: String,
            default: 'Submit'
        },
        data: {
            type: Object,
            default: {}
        },
    },
    created() {
        this.form.parent_id = this.data.parent.id || 0
    },
    data() {
        return {
            parentName: this.data.parent.name || '',
            form: this.$inertia.form({
                name: '',
                parent_id: this.data.parent.id || 0,
            }),
        }
    },
    methods: {
        submit() {
            return this.form.post(this.route('categories.store'));

            if(this.moduleAction == 'store') {
                return this.form.post(this.route('categories.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('categories.update', this.data.category.id));
            }
        }
    }
};
</script>
