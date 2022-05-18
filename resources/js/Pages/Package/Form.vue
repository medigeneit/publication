<template>
    <div class="w-full flex gap-4">
        <div class="w-full max-w-2xl p-4 bg-white border shadow rounded">

            <ValidationErrors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4">

                    <div class="mb-4 col-span-2">
                        <Label for="name" value="Name" />
                        <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                    </div>
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
                                    <th class="text-left">prices</th>
                                    <!-- <th>Estimation</th> -->
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light bg-white">
                                <tr class="border bg-green-200 border-white" v-for="(product, productId) in selectedProducts" :key="productId" >
                                    <td class="text-left">{{ product.name }}</td>
                                    <td class="text-left">{{ product.cost }}</td>
                                    <td class="text-left">
                                      <div class="py-1.5 flex gap-2 mr-10" v-for="(priceCategory, index) in product.priceCategories" :key="priceCategory">
                                        <div v-if="product.prices[index]">
                                            {{ priceCategory }} : {{ product.prices[index] }}
                                        </div>
                                    </div>
                                    </td>
                                    <td>
                                            <button
                                                class="text-red-500 text-2xl"
                                                @click="removeProduct(productId, 'checkbox', product)"
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
                <div v-if="Object.keys(totalObj).length">
                    <div class="px-4 py-3 text-lg font-bold ">Total</div>
                    <hr>
                    
                    <div class="text-center text-lg"><b> Total Cost: {{ totalCost  }}</b></div>
                    <div class="w-full flex justify-between items-center p-4" >
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="text-gray-600 text-sm font-light bg-white">
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Total</th>
                                    <th class="text-center">Custom</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light bg-white">
                                <tr class="border border-white shadow-sm" v-for="(priceCategory, index) in data.priceCategories" :key="index">
                                    <td class="py-3">
                                        {{ priceCategory }}
                                    </td>
                                    <td class="py-3">
                                        {{ totalObj[priceCategory] ? totalObj[priceCategory] : 0  }}
                                    </td>
                                    <td class="py-3 bg-white rounded">
                                        <div class="text-center">
                                            <Input label="Custom" step="0.01" type="number" v-model="form.prices[index]" class="mt-1" />
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">
            <input placeholder="Search..." @input="searchProduct" class=" px-2 py-2 w-full rounded border border-gray-500 focus:outline-none focus:ring-0"/>
            <div class="mb-4 w-full bg-white border shadow rounded">
                <div class="px-4 py-3 text-lg font-bold">Products</div>
                <hr>

                <div class="w-full flex justify-between items-center p-4" >
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="text-gray-600 text-sm font-light bg-white">
                                <th class="text-left w-full">Name</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light bg-white">
                            <tr class="border" v-for="(product, productId) in data.productList" :key="productId" :class="{'hidden' : form.product_ids.includes(parseInt(productId))}">
                                <td class="w-40">{{ product.name }}</td>
                                <td><Input type="checkbox" class="cursor-pointer checkbox" @change="productSelectHandler(productId)" :checked="product.checked" /></td>
                            </tr>
                        </tbody>
                    </table>
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
        for(const priceCategoryId in this.data.priceCategories) {
            window[this.data.priceCategories[priceCategoryId]] = [];
            // console.log(this.data.priceCategories );
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                type: 1,
                products: [],
                total_cost: 0,
                // total_price:'',
                prices: {},
                active: '',
                // category_ids: this.data.category_ids || [],
                product_ids: this.data.product_ids || [],
                // packageProductPrice: this.data.product_prices || {},
            }),
            categoryShow: false,
            selected: [],
            selectedProducts: [],
            totalObj: {},
            costs: [],
            totalCost: ''
        }
    },

    methods: {

        submit() {
            this.form.total_cost = this.totalCost
            // this.form.total_price = this.totalObj
            // console.log(this.form.prices);
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
            this.form.products.push(product.id)
            console.log("product_idds",this.form.products  );

            if (!product.selected) {
                this.selectedProducts.push({
                    productId: productId,
                    name: product.name,
                    cost: product.productionCost,
                    prices: product.prices,
                    priceCategories: product.priceCategories
                });
            }

            this.totalCalculate(product);

            this.selectedProductHandler();
        },
        totalCalculate(product) {
            let total = 0;
            
            for(let priceCategoryId in product.prices) {
                if(product.prices[priceCategoryId] !== undefined)
                    window[this.data.priceCategories[priceCategoryId]].push(product.prices[priceCategoryId] ? product.prices[priceCategoryId] : 0)

                total =  window[this.data.priceCategories[priceCategoryId]].reduce((a,b) => parseFloat(a) + parseFloat(b));

                this.totalObj[this.data.priceCategories[priceCategoryId]] = total
                this.form.prices[priceCategoryId] = total;
            };

            let cost = product.productionCost ? product.productionCost : 0;
            this.costs.push(cost);
            this.totalCost = this.costs.reduce((a,b) => parseFloat(a) + parseFloat(b));
            console.log(this.totalObj);
            console.log('add');
        },
        removeProduct(numberOfIndex, className, product = null) {
            document.querySelectorAll(`.${className}`).forEach((checkBox) => {
                if(checkBox.checked) {
                    checkBox.checked = false;
                }
            });

            for (const priceCategoryId in product.prices) {
                const index = window[this.data.priceCategories[priceCategoryId]].indexOf(product.prices[priceCategoryId]);
                
                if (index > -1) {
                    
                    window[this.data.priceCategories[priceCategoryId]].splice(index, 1);
                }
                console.log(window[this.data.priceCategories[priceCategoryId]].length)
                this.totalObj[this.data.priceCategories[priceCategoryId]]=  parseInt(this.totalObj[this.data.priceCategories[priceCategoryId]]) - parseInt(product.prices[priceCategoryId]);
                // this.totalObj[this.data.priceCategories[priceCategoryId]]=  window[this.data.priceCategories[priceCategoryId]].reduce((a,b) => parseFloat(a) + parseFloat(b));
                this.form.prices[priceCategoryId] = this.totalObj[this.data.priceCategories[priceCategoryId]];
            }
            
            const indexCost = this.costs.indexOf(product.cost);
            this.costs.splice(indexCost, 1);
            
            let sum = 0;
            this.costs.forEach((a)=> {
                sum += parseFloat(a);
            })
            this.totalCost = sum;
            // this.totalCost = this.costs.reduce((a,b) => parseFloat(a) + parseFloat(b));
            
            const indexProduct =  this.form.products.indexOf(product.id);
            this.form.products.splice(indexProduct,1);

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
