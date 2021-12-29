<template>
    <div class="w-full flex gap-4">
        <div class="w-full max-w-2xl p-4 bg-white border shadow rounded">

            <ValidationErrors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4">
                    <div class="mb-4 col-span-2">
                        <Label for="type" value="Type" />
                        <Select name="type" class="mt-1 block w-full" @change="typeChange(parseInt(form.type))" v-model="form.type" required disabled>
                            <option value=""> -- Select Type -- </option>
                            <option :value="type" v-for="(typeName, type) in data.productType" :key="type">{{ typeName }}</option>
                        </Select>
                    </div>

                    <div class="mb-4 col-span-2">
                        <Label for="name" value="Name" />
                        <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                    </div>

                    <div class="mb-4 col-span-2">
                        <Label for="category_id" value="Category" />
                        <button type="button" class="mt-1 block w-full px-3 py-2 border rounded bg-gray-600 text-white" @click="categoryShow = !categoryShow">
                            {{ form.category_ids.length || 0 }} selected | Show Categories
                        </button>
                    </div>

                    <div class="mb-4">
                        <Label for="active" value="Active" />
                        <Select id="active" name="active" class="mt-1 block w-full" v-model="form.active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </Select>
                    </div>

                    <div class="mb-4">
                        <Label for="production_cost" value="Production Cost" />
                        <Input id="production_cost" name="production_cost" type="number" step="0.01" class="mt-1 block w-full" v-model="form.production_cost" required />
                    </div>

                    <div class="mb-4 col-start-1">
                        <Label for="mrp" value="MRP ." />
                        <Input id="mrp" name="mrp" type="number" step="0.01" class="mt-1 block w-full" v-model="form.mrp" required />
                    </div>

                    <div class="mb-4">
                        <Label for="distribute_price" value="Distribute Price" />
                        <Input id="distribute_price" name="distribute_price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.distribute_price" required />
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
        <div class="w-full max-w-md" v-if="categoryShow">
            <div class="mb-4 w-full bg-white border shadow rounded">
                <div class="px-4 py-3 text-lg font-bold">Category &amp; Subcategory</div>
                <hr>
                <div class="p-4">
                    <ul class="">
                        <li v-for="(category, index) in data.categories" :key="index" class="my-1 relative">
                            <div class="parent flex items-center gap-1 shadow rounded border p-2" :class="{ 'bg-green-200' : form.category_ids.includes(category.id), 'bg-white' : form.category_ids.includes(category.id) }" draggable="true" >
                                <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform" :class="{'text-blue-700' : category.subcategories.length, 'text-gray-300' : !(category.subcategories.length)}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                </svg>
                                <!-- <div class="h-6 w-6 text-blue-700 cursor-pointer border border-blue-700 rounded-full flex justify-center items-center" @click="itemClickHandler" > {{ category.subcategories.length  }}</div> -->
                                <div class="w-full flex justify-between items-center">
                                    <div class="">{{ category.name }}</div>
                                    <Input type="checkbox" class="cursor-pointer" @change="categorySelectHandler(category.id)" :checked="form.category_ids.includes(category.id)" />
                                </div>
                            </div>
                            <ul class="ml-4 md:ml-8 relative">
                                <li v-for="(subcategory, index) in category.subcategories" :key="index" class="my-1 relative">
                                    <div class="parent flex items-center gap-1 bg-white shadow rounded border p-2" :class="{ 'bg-green-200' : form.category_ids.includes(subcategory.id), 'bg-white' : form.category_ids.includes(subcategory.id) }" draggable="true">
                                        <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform" :class="{'text-blue-700' : subcategory.subcategories.length, 'text-gray-300' : !(subcategory.subcategories.length)}"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                        </svg>
                                        <div class="w-full flex justify-between items-center">
                                            <div class="">{{ subcategory.name }}</div>
                                            <Input type="checkbox" class="cursor-pointer" @change="categorySelectHandler(subcategory.id)" :checked="form.category_ids.includes(subcategory.id)" />
                                        </div>
                                    </div>
                                    <ul class="ml-4 md:ml-8 relative">
                                        <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="my-1 relative">
                                            <div class="parent flex items-center gap-1 bg-white shadow rounded border p-2" :class="{ 'bg-green-200' : form.category_ids.includes(subcategory.id), 'bg-white' : form.category_ids.includes(subcategory.id) }" draggable="true">
                                                <svg @click="itemClickHandler" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer transform" :class="{'text-blue-700' : subcategory.subcategories.length, 'text-gray-300' : !(subcategory.subcategories.length)}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                                </svg>
                                                <div class="w-full flex justify-between items-center">
                                                    <div class="">{{ subcategory.name }}</div>
                                                    <Input type="checkbox" class="cursor-pointer" @change="categorySelectHandler(subcategory.id)" :checked="form.category_ids.includes(subcategory.id)" />
                                                </div>
                                            </div>
                                            <ul class="ml-4 md:ml-8 relative">
                                                <li v-for="(subcategory, index) in subcategory.subcategories" :key="index" class="my-1 relative">
                                                    <div class="w-full flex justify-between items-center gap-1 bg-white shadow rounded border p-2" :class="{ 'bg-green-200' : form.category_ids.includes(subcategory.id), 'bg-white' : form.category_ids.includes(subcategory.id) }" draggable="true">
                                                        <div>{{ subcategory.name }}</div>
                                                        <Input type="checkbox" class="cursor-pointer" @change="categorySelectHandler(subcategory.id)" :checked="form.category_ids.includes(subcategory.id)" />
                                                    </div>
                                                    <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-7 -top-1 border-l-2 border-b-2 rounded-bl-3xl"></div>
                                                </li>
                                                <div class="absolute -left-2 md:-left-4 -top-1 bottom-11 border-l-2"></div>
                                            </ul>
                                            <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-7 -top-1 border-l-2 border-b-2 rounded-bl-3xl"></div>
                                        </li>
                                        <div class="absolute -left-2 md:-left-4 -top-1 bottom-11 border-l-2"></div>
                                    </ul>
                                    <div class="absolute -left-2 md:-left-4 w-2 md:w-4 h-7 -top-1 border-l-2 border-b-2 rounded-bl-3xl"></div>
                                </li>
                                <div class="absolute -left-2 md:-left-4 -top-1 bottom-11 border-l-2"></div>
                            </ul>
                        </li>
                    </ul>    
                </div>    
            </div>
        </div>
        <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">
            <input placeholder="Search..." @input="searchProduct" class=" px-2 py-2 w-full rounded border border-gray-500 focus:outline-none focus:ring-0"/>
            <div class="mb-4 w-full bg-white border shadow rounded">
                <div class="px-4 py-3 text-lg font-bold">Products</div>
                <hr>

                <div class="w-full flex justify-between items-center p-4" >
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="text-gray-600 text-sm font-light bg-white">
                                <th class="text-left">Name</th>
                                <th class="text-left">Cost</th>
                                <th>Mrp</th>
                                <!-- <th>Estimation</th> -->
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light bg-white">
                            <tr class="border" v-for="(product, productId) in data.productList" :key="productId" :class="{'hidden' : form.product_ids.includes(parseInt(productId))}">
                                <td class="w-40">{{ product.name }}</td>
                                <td>{{ product.production_cost }}</td>
                                <td>{{ product.mrp }}</td>
                                <!-- <td>
                                    <input type="number" class="cursor-pointer w-20 ml-auto text-center" v-model="form.packageProductPrice[product.id]" >
                                </td> -->
                                <!-- <td><Input type="checkbox" class="cursor-pointer" @change="productSelectHandler(productId)" :checked="form.product_ids.includes(parseInt(product.id))" /></td> -->
                                <td><Input type="checkbox" class="cursor-pointer checkbox" @change="productSelectHandler(productId)" :checked="product.checked" /></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>

                <div v-if="selectedProducts.length > 0">
                    <div class="px-4 py-3 text-lg font-bold ">Selected Products ( {{ form.product_ids.length }} )</div>
                    <hr>
                    <div class="w-full flex justify-between items-center p-4" >
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="text-gray-600 text-sm font-light bg-white">
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Cost</th>
                                    <th>Mrp</th>
                                    <!-- <th>Estimation</th> -->
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light bg-white">
                                <tr class="border bg-green-200 border-white" v-for="(product, productId) in selectedProducts" :key="productId" >
                                    <td class="w-40">{{ product.name }}</td>
                                    <td>{{ product.cost }}</td>
                                    <td>{{ product.mrp }}</td>
                                    <!-- <td>
                                        <input type="number" class="cursor-pointer w-20 ml-auto text-center" v-model="form.packageProductPrice[product.id]" >
                                    </td> -->
                                    <td>
                                            <button
                                                class="text-red-500 text-2xl"
                                                @click="removeProduct(productId, 'checkbox')"
                                                type="button"
                                            >
                                                &times;
                                            </button>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>
        </div>
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
    created() {
        let products = [];
        for (let product of this.form.product_ids) {
            products.push(this.data.productList[product]);
        }
        this.selectedProducts= products || []
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.product.name,
                type: 1,
                product_id: this.data.product.id || '',
                production_cost: this.data.product.production_cost,
                mrp: this.data.product.mrp,
                wholesale_price: this.data.product.wholesale_price,
                retail_price: this.data.product.retail_price,
                distribute_price: this.data.product.distribute_price,
                special_price: this.data.product.special_price,
                outside_dhaka_price: this.data.product.outside_dhaka_price,
                ecom_distribute_price: this.data.product.ecom_distribute_price,
                ecom_wholesale_price: this.data.product.ecom_wholesale_price,
                active: this.moduleAction == 'store' ? 1 : this.data.product.active,
                category_ids: this.data.category_ids || [],
                product_ids: this.data.product_ids || [],
                packageProductPrice: this.data.product_prices || {},
            }),
            categoryShow: false,
            selected: [],
            selectedProducts: [],
        }
    },

    methods: {

        typeChange(type) {
            console.log(this.data.product.type === 1)
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
                return this.form.post(this.route('packages.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('packages.update', this.data.product.id));
            }
        },

        itemClickHandler(event) {
            const category = event.target.closest('.parent');

            const subcategoryContainer = category.nextElementSibling;

            if(subcategoryContainer) {
                subcategoryContainer.classList.toggle('hidden');
            }

            category.firstElementChild.classList.toggle('rotate-180');
        },

        categorySelectHandler(categoryId) {
            categoryId = parseInt(categoryId);

            if (this.form.category_ids.includes(categoryId)) {
                this.form.category_ids.splice(this.form.category_ids.indexOf(categoryId), 1);
            } else {
                this.form.category_ids.push(categoryId);
            }
        },
        
        productSelectHandler(productId) {
            productId = parseInt(productId);

            if (this.form.product_ids.includes(productId)) {
                this.form.product_ids.splice(this.form.product_ids.indexOf(productId), 1);
            } else {
                this.form.product_ids.push(productId);
            }
            let product = this.data.productList[productId];
            
            if (!product.selected) {
                this.selectedProducts.push({
                    productId: productId,
                    name: product.name,
                    cost: product.production_cost,
                    mrp: product.mrp
                });
            }
            this.selectedProductHandler();
        },
        removeProduct(numberOfIndex, className) {
            document.querySelectorAll(`.${className}`).forEach((checkBox) => {
                if(checkBox.checked) {
                    checkBox.checked = false;
                }
            });

            this.selectedProducts.splice(numberOfIndex, 1);
            this.form.product_ids.splice(numberOfIndex, 1);

            this.selectedProductHandler();
        },
        selectedProductHandler() {
            this.selected = [];

            this.selectedProducts.forEach((selectedProduct) => {
                this.selected.push(selectedProduct.productId);
            });
        },
        searchProduct(event) {
            
            let url = this.route(this.routeName || this.route().current(), {
                selected: this.selected.toString(),
                search: !event.target.value.includes('\\') ? event.target.value : '',
                id : this.data.product.id
            });

            this.$inertia.get(url, {}, { preserveState: true });
        },

        packageProducts() {
            for (let product of this.form.product_ids) {
                return this.data.productList[product]
            }
        }
    }
};
</script>
