<template>
    <div class="w-full flex gap-4">
        <div class="w-full max-w-2xl p-4 bg-white border shadow rounded">

            <ValidationErrors class="mb-4" />
            <form @submit.prevent="submit">
                <div class="mb-4 col-span-2 text-center">
                       <b>
                           <!-- {{ `${data.volume.version.production.name},  ${data.volume.version.edition} edition ( ${data.productable.name} )` }} -->
                           {{ data.product.product_name }}
                       </b>
                </div>
                 <!-- <div class="mb-4 flex justify-center text-center">
                    <div class="">
                        <Label value="Image" />
                        <div class="w-20 h-30 m-auto">
                             <img
                            v-if="data.product.image && !imagePreview"
                            :src="'/' + data.product.image"
                                class="transform scale-75 md:scale-90 imageHolder"
                            />
                            <img
                                v-else
                                :src="'/images/book.png'"
                                class="transform scale-75 md:scale-90 imageHolder"
                            />
                            <img id="imagePreview" class="transform scale-75 md:scale-90" />
                        </div>
                        <input class="mt-1 block w-full" accept="image/*" ref="fileInput" type="file" @change="pickFile">
                    </div>
                </div> -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4">
                    <!-- <div class="mb-4 col-span-2">
                        <Label for="type" value="Type" />
                        <Select name="type" class="mt-1 block w-full" @change="typeChange(parseInt(form.type))" v-model="form.type" required>
                            <option value=""> -- Select Type -- </option>
                            <option :value="type" v-for="(typeName, type) in data.productType" :key="type">{{ typeName }}</option>
                        </Select>
                    </div> -->

                    <!-- <div class="mb-4 col-span-2">
                        <Label for="type" value="Type" />
                        <Select >
                            <option value="">Select Button</option>
                            <option value="1">Volumes</option>
                            <option value="2">Version</option>
                            <option value="3">Package</option>
                        </Select>
                    </div> -->
                    <div class="mb-4 col-span-2">
                        <Label for="soft" value="Soft Copy" />
                        <Input id="soft" type="text" class="mt-1 block w-full" v-model="form.soft" autofocus />
                    </div>
                    <!-- <div class="mb-4 col-span-2">
                        <Label for="name" value="Status" />
                        <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                    </div> -->

                    <!-- <div class="mb-4 col-span-2" id="publisherWrapper" :class="{'hidden' : form.type === 1}">
                        <Label for="publisher_id" value="Publisher Name" />
                        <Select id="publisher_id" class="mt-1 block w-full" v-model="form.publisher_id">
                            <option value=""> -- Select Publisher -- </option>
                            <option :value="publisherId" v-for="(publisherName, publisherId) in data.publisherList" :key="publisherId">
                                {{ publisherName }}
                            </option>
                        </Select>
                    </div>

                    <div class="mb-4 col-span-2" id="productWrapper" :class="{'hidden' : form.type !== 1}">
                        <Label for="product_id" value="Product Name" />
                        <button type="button" class="mt-1 block w-full px-3 py-2 border rounded bg-gray-600 text-white" @click="productShow = !productShow">
                            {{ form.product_ids.length || 0 }} selected | Show Products
                        </button>
                    </div>

                    <div class="mb-4 col-span-2">
                        <Label for="category_id" value="Category" />
                        <button type="button" class="mt-1 block w-full px-3 py-2 border rounded bg-gray-600 text-white" @click="categoryShow = !categoryShow">
                            {{ form.category_ids.length || 0 }} selected | Show Categories
                        </button>
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

                    <div class="mb-4 col-start-1">
                        <Label for="edition" value="Edition" />
                        <Input id="edition" name="edition" type="text" step="0.01" class="mt-1 block w-full" v-model="form.edition" />
                    </div>

                    <div class="mb-4">
                        <Label for="isbn" value="ISBN" />
                        <Input id="isbn" name="isbn" type="text" step="0.01" class="mt-1 block w-full" v-model="form.isbn" />
                    </div>

                    <div class="mb-4">
                        <Label for="crl" value="Crl" />
                        <Input id="crl" name="crl" type="text" step="0.01" class="mt-1 block w-full" v-model="form.crl" />
                    </div>

                    <div class="mb-4">
                        <Label for="production_cost" value="Production Cost" />
                        <Input id="production_cost" name="production_cost" type="number" step="0.01" class="mt-1 block w-full" v-model="form.production_cost" required />
                    </div>

                    <div class="mb-4 col-start-1">
                        <Label for="mrp" value="MRP ." />
                        <Input id="mrp" name="mrp" type="number" step="0.01" class="mt-1 block w-full" v-model="form.mrp" required />
                    </div> -->
                    
                    <div v-for="(priceCategory, index) in data.priceCategories" :key="priceCategory.id">
                        <div class="grid">
                            <div class="block">
                                <Label for="wholesale" v-text="priceCategory.name" />
                                <Input :label="index" v-model="form.amounts[priceCategory.id]" step="0.01" type="number" class="mt-1 block w-full" />
                            </div>
                        </div>
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
        <div class="w-full max-w-md" v-if="productShow">
            <div class="mb-4 w-full bg-white border shadow rounded">
                <div class="px-4 py-3 text-lg font-bold">Products</div>
                <hr>
                <div class="p-2 mb-2 border" v-for="(productName, productId) in data.productList" :key="productId" :class="{ 'bg-green-200' : form.product_ids.includes(parseInt(productId)), 'bg-white' : form.product_ids.includes(parseInt(productId)) }">
                    <div class="w-full flex justify-between items-center" >
                        <div class="">{{ productName }}</div>
                        <Input type="checkbox" class="cursor-pointer" @change="productSelectHandler(productId)" :checked="form.product_ids.includes(parseInt(productId))" />
                    </div>
                </div>    
                <!-- <div class="p-4">
                    Product List  Coming Soon...   
                </div>     -->
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

    data() {
        return {
            form: this.$inertia.form({
                soft: this.data.product.soft,
                priceCategory: this.data.product.priceCategory,
                amounts: {},
                // image : this.data.product.image || null,
                // name: this.data.product.name,
                // type: this.data.product.type || '',
                // publisher_id: this.data.product.publisher_id || '',
                // product_id: this.data.product.id || '',
                // production_cost: this.data.product.production_cost,
                // mrp: this.data.product.mrp,
                // retail_price: this.data.product.retail_price,
                // distribute_price: this.data.product.distribute_price,
                // special_price: this.data.product.special_price,
                // outside_dhaka_price: this.data.product.outside_dhaka_price,
                // ecom_distribute_price: this.data.product.ecom_distribute_price,
                // ecom_wholesale_price: this.data.product.ecom_wholesale_price,
                // edition: this.data.product.edition,
                // isbn: this.data.product.isbn,
                // crl: this.data.product.crl,
                // alert_quantity: this.data.product.alert_quantity,
                // active: this.moduleAction == 'store' ? 1 : this.data.product.active,
                // category_ids: this.data.category_ids || [],
                // product_ids: this.data.product_ids || [],
            }),
            categoryShow: false,
            productShow: false,
        }
    },

    created() {
        for(let index in this.data.selectedPriceCategories) {
            this.form.amounts[index] = this.data.selectedPriceCategories[index] ? this.data.selectedPriceCategories[index] : ''
        }
    },

    methods: {

        pickFile (event) {;
            console.log(document.getElementById('imagePreview'));
            const files = event.target.files || event.dataTransfer.files;
            document.getElementById('imagePreview').src = window.URL.createObjectURL(files[0])
            document.querySelectorAll('.imageHolder').forEach((el)=> {
                el.style.display = 'none'
            })
            
            if (!files.length) {
                return this.form.image = null;
            }
            return this.form.image = files[0];
        },

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
                // return console.log(this.form.amounts)
                return this.form.post(this.route('products.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('products.update', this.data.product.id));
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
        }
    }
};
</script>
