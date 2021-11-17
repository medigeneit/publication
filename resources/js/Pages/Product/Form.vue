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
                <Select name="type" class="mt-1 block w-full" v-model="form.type" required>
                     <option value="0"> -- Select Type -- </option>
                    <option :value="type" v-for="(typeName, type) in data.productType" :key="type">{{ typeName }}</option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="publisher_id" value="Publisher Name" />
                <Select id="publisher_id" class="mt-1 block w-full" v-model="form.publisher_id">
                    <option value="0"> -- Select Publisher -- </option>
                    <option :value="publisherId" v-for="(publisherName, publisherId) in data.publisherList" :key="publisherId">
                        {{ publisherName }}
                    </option>
                </Select>
            </div>

            <!-- <div class="mb-4">
                <Label for="category_id" value="Category" />
                <Select id="category_id" class="mt-1 block w-full" v-model="form.category_id">
                    <option value="0"> -- Select Category -- </option>
                    <option :value="categoryId" v-for="(categoryName, categoryId) in data.categoryList" :key="categoryId">
                        {{ categoryName }}
                    </option>
                </Select>
            </div> -->

            <div class="mb-4">
                <Label for="mrp" value="MRP ." />
                <Input id="mrp" name="mrp" type="number" step="0.01" class="mt-1 block w-full" v-model="form.mrp" required />
            </div>

            <div class="mb-4">
                <Label for="production_cost" value="Production Cost" />
                <Input id="production_cost" name="production_cost" type="number" step="0.01" class="mt-1 block w-full" v-model="form.production_cost" required />
            </div>

            <div class="mb-4">
                <Label for="wholesale" value="Wholesale Rate" />
                <Input id="wholesale" name="wholesale_rate" step="0.01" type="number" class="mt-1 block w-full" v-model="form.wholesale_rate" required />
            </div>

            <div class="mb-4">
                <Label for="retail_rate" value="Retail Rate" />
                <Input id="retail_rate" name="retail_rate" type="number" step="0.01" class="mt-1 block w-full" v-model="form.retail_rate" required />
            </div>

            <div class="mb-4">
                <Label for="alert_quantity" value="Alert Quantity" />
                <Input id="alert_quantity" name="alert_quantity" type="number" class="mt-1 block w-full" v-model="form.alert_quantity" required />
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
                type: this.data.product.type || 0,
                publisher_id: this.data.product.publisher_id || 0,
                // category_id: this.data.product.category_id || 0,
                production_cost: this.data.product.production_cost,
                mrp: this.data.product.mrp,
                wholesale_rate: this.data.product.wholesale_rate,
                retail_rate: this.data.product.retail_rate,
                alert_quantity: this.data.product.alert_quantity
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
