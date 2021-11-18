<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
            </div>

            <div class="mb-4">
                <Label for="parent" value="Parent" />
                <Select id="parent" class="mt-1 block w-full" v-model="form.parent_id">
                    <option value="0"> -- Select Parent -- </option>
                    <option :value="categoryId" v-for="(categoryName, categoryId) in data.categoryList" :key="categoryId">{{ categoryName }}</option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="active" value="Active" />
                <Select id="select" name="active" class="mt-1 block w-full" v-model="form.active" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
            </div>

            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('categories.index')"/>
                </div>
                <Button class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ buttonValue }}
                </Button>
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

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
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

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.category.name,
                parent_id: this.data.category.parentId || 0,
                active: this.moduleAction == 'store' ? 1 : this.data.category.active,
            })
        }
    },

    methods: {
        submit() {
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
