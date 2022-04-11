<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <!-- <add-new-button :href="route('products.create')" /> -->

        <data-table :collections="products" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: product }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('products.show', product.id)" />
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ product.id }}</td>
                <td class="py-3 px-2 text-left">
                    <b>
                        {{ product.name }}
                    </b>
                </td>
                <td class="py-3 px-2 text-left">
                    {{ product.typeName }}
                </td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': product.active, 'bg-red-500': !product.active }">
                        {{ product.activeValue }}
                    </span>
                </td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-yellow-500': product.soft, 'bg-gray-500': !product.soft }">
                        {{ product.soft ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="product.categoryCount" @click="modalHandler" class="text-center border bg-indigo-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ product.categoryCount }} categories
                    </div>
                    <!-- <div v-else class="text-center border bg-indigo-500 text-white px-2 py-0.5 rounded">
                        {{ product.categoryCount }} categories
                    </div> -->
                    <div v-if="product.categoryCount" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Product Categories</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(category, index) in product.categories" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500" :href="route('categories.show', category.id)">{{ category.name }}</Link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-right">
                    <div v-if="Object.keys(product.prices).length" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ Object.keys(product.prices).length }} Prices
                    </div>
                    <div v-if="Object.keys(product.prices).length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Prices</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2 mr-10" v-for="(priceCategory, index) in product.priceCategories" :key="priceCategory">
                                        <div v-if="product.prices[index]">
                                            <span>{{ index + 1 }}.</span>
                                            {{ priceCategory }} : {{ product.prices[index] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-right">
                    <div v-if="product.moderators.length" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ product.moderators.length }} Moderators
                    </div>
                    <div v-if="product.moderators.length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Pannel</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(moderator, index) in product.moderators" :key="index">
                                        {{ moderator.contributions_type.name }} :   {{ moderator.Contributor.name }}
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-right">
                    <div v-if="product.storages.length" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        Total Quantity :  {{ product.total_storage }}
                        <br>
                       Stored in :  {{ product.storages.length }} outlets
                    </div>
                    <div v-if="product.storages.length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Storage</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(storage, index) in product.storages" :key="index">
                                        <!-- {{ moderator.contributions_type.name }} :   {{ moderator.Contributor.name }} -->
                                        {{ storage.outlet.name }} : {{ storage.quantity || 0 }}
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer" v-if="product.storages.length" @click="modalHandler">
                        Circulation
                    </div>
                    <div class="fixed inset-0 z-50" id="circulationWrapper" :class="{hidden : modalShow}">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Circulation</div>
                                <div class="flex justify-center">
                                    <div>
                                        <label for=""> In </label>
                                        <input type="radio" name="inOut" class="mr-2 checkBox" @click="form.type = 1;changeValue(product.id, product.storage_outlets);" value="1" required>
                                    </div>
                                    <div>
                                        <label for=""> Out </label>
                                        <input type="radio" name="inOut" class="checkBox" value="2"  @click="form.type = 2;changeValue(product.id, product.storage_outlets, product.storages);" required>
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="text-green-800 text-sm font-bold">{{ `Total Quantity : ${product.total_storage}` }}</div>
                                    <form @submit.prevent="submit" class="">
                                        <div class="mb-4">
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" @change="showMessage(product.storages)" required>
                                                <option value="">--From where--</option>
                                                <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId" :class="{'hidden' : !(product.storage_outlets.includes(parseInt(outletsId)))}">
                                                    {{ outletsName }}
                                                </option>
                                            </Select>
                                            <div class="text-green-700">{{ message }}</div>
                                        </div>
                                        <div class="mb-4">
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.to" required @change="changeValue(product.id, product.storage_outlets)">
                                                <option value="">{{ formToLabel }}</option>
                                                <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                            </Select>
                                        </div>

                                        <div class="mb-4">
                                            <Input id="type" type="number" class="mt-1 block w-full" placeholder="Quantity" v-model="form.quantity" required/>
                                        </div>
                                        <div class="mb-4">
                                            <Input id="type" type="number" class="mt-1 block w-full" placeholder="Alert Quantity" v-model="form.alert_quantity" v-if="alertQuantity"/>
                                        </div>

                                        <Button type="submit" class="bg-gray-600 text-white px-2 py-1 rounded mt-2">
                                            Submit
                                        </Button>
                                    </form>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-30 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="product.packageProductCount" @click="modalHandler" class="text-center border bg-yellow-600 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ product.packageProductCount }} products
                    </div>
                    <div v-if="product.packageProductCount" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Package Products</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(packageProduct, index) in product.packageProducts" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                        <Link class="underline hover:text-blue-500" :href="route('categories.show', packageProduct.id)">{{ packageProduct.name }}</Link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ product.publisherName ?? '' }}</td>
                <td class="py-3 px-2 text-right">{{ product.productionCost }}</td>
                <td class="py-3 px-2 text-right">
                        {{ product.alertQuantity }}
                </td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from '@/Components/AddNewButton.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import Select from '@/Components/Select.vue';
import Label from '@/Components/Label.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        Input,
        Button,
        Select,
        Label
    },
    props: {
        products: { type: Object, default: {} },
        pricing: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    data() {
        return {
           columns: [
                    {title: 'Action', align: 'center'},
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Name', align: 'left', sortable: 'name'},
                    {title: 'Type', align: 'left', sortable: 'type'},
                    {title: 'Active', align: 'left', sortable: 'active'},
                    {title: 'Soft', align: 'left', sortable: 'soft'},
                    {title: 'Categrories', align: 'center'},
                    {title: 'Prices', align: 'right'},
                    {title: 'Moderators', align: 'right', sortable: 'contribution_type'},
                    {title: 'Storages', align: 'right'},
                    {title: 'Circulation', align: 'right'},
                    {title: 'Package', align: 'center'},
                    {title: 'Publisher Name', align: 'left', sortable:'publisher.name'},
                    {title: 'Production Cost', align: 'right', sortable:'production_cost'},
                    {title: 'Alert', align: 'right', sortable: 'alert_quantity'},
                ],

            form: this.$inertia.form({
                from: '',
                to: '',
                quantity: '',
                type: '',
                product_id: '',
                alert_quantity: ''
            }),
            modalShow: true,
            alertQuantity : false,
            message : '',
            formToLabel : '-- Select To --'
        }
    },

    methods : {
        changeValue(productId, storageOutlets, storages) {
            console.log(storages);
            let value = this.form.type;
            this.form.product_id = productId;
            this.formToLabel = value == 1 ? "--Storing In--" : "--Sending to--"
            let alertQuantity = this.form.to ? storageOutlets.includes(parseInt(this.form.to)) : false;

            if (value == 1 && !alertQuantity && this.form.to) {
                this.alertQuantity = true
                this.message ='';
            } else {
                this.alertQuantity = false
            }
            if(storages) {
                this.showMessage(storages);
            }
        },
        showMessage(storages) {
            if(this.form.type == 2 && this.form.from) {
                storages.forEach((storage) => {
                    this.message = `This outlet has ${storage.outlet_id == this.form.from ? storage.quantity : 0} pieces`;
                })
            }
        },
        modalHandler(event) {
            document.querySelectorAll('.checkBox').forEach((element)=>{
                element.checked = false;
            });

            this.emptyValue();

            if(!event){
                this.modalShow = false;
            }
            // console.log(this.modalShow)
            event.target.nextElementSibling.classList.toggle('hidden');
        },

        closeModal(event) {
            this.emptyValue();
            if(!event){
                this.modalShow = true;
            }
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
        submit() {
            this.message = "Your circulation is complete";
            this.form.post(this.route('circulations.store'));
            
            // setInterval(()=> {
            //     this.modalShow = true;
            // }, 1000)
            this.modalShow = true;
            
            this.emptyValue();
        },
        emptyValue() {
            this.message = '';
            this.form.from = '';
            this.form.to = '';
            this.form.quantity= '',
            this.form.type= '',
            this.form.product_id= ''
            this.fromDisabled = false;
            this.toDisabled = false;
            // console.log(this.form);
        }
    }
};
</script>
