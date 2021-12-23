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
                        234, Sonargaon Road, North Site of Katabon Mor, New
                        Market, Dhaka-1205
                    </p>
                    <p>Mobile: 01404432517, 01404432518</p>
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
                        <Select
                            class="block w-full"
                            v-model="form.price_type"
                            @change="subtotalCalculation"
                        >
                            <option value="">-- Price Type --</option>
                            <option value="1">Retail</option>
                            <option value="2">Distributor</option>
                            <option value="3">Wholesale</option>
                            <option value="4">Special (Genesis)</option>
                        </Select>
                    </div>
                    <div class="w-full flex items-center gap-2">
                        <Select
                            id="outlet_id"
                            class="block w-full"
                            v-model="form.outlet_id"
                        >
                            <option value="">-- Select Salepoint --</option>
                            <option
                                :value="outletId"
                                v-for="(outletName, outletId) in outlets"
                                :key="outletId"
                            >
                                {{ outletName }}
                            </option>
                        </Select>
                    </div>
                    <div class="hidden w-full flex items-center gap-2">
                        <Input type="date" class="block w-full" />
                    </div>
                </div>

                <div class="">
                    <div class="flex gap-2 items-end mb-4">
                        <label for="name">Name</label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.customer_name"
                            class="
                                border-0 border-dotted border-b-2 border-black
                                focus:ring-0 focus:outline-none
                                w-full
                            "
                        />
                    </div>
                    <div class="flex gap-2 items-end mb-4">
                        <label for="address">Address</label>
                        <input
                            id="address"
                            type="text"
                            v-model="form.customer_address"
                            class="
                                border-0 border-dotted border-b-2 border-black
                                focus:ring-0 focus:outline-none
                                w-full
                            "
                        />
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex gap-2 items-end mb-4">
                            <label for="address">Phone</label>
                            <input
                                id="address"
                                type="number"
                                v-model="form.customer_phone"
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
                            <label for="address">Email</label>
                            <input
                                id="address"
                                type="email"
                                v-model="form.email"
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

                <div v-show="form.price_type && form.outlet_id" class="py-2 text-right">
                    <button
                        type="button"
                        @click="showProductList = !showProductList"
                        class="border border-gray-700 px-2 py-1 rounded"
                    >
                        + Add Product
                    </button>
                </div>

                <div
                    v-show="form.price_type && form.outlet_id"
                    class="pb-2 flex flex-col justify-center items-center gap-1"
                >
                    <span
                        v-for="(message, index) of messages"
                        :key="index"
                        class="
                            text-red-600 text-sm
                            bg-red-200
                            px-3
                            py-1
                            rounded
                            inline-flex
                            gap-2
                            items-center
                        "
                    >
                        <span>{{ message }}</span>
                        <span
                            class="text-base cursor-pointer"
                            @click="messages.splice(index, 1)"
                            >&times;</span
                        >
                    </span>
                </div>

                <div class="overflow-auto">
                    <table v-show="form.price_type && form.outlet_id" class="w-full min-w-max">
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
                                    Amount
                                </th>
                                <th
                                    class="text-center px-2 py-2 w-8 border-r"
                                ></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                class="border-b"
                                v-for="(
                                    saleableProduct, index
                                ) in saleableProducts"
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
                                        products[saleableProduct.productId].name
                                    }}
                                </td>
                                <td class="border-r">
                                    <input
                                        v-show="saleableProduct.productId"
                                        type="number"
                                        class="
                                            w-20
                                            ml-auto
                                            text-center
                                            border-0
                                        "
                                        @input="checkQuantity(index)"
                                        v-model="saleableProduct.quantity"
                                    />
                                </td>
                                <td class="text-right px-2 py-1 border-r">
                                    <span v-show="saleableProduct.productId">
                                        {{
                                            saleableProduct.unitPrice[form.price_type]
                                        }}
                                    </span>
                                </td>
                                <td class="text-right px-2 py-1 border-r">
                                    <span v-show="saleableProduct.productId">
                                        {{
                                            saleableProduct.quantity *
                                                saleableProduct.unitPrice[
                                                    form.price_type
                                                ] || 0
                                        }}
                                    </span>
                                </td>
                                <td class="border-r">
                                    <div
                                        class="
                                            flex
                                            justify-center
                                            items-center
                                            py-1
                                        "
                                    >
                                        <button
                                            class="text-red-500 text-2xl"
                                            @click="removeProduct(index)"
                                            type="button"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                        <tfoot>
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
                                    {{ subtotal }}
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
                                    <textarea class="w-full" type="text" rows="3" placeholder="Discount Purpose" v-model="form.discount_purpose"></textarea>
                                </td>
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
                                    Discount
                                </td>
                                <td class="border-b border-r bg-gray-50">
                                    <input
                                        type="number"
                                        class="w-full text-right border-0 px-2"
                                        @input="applyDiscount()"
                                        v-model="discount"
                                    />
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
                    <Button class="" type="submit"> Submit </Button>
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
                    z-50
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
        this.saleableProducts.forEach((saleableProduct) => {
            this.products[saleableProduct.productId] = {
                name: "Bolbona",
                quantity: saleableProduct.quantity,
                unitPrice: saleableProduct.unitPrice,
            };
        });
    },
    props: {
        buttonValue: {
            type: String,
            default: "Submit",
        },
        products: {
            type: Object,
            default: {},
        },
        outlets: {
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
            saleableProducts: [],
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
            }),
            subtotal: 0,
            discount: "",
        };
    },
    methods: {
        selectProductHandler(productId) {
            let product = this.products[productId];

            if (!product.selected) {
                this.saleableProducts.push({
                    productId: productId,
                    quantity: 1,
                    unitPrice: product.unitPrice,
                });
            }

            this.selectedProductHandler();

            this.subtotalCalculation();
        },
        selectedProductHandler() {
            this.selected = [];

            this.saleableProducts.forEach((saleableProduct) => {
                this.selected.push(saleableProduct.productId);
            });
        },
        removeProduct(numberOfIndex) {
            this.saleableProducts.splice(numberOfIndex, 1);

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
            let productId = this.saleableProducts[numberOfIndex].productId;

            if (!productId) {
                return;
            }

            let product = this.products[productId];

            let quantity = this.saleableProducts[numberOfIndex].quantity;

            this.saleableProducts[numberOfIndex].quantity =
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
        },
        subtotalCalculation() {
            let subtotal = 0;

            this.saleableProducts.forEach((saleableProduct) => {
                subtotal +=
                    saleableProduct.unitPrice[this.form.price_type] *
                    saleableProduct.quantity;
            });

            this.subtotal = subtotal;

            this.applyDiscount();
        },
        submit() {
            this.form.products = this.saleableProducts;
            this.form.subtotal = this.subtotal;
            this.form.discount = this.discount;

            return this.form.post(this.route("sales.store"));
        },
    },
};
</script>
