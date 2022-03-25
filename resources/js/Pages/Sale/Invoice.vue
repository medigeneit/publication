<template>
    <Head title="Sale Memo" />

    <app-layout>
        <template #header> Sale Memo </template>

        <div class="flex gap-4">
            <form
                @submit.prevent="submit"
                class="w-full max-w-3xl bg-white p-4 rounded"
            >
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold">BANGLAMED PUBLICATION</h1>
                    <p>All kinds of medical book publications</p>
                    <p>
                        {{ sale.outletAddress }}
                    </p>
                    <p>Mobile: {{ sale.outletPhone }}</p>
                </div>
                <div
                    class="
                        flex flex-col
                        md:flex-row
                        justify-between
                        items-start
                        md:items-center
                        gap-4
                    "
                >
                    <div class="w-full flex items-center gap-2">
                        <div class="w-full flex items-center gap-2">
                            No : <b>{{ sale.id }}</b>
                        </div>
                    </div>
                    <div class="w-56 flex items-center gap-2 text-right">
                        Date : {{ sale.createdAt }}
                    </div>
                </div>

                <div class="">
                    <div class="flex gap-2 items-end mb-4">
                        <label for="name">Name</label>
                        <input
                            id="name"
                            type="text"
                            :value="sale.customerName"
                            class="
                                border-0 border-dotted border-b-2 border-black
                                focus:ring-0 focus:outline-none
                                w-full
                            "
                            required
                        />
                    </div>
                    <div class="flex gap-2 items-end mb-4">
                        <label for="address">Address</label>
                        <input
                            id="address"
                            type="text"
                            :value="sale.customerAddress"
                            class="
                                border-0 border-dotted border-b-2 border-black
                                focus:ring-0 focus:outline-none
                                w-full
                            "
                        />
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex gap-2 items-end mb-4">
                            <label for="address">Email</label>
                            <input
                                id="address"
                                type="email"
                                :value="sale.customerEmail"
                                class="
                                    border-0
                                    border-dotted
                                    border-b-2
                                    border-black
                                    focus:ring-0 focus:outline-none
                                    w-full
                                "
                            />
                        </div>
                        <div class="flex gap-2 items-end mb-4">
                            <label for="address">Phone</label>
                            <input
                                id="address"
                                type="email"
                                :value="sale.customerPhone"
                                class="
                                    border-0
                                    border-dotted
                                    border-b-2
                                    border-black
                                    focus:ring-0 focus:outline-none
                                    w-full
                                "
                            />
                        </div>
                        <div class="flex gap-2 items-end mb-4" v-if="sale.memoType == 3">
                            <label for="address">Course</label>
                            <input
                                id="address"
                                type="text"
                                :value="sale.course"
                                class="
                                    border-0
                                    border-dotted
                                    border-b-2
                                    border-black
                                    focus:ring-0 focus:outline-none
                                    w-full
                                "
                            />
                        </div>
                        <div class="flex gap-2 items-end mb-4" v-if="sale.memoType == 3">
                            <label for="address">Batch</label>
                            <input
                                id="address"
                                type="text"
                                :value="sale.batch"
                                class="
                                    border-0
                                    border-dotted
                                    border-b-2
                                    border-black
                                    focus:ring-0 focus:outline-none
                                    w-full
                                "
                            />
                        </div>
                        <div class="flex gap-2 items-end mb-4" v-if="sale.memoType == 3">
                            <label for="address">Reg</label>
                            <input
                                id="address"
                                type="text"
                                :value="sale.reg"
                                class="
                                    border-0
                                    border-dotted
                                    border-b-2
                                    border-black
                                    focus:ring-0 focus:outline-none
                                    w-full
                                "
                            />
                        </div>
                    </div>
                </div>

                <div class="overflow-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="border-t border-b bg-gray-50">
                                <th
                                    class="
                                        text-center
                                        px-2
                                        py-2
                                        w-8
                                        border-l border-r
                                    "
                                >
                                    SL
                                </th>
                                <th class="text-left px-2 py-2 border-r">
                                    Description
                                </th>
                                <th class="text-right px-2 py-2 w-20 border-r">
                                    Quantity
                                </th>
                                <th class="text-right px-2 py-2 w-24 border-r">
                                    Unit Price
                                </th>
                                <th class="text-right px-2 py-2 w-28 border-r">
                                    Price Type
                                </th>
                                <th class="text-right px-2 py-2 w-28 border-r">
                                    Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                class="border-b"
                                v-for="(
                                    soldProduct, index
                                ) in sale.productDetails"
                                :key="index"
                            >
                                <td
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-r border-l
                                    "
                                >
                                    {{ parseInt(index) + 1 }}
                                </td>
                                <td class="text-left px-2 py-1 border-r">
                                    {{
                                        soldProduct.name
                                    }}
                                </td>
                                <td class="border-r">
                                    <input
                                        
                                        type="number"
                                        class="
                                            w-20
                                            ml-auto
                                            text-center
                                            border-0
                                        "
                                        @input="checkQuantity(index)"
                                        :value="soldProduct.quantity"
                                    />
                                </td>
                                <td class="text-center px-2 py-1 border-r">
                                        {{ soldProduct.priceType }}
                                </td>
                                <td class="text-right px-2 py-1 border-r">
                                        {{ soldProduct.unitPrice }}
                                </td>
                                <td class="text-right px-2 py-1 border-r">
                                   {{ soldProduct.unitPrice * soldProduct.quantity }}
                                </td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td
                                    colspan="2"
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-l border-r
                                        bg-gray-50
                                    "
                                >
                                    Subtotal
                                </td>
                                <td
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50
                                    "
                                >

                                {{ sale.payable + sale.discount }}
                                    <!-- {{ soldProduct.payable + soldProduct.discount }} -->
                                </td>
                                <td
                                    class="
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50
                                    "
                                ></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="px-2 py-1">
                                    <div class="w-full" rows="3" >
                                        {{ sale.discountPurpose }}
                                    </div>
                                </td>
                                <td
                                    colspan="3"
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-l border-r
                                        bg-gray-50
                                    "
                                >
                                    Discount
                                </td>
                                <td class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50"
                                >
                                    {{ sale.discount }}
                                </td>
                                <td
                                    class="
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50
                                    "
                                ></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td
                                    colspan="2"
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-l border-r
                                        bg-gray-50
                                    "
                                >
                                    Payable Amount
                                </td>
                                <td
                                    class="
                                        text-right
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50
                                    "
                                >
                                    {{ subtotal - discount }}
                                </td>
                                <td
                                    class="
                                        px-2
                                        py-1
                                        border-b border-r
                                        bg-gray-50
                                    "
                                ></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div
                    v-show="form.price_type && form.outlet_id"
                    class="flex items-center justify-between mt-4"
                >
                    <div class="">
                        <go-to-list :href="route('sales.index')" />
                    </div>
                    <Button type="button" @click="modalShow = !modalShow">Pay Now</Button>
                    <div class="fixed inset-0 z-50" v-if="modalShow" id="circulationWrapper">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Payment</div>
                                <hr class="my-1">
                                <div class="p-3">
                                        <div class="mb-4">
                                            <div>
                                                Payable
                                                <span class="float-right">{{ payable }}tk.</span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                           <div>
                                                Payment:
                                            <Input id="type" type="number" class="float-right h-10 text-right w-20" v-model="form.paid" @input="paymentCalculation" required/>
                                           </div>
                                           <hr>
                                        </div>

                                        <div class="mb-4">
                                            Due: <span class="float-right">{{ form.due }}tk.</span>
                                        </div>

                                        <div class="mb-4">
                                             <textarea class="w-full" type="text" rows="3" placeholder="Due Condition" v-model="form.due_condition"></textarea>
                                        </div>
                                        

                                        <Button type="submit" class="bg-gray-600 text-white px-2 py-1 rounded mt-2">
                                            Submit
                                        </Button>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="modalShow = false">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-30 z-40">
                                <div class="w-full h-full" @click="modalShow = false"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <ul
                v-if="showProductList"
                class="
                    fixed
                    md:static
                    inset-0
                    overflow-auto
                    w-full
                    max-w-sm
                    rounded
                    border
                    bg-white
                    p-4
                    z-30
                "
            >
                <li class="text-right mb-2">
                    <span
                        class="
                            text-red-500
                            cursor-pointer
                            text-3xl
                            inline-block
                        "
                        @click="showProductList = false"
                    >
                        &times;
                    </span>
                </li>
                <li>
                    <input
                        placeholder="Search..."
                        @input="searchProduct"
                        class="
                            px-2
                            py-2
                            w-full
                            rounded
                            border border-gray-500
                            focus:outline-none focus:ring-0
                        "
                    />
                </li>
                <li
                    class="
                        w-full
                        p-2
                        border-b
                        cursor-pointer
                        flex
                        justify-between
                    "
                    :class="{ hidden: selected.includes(productId) }"
                    v-for="(product, productId) in products"
                    :key="productId"
                    @click="selectProductHandler(productId)"
                >
                    <div class="w-full">
                        {{ product.name }}
                    </div>
                </li>
            </ul>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import Select from "@/Components/Select.vue";
import Button from "@/Components/Button.vue";
import GoToList from "@/Components/GoToList.vue";
import Textarea from '@/Components/Textarea.vue';

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
        Button,
        GoToList,
        Textarea,
    },
    created() {
        this.soldProducts.forEach((soldProduct) => {
            this.products[soldProduct.productId] = {
                name: "",
                quantity: soldProduct.quantity,
                unitPrice: soldProduct.unitPrice,
            };
        });
    },
    props: {
        buttonValue: {
            type: String,
            default: "Submit",
        },
        sale: {
            type: Object,
            default: {},
        },
        products: {
            type: Object,
            default: {},
        },
        outlets: {
            type: Object,
            default: {},
        },
        price_types: {
            type: Object,
            default: {},
        },
        areas: {
            type: Object,
            default: {},
        },
        districts: {
            type: Object,
            default: {},
        },
        divisions: {
            type: Object,
            default: {},
        },
        search: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            soldProducts: [],
            messages: [],
            selected: [],
            showProductList: false,
            form: this.$inertia.form({
                price_type: '',
                customer_name: "",
                customer_address: "",
                customer_phone: "",
                email: "",
                products: [],
                outlet_id: '',
                price_type: '',
                subtotal: 0,
                discount: 0,
                discount_purpose: '',
                memo_type : 1,
                selectedPriceType: [],
                select_price: '',
                // phone: '',
                reg: '',
                area_id: '',
                district_id: '',
                course: '',
                batch: '',
                paid: '',
                due : 0,
                due_condition: ''
            }),
            subtotal: 0,
            selected_subtotal: [],
            regBar: false,
            discount: "",
            selected_price: [],
            customers: {},
            customAreas: {},
            priceTypes: {},
            customers: '',
            modalShow: false,
        };
    },
    created(){
        this.customAreas = this.areas;
        this.priceTypes = Object.values(this.price_types).filter((priceType) => priceType.is_special == 0);
    },
    methods: {
        searchBarHandler() {
            this.form.memo_type== 3 ? (this.regBar = true) : (this.regBar = false);

            let specialPrice = Object.values(this.price_types).filter(
                (priceType) => priceType.is_special == 1
            );
            
            let distributorPrice = Object.values(this.price_types).filter(
                (priceType) => priceType.is_special == 2
            );

            let notSpecialPrice = Object.values(this.price_types).filter(
                (priceType) => priceType.is_special == 0
            );

            // this.priceTypes = this.form.memo_type== 2 ? specialPrice : notSpecialPrice;
            if (this.form.memo_type== 3) {
                this.priceTypes = specialPrice
            } else if(this.form.memo_type== 2) {
                this.priceTypes = distributorPrice
            } else {
                this.priceTypes = notSpecialPrice
            }
            // console.log(specialPrice, notSpecialPrice);
        },
        selectDistrict(event) {
            this.form.area_id = '';
            if (!event.target.value) {
                return (this.customAreas = this.areas);
            }
            let customDistricts =Object.values(this.divisions).find(
               (division)=> Object.values(division.districts).find(
                   (district) => district.id == event.target.value
                )
            ).districts;
            
            return (this.customAreas = Object.values(customDistricts).find(
                (district) => district.id == event.target.value
            ).areas);
        },
        customerSearch(event) {
            // if (event.target.value.length > 2) {
                axios.get('/customer-list',  {
                    params: { 
                        text: event.target.value ? event.target.value : this.form.reg,
                        memo_type:this.form.memo_type
                    }
                })
                .then((response) => {
                    this.customers = response.data;
                    console.log(this.customers);

                })
                .catch((err) => {
                    console.log(err);
                })
            // }
        },
        customerInfo(data) {
            let districts = this.districts
            let district_id = '';
            let area_id = '';

            if (data.district) {
                Object.keys(districts).map(function(key) {
                    if(districts[key] === data.district.name) {
                        district_id = key
                    }
                });
    
                area_id = Object.values(this.customAreas).find(
                    (customArea) => customArea.name == data.upazila.name
                ).id;
            }
            
            
            this.form.customer_name = data.name;
            this.form.customer_phone = data.phone;
            this.form.email = data.email;
            this.form.course = data.course ? data.course : ''
            this.form.batch = data.batch ? data.batch : ''
            this.form.customer_address = data.address ? data.address : ''
            this.form.district_id = district_id;
            this.form.area_id = area_id;
            // let customer = document.getElementById('customers');
            // customer.innerHTML = '';
            this.customers = {}

        },
        priceSave(index) {
            let soldProduct = this.soldProducts[index];

            soldProduct.selected_price_type = this.selected_price[index];
            soldProduct.selected_unit_price = soldProduct.unitPrice[soldProduct.selected_price_type];
            this.selected_subtotal.push(soldProduct.unitPrice[soldProduct.selected_price_type]);
            this.subtotalCalculation();
        },
        selectProductHandler(productId) {
            let product = this.products[productId];
            console.log(product.unitPrice[this.form.price_type])

            if (!product.selected) {
                this.soldProducts.push({
                    productId: productId,
                    quantity: 1,
                    unitPrice: product.unitPrice,
                    selected_price_type: '',
                    selected_unit_price: product.unitPrice[this.form.price_type] ,
                });
            }

            this.selectedProductHandler();

            this.subtotalCalculation();
        },
        selectedProductHandler() {
            this.selected = [];

            this.soldProducts.forEach((soldProduct) => {
                this.selected.push(soldProduct.productId);
            });
        },
        removeProduct(numberOfIndex) {
            this.soldProducts.splice(numberOfIndex, 1);

            this.selectedProductHandler();

            this.subtotalCalculation();
        },
        searchProduct(event) {
            let url = this.route(this.routeName || this.route().current(), {
                selected: this.selected.toString(),
                search: !event.target.value.includes('\\') ? event.target.value: '',
            });

            this.$inertia.get(url, {}, { preserveState: true });
        },
        checkQuantity(numberOfIndex) {
            let productId = this.soldProducts[numberOfIndex].productId;

            if (!productId) {
                return;
            }

            let product = this.products[productId];

            let quantity = this.soldProducts[numberOfIndex].quantity;

            this.soldProducts[numberOfIndex].quantity =
                product.maxQuantity >= quantity
                    ? quantity
                    : product.maxQuantity;

            if (product.maxQuantity < quantity) {
                this.messages.push(
                    `${product.name} has ${product.maxQuantity} copies in stock.`
                );
            }

            this.subtotalCalculation();
        },
        applyDiscount() {
            this.discount > this.subtotal
                ? (this.discount = this.subtotal)
                : "";

            this.discount
                ? (this.discount = parseInt(this.discount))
                : (this.discount = "");

            this.payable = this.subtotal - (this.discount || 0);
            this.form.paid = this.subtotal - (this.discount || 0);
        },
        subtotalCalculation() {
            let subtotal = 0;

            this.soldProducts.forEach((soldProduct) => {
                let price = soldProduct.unitPrice[this.form.price_type]? soldProduct.unitPrice[this.form.price_type] : soldProduct.unitPrice[soldProduct.selected_price_type] ;
                
                subtotal +=
                    price *
                    soldProduct.quantity;
            });

            this.subtotal = subtotal;
            if(!this.subtotal) {
                this.subtotal = 0
            }
            console.log(this.payable);

            this.form.paid = this.subtotal
            this.applyDiscount();
        },
        paymentCalculation() {
           this.form.due =  this.payable -this.form.paid;
        },
        submit() {
            this.form.products = this.soldProducts;
            this.form.subtotal = this.subtotal;
            this.form.discount = this.discount;

            return this.form.post(this.route("sales.store"));
        },
    },
};
</script>
