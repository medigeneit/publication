<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
            </div>

            <div class="mb-4">
                <Label for="type" value="Type" />
                <Select id="type" class="mt-1 block w-full" v-model="form.type">
                    <option value=""> -- Select -- </option>
                    <option value="1"> Book </option>
                    <option value="2"> Package </option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="publisher_id" value="Publisher Name" />
                <Select id="publisher_id" class="mt-1 block w-full" v-model="form.publisher_id">
                    <option value="">-- Select --</option>
                    <option value="1">Saiful Isalm</option>
                    <option value="2">Saif Uddin</option>
                    <!-- <option :v-for="(publisher, index) in publishers" :value="index" :key="index" >{{ publisher }}</option> -->
                </Select>
            </div>

            <div class="mb-4">
                <Label for="author_percentage" value="Author Percentage" />
                <Input id="author_percentage" name="author_percentage" step="0.01" type="number" class="mt-1 block w-full" v-model="form.author_percentage"/>
            </div>

            <div class="mb-4">
                <Label for="mrp" value="MRP ." />
                <Input id="mrp" name="mrp" type="number" step="0.01" class="mt-1 block w-full" v-model="form.mrp" required />
            </div>

            <div class="mb-4">
                <Label for="wholesale" value="Wholesale Price" />
                <Input id="wholesale" name="wholesale_price" step="0.01" type="number" class="mt-1 block w-full" v-model="form.wholesale_price" required />
            </div>

            <div class="mb-4">
                <Label for="retail_price" value="Retail Price" />
                <Input id="retail_price" name="retail_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.retail_price" required />
            </div>

            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('products.index')"/>
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
                name: this.data.product.name,
                type: this.data.product.type,
                publisher_id: this.data.product.publisher_id,
                author_percentage: this.data.product.author_percentage,
                mrp: this.data.product.mrp,
                wholesale_price: this.data.product.wholesale_price,
                retail_price: this.data.product.retail_price,
            })
        }
    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('products.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('products.update', this.data.product.id));
            }
        }
    }
};
</script>
