<template>
    <Head title="Sale Memo" />

    <app-layout>
        <template #header>
            Sale Memo
        </template>
        

        <div class="w-full mx-auto max-w-4xl bg-white p-4 rounded">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold">
                    BANGLAMED PUBLICATION
                </h1>
                <p>All kinds of medical book publications</p>
                <p>234, Sonargaon Road, North Site of Katabon Mor, New Market, Dhaka-1205</p>
                <p>Mobile: 01404432517, 01404432518</p>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <select v-model="priceType">
                        <option value=""> -- Price Type -- </option>
                        <option value="1">Retail</option>
                        <option value="2">Distributor</option>
                        <option value="3">Wholesale</option>
                        <option value="4">Special (Genesis)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label for="">Date:</label>
                    <input type="date" />
                </div>
            </div>

            <div class="">
                <div class="flex gap-2 items-end mb-4">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="border-0 border-dotted border-b-2 border-black focus:ring-0 focus:outline-none w-full" />
                </div>
                <div class="flex gap-2 items-end mb-4">
                    <label for="address">Address</label>
                    <input id="address" type="text" class="border-0 border-dotted border-b-2 border-black focus:ring-0 focus:outline-none w-full" />
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex gap-2 items-end mb-4">
                        <label for="address">Phone</label>
                        <input id="address" type="number" class="border-0 border-dotted border-b-2 border-black focus:ring-0 focus:outline-none w-full" />
                    </div>
                    <div class="flex gap-2 items-end mb-4">
                        <label for="address">Email</label>
                        <input id="address" type="email" class="border-0 border-dotted border-b-2 border-black focus:ring-0 focus:outline-none w-full" />
                    </div>
                </div>
            </div>

            <div class="py-4 flex flex-col justify-center items-center gap-1">
                <span v-for="(message, index) of messages" :key="index" class="text-red-600 text-sm bg-red-200 px-3 py-1 rounded inline-flex gap-2 items-center">
                    <span>{{ message }}</span>
                    <span class="text-base cursor-pointer" @click="messages.splice(index, 1)">&times;</span>
                </span>
            </div>

            <table class="w-full" v-show="priceType">
                <thead>
                    <tr class="border-t">
                        <th class="text-center px-2 py-2 w-8 border-l border-r">SL</th>
                        <th class="text-left px-2 py-2 border-r">Description</th>
                        <th class="text-right px-2 py-2 w-20 border-r">Quantity</th>
                        <th class="text-right px-2 py-2 w-24 border-r">Unit Price</th>
                        <th class="text-right px-2 py-2 w-28 border-r">Amount</th>
                        <th class="text-center px-2 py-2 w-8 border-r"></th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-t" v-for="(saleableProduct, index) in saleableProducts" :key="index">
                        <td class="text-right px-2 py-1 border-r border-l">
                            {{ parseInt(index) + 1 }}
                        </td>
                        <td class="border-r">
                            <select class="w-full border-0" @change="selectProduct(index)" v-model="saleableProduct.productId">
                                <option v-for="(product, productId) in products" :key="productId" :disabled="product.disabled" :value="productId">
                                    {{ product.name }}
                                </option>
                            </select>
                        </td>
                        <td class="text-right border-r">
                            <input v-show="saleableProduct.productId" type="number" class="w-20 ml-auto text-center border-0" @change="checkQuantity(index)" v-model="saleableProduct.quantity">
                        </td>
                        <td class="text-right px-2 py-1 border-r">
                            <span v-show="saleableProduct.productId">
                                {{ saleableProduct.unitPrice[priceType] }}
                            </span>
                        </td>
                        <td class="text-right px-2 py-1 border-r">
                            <span v-show="saleableProduct.productId">
                                {{ (saleableProduct.quantity * saleableProduct.unitPrice[priceType]) || 0 }}
                            </span>
                        </td>
                        <td class="border-r">
                            <div class="flex justify-center items-center py-1">
                                <button class="text-red-500 text-2xl" @click="removeRow(index)">&times;</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td colspan="100" class="py-2 text-right">
                            <button type="button" @click="addNewRow" class="border px-2 py-1 rounded">
                               + Add Item
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from '@/Components/AddNewButton.vue';
import Select from '@/Components/Select.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Input,
        Label,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        Select,
    },
    props: {
        buttonValue: { 
            type: String,
            default: 'Submit'
        },
        productList: {
            type: Object,
            default: {}
        },
    },
    data() {
        return {
            products : this.productList,
            saleableProducts: [],
            priceType: 1,
            messages: [],
        }
    },
    methods: {
        addNewRow() {
            this.saleableProducts.push({
                productId: 0,
                quantity: 1,
                unitPrice: {},
            });

            this.removeSelectedProduct();
        },
        removeRow(numberOfIndex) {
            this.saleableProducts.splice(numberOfIndex, 1);

            this.removeSelectedProduct();
        },
        selectProduct(numberOfIndex) {
            let productId = this.saleableProducts[numberOfIndex].productId;
            
            if(! productId) {
                return this.removeSelectedProduct();
            }

            let product = this.products[productId];

            this.saleableProducts[numberOfIndex].unitPrice = product.unitPrice;

            this.checkQuantity(numberOfIndex);

            this.removeSelectedProduct();
        },
        checkQuantity(numberOfIndex) {
            let productId = this.saleableProducts[numberOfIndex].productId;

            if(! productId) {
                return;
            }

            let product = this.products[productId];

            let quantity = this.saleableProducts[numberOfIndex].quantity;

            this.saleableProducts[numberOfIndex].quantity = (product.maxQuantity >= quantity) ? quantity : product.maxQuantity;

            if(product.maxQuantity < quantity) {
                this.messages.push(`${product.name} has ${product.maxQuantity} copies in stock.`);
            }

        },
        removeSelectedProduct() {
            Object.entries(this.products).forEach((product) => {
                product[1]['disabled'] = false;
            });

            this.products = this.productList;

            this.saleableProducts.forEach((saleableProduct) => {
                let selectedProduct = this.products[saleableProduct.productId];

                selectedProduct ? selectedProduct.disabled = true : '';
            });

            this.products[0]['disabled'] = true;
        }
    }
};
</script>
