<template>
    <div class="w-full max-w-2xl mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="grid md:grid-cols-2 gap-x-4">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
            </div>

            <div class="mb-4">
                <Label for="type" value="Type" />
                <Select name="type" class="mt-1 block w-full" @change="typeChange(parseInt(form.type))" v-model="form.type" required>
                     <option value="0"> -- Select Type -- </option>
                    <option :value="type" v-for="(typeName, type) in data.productType" :key="type">{{ typeName }}</option>
                </Select>
            </div>

            <div class="mb-4" id="publisherWrapper">
                <Label for="publisher_id" value="Publisher Name" />
                <Select id="publisher_id" class="mt-1 block w-full" v-model="form.publisher_id">
                    <option value="0"> -- Select Publisher -- </option>
                    <option :value="publisherId" v-for="(publisherName, publisherId) in data.publisherList" :key="publisherId">
                        {{ publisherName }}
                    </option>
                </Select>
            </div>

            <div class="mb-4 hidden" id="productWrapper">
                <Label for="product_id" value="Product Name" />
                <Select id="product_id" class="mt-1 block w-full" v-model="form.product_id">
                    <option value="0"> -- Select Product -- </option>
                    <option :value="productId" v-for="(productName, productId) in data.productList" :key="productId">
                        {{ productName }}
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
                <Label for="wholesale" value="Wholesale Price" />
                <Input id="wholesale" name="wholesale_price" step="0.01" type="number" class="mt-1 block w-full" v-model="form.wholesale_price" required />
            </div>

            <div class="mb-4">
                <Label for="retail_price" value="Retail Price" />
                <Input id="retail_price" name="retail_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.retail_price" required />
            </div>

            <div class="mb-4">
                <Label for="distribute_price" value="Distribute Price" />
                <Input id="distribute_price" name="distribute_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.distribute_price" required />
            </div>

            <div class="mb-4">
                <Label for="special_price" value="Special Price" />
                <Input id="special_price" name="special_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.special_price" required />
            </div>

            <div class="mb-4">
                <Label for="outside_dhaka_price" value="Outside Dhaka Price" />
                <Input id="outside_dhaka_price" name="outside_dhaka_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.outside_dhaka_price" required />
            </div>

            <div class="mb-4">
                <Label for="ecom_distribute_price" value="Ecom. Distribute Price" />
                <Input id="ecom_distribute_price" name="ecom_distribute_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.ecom_distribute_price" required />
            </div>

            <div class="mb-4">
                <Label for="ecom_wholesale_price" value="Ecom. Wholesale Price" />
                <Input id="ecom_wholesale_price" name="ecom_wholesale_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.ecom_wholesale_price" required />
            </div>

            <div class="mb-4">
                <Label for="edition" value="Edition" />
                <Input id="edition" name="edition" type="text" step="0.01" class="mt-1 block w-full" v-model="form.edition" required />
            </div>

            <div class="mb-4">
                <Label for="isbn" value="ISBN" />
                <Input id="isbn" name="isbn" type="text" step="0.01" class="mt-1 block w-full" v-model="form.isbn" required />
            </div>

            <div class="mb-4">
                <Label for="crl" value="Crl" />
                <Input id="crl" name="crl" type="text" step="0.01" class="mt-1 block w-full" v-model="form.crl" required />
            </div>

            <div class="mb-4">
                <Label for="alert_quantity" value="Alert Quantity" />
                <Input id="alert_quantity" name="alert_quantity" type="number" class="mt-1 block w-full" v-model="form.alert_quantity" required />
            </div>

            <div class="mb-4">
                <Label for="active" value="Active" />
                <Select id="active" name="active" class="mt-1 block w-full" v-model="form.active">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
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
                product_id: this.data.product.id || 0,
                // category_id: this.data.product.category_id || 0,
                production_cost: this.data.product.production_cost,
                mrp: this.data.product.mrp,
                wholesale_price: this.data.product.wholesale_price,
                retail_price: this.data.product.retail_price,
                distribute_price: this.data.product.distribute_price,
                special_price: this.data.product.special_price,
                outside_dhaka_price: this.data.product.outside_dhaka_price,
                ecom_distribute_price: this.data.product.ecom_distribute_price,
                ecom_wholesale_price: this.data.product.ecom_wholesale_price,
                edition: this.data.product.edition,
                isbn: this.data.product.isbn,
                crl: this.data.product.crl,
                alert_quantity: this.data.product.alert_quantity,
                active: this.moduleAction == 'store' ? 1 : this.data.product.active
            })
        }
    },

    methods: {

        typeChange(type) {
            let publisherWrapper = document.getElementById('publisherWrapper');
            let productWrapper = document.getElementById('productWrapper');

            if(type === 1) {
                publisherWrapper.classList.add('hidden');
                productWrapper.classList.remove('hidden');
            } else {
                publisherWrapper.classList.remove('hidden');
                productWrapper.classList.add('hidden');
            }
        },

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
