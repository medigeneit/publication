<template>

    <Head title="Product" />

    <app-layout>
        <template #header>
            {{ packagePro.name }}
        </template>

        <add-new-button :href="route('packages.create')" class="mb-4" />

        <div class="overflow-auto bg-white border p-5">

            <!-- <h1 class="font-extrabold text-center">{{ packagePro.name }}</h1>
            <div class="text-center" v-if="packagePro.package_products.length">
                <div>
                    Products : {{ packagePro.package_products.length }}
                </div>
                <div>
                    Total Cost : {{ packagePro.total_cost }}
                </div>
            </div>
            <div class="text-center">
                Active :
                <span class="py-1 px-3 rounded-full text-white font-bold"
                    :class="{ 'bg-green-500': packagePro.active, 'bg-red-500': !packagePro.active }">
                    {{ packagePro.activeValue }}
                </span>
            </div>

            <div class="mt-2 text-center">
                <h1 class="underline font-extrabold">Prices</h1>
                
                <div v-for="(price, priceCategory) in packagePro.package_prices" :key="priceCategory">
                    <span>{{ `${priceCategory} : ${price} tk` }}</span>
                </div>
            </div> -->

            <div class="text-center">
                Active :
                <span class="py-1 px-3 rounded-full text-white font-bold"
                    :class="{ 'bg-green-500': packagePro.active, 'bg-red-500': !packagePro.active }">
                    {{ packagePro.activeValue }}
                </span>
            </div>
            <div class="mt-2 w-72 p-5">
                <h1 class="underline font-extrabold mb-5">Package Details:</h1>
                <div class="min-w-max">
                    <div class="text-center mt-3">
                        <div class="font-extrabold">
                            {{ packagePro.name }}
                        </div>
                        <div v-if="packagePro.package_products.length">
                            Products :
                            <span class="font-extrabold">
                                {{ packagePro.package_products.length }}
                            </span>
                        </div>
                        <div v-if="packagePro.total_cost">
                            Total cost :
                            <span class="font-extrabold">
                                {{ packagePro.total_cost }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="w-full" v-for="(price, priceCategory) in packagePro.package_prices"
                        :key="priceCategory">
                        <div class="flex">
                            <div class="w-full">
                                {{ priceCategory }}
                            </div>
                            <div class="min-w-max">
                                {{ `${price} tk` }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 w-72 p-5">
                <h1 class="underline font-extrabold mb-5">Product Details:</h1>
                <div class="min-w-max" v-for="(prices, name) in packagePro.products" :key="name">
                    <div class="text-center font-extrabold mt-3"> {{ name }} </div>
                    <hr>
                    <div class="w-full" v-for="(price, priceCategory) in prices" :key="price">
                        <div class="flex">
                            <div class="w-full">
                                {{ priceCategory }}
                            </div>
                            <div class="min-w-max">
                                {{ `${price} tk` }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('packages.index')" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from '@/Components/GoToList.vue';
import AddNewButton from '@/Components/AddNewButton.vue';

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
        packagePro: { type: Object, default: {} },
        categories: { type: Object, default: {} },
    },
};
</script>
