<template>
    <Head title="Product" />

    <app-layout>
        {{ $page.status }}
        <template #header>
            {{ product.name }}
        </template>

        <add-new-button :href="route('products.create')" class="mb-4" />

        <div class="overflow-auto bg-white border">
            <div class="flex">
                <div class="mx-auto">
                    <img
                        v-if="product.img"
                        :src="'/' + product.img"
                        class="w-20 h-28 transform scale-75 md:scale-90 imageHolder"
                    />
                    <img
                        v-else
                        :src="'/images/book.png'"
                        class="w-20 h-28 transform scale-75 md:scale-90 imageHolder"
                    />
                </div>
            </div>
            <table class="table-auto">
                <show-table-row heading="ID">{{ product.id }}</show-table-row>
                <show-table-row heading="Name">{{
                    product.name
                }}</show-table-row>
                <show-table-row heading="Type">{{
                    product.typeName
                }}</show-table-row>
                <show-table-row heading="Category">
                    <div
                        v-for="(categoryName, index) of categories"
                        :key="index"
                    >
                        {{ categoryName }}
                    </div>
                </show-table-row>
                <show-table-row heading="Publisher Name">{{
                    product.publisherName ?? ""
                }}</show-table-row>
                <show-table-row heading="Product Cost">{{
                    product.productionCost
                }}</show-table-row>
                <show-table-row heading="MRP ">{{
                    product.mrp
                }}</show-table-row>
                <show-table-row heading="Wholesale Price">{{
                    product.wholesalePrice
                }}</show-table-row>
                <show-table-row heading="Retail Price">{{
                    product.retailPrice
                }}</show-table-row>
                <show-table-row heading="Distribute Price">{{
                    product.distributePrice
                }}</show-table-row>
                <show-table-row heading="Special Price">{{
                    product.specialPrice
                }}</show-table-row>
                <show-table-row heading="Outside Dhaka Price">{{
                    product.outsideDhakaPrice
                }}</show-table-row>
                <show-table-row heading="Ecom. Distribute Price">{{
                    product.ecomDistributePrice
                }}</show-table-row>
                <show-table-row heading="Ecom. Wholesale Price">{{
                    product.ecomWholesalePrice
                }}</show-table-row>
                <show-table-row heading="Edition">{{
                    product.edition
                }}</show-table-row>
                <show-table-row heading="ISBN">{{
                    product.isbn
                }}</show-table-row>
                <show-table-row heading="CRL">{{ product.crl }}</show-table-row>
                <show-table-row heading="Alert Quantity">{{
                    product.alertQuantity
                }}</show-table-row>
                <show-table-row heading="Soft">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-yellow-500': product.soft,
                            'bg-gray-500': !product.soft,
                        }"
                    >
                        {{ product.soft ? "Yes" : "No" }}
                    </span>
                </show-table-row>
                <show-table-row heading="Active">
                    <span
                        class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{
                            'bg-green-500': product.active,
                            'bg-red-500': !product.active,
                        }"
                    >
                        {{ product.activeValue }}
                    </span>
                </show-table-row>
                <show-table-row heading="Created By">{{
                    product.createdBy
                }}</show-table-row>
                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('products.edit', product.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('products.index')" />
        </div>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import GoToList from "@/Components/GoToList.vue";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
    },
    props: {
        product: { type: Object, default: {} },
        categories: { type: Object, default: {} },
    },
};
</script>
