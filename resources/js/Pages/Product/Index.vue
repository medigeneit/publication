<template>
    <Head title="Product" />

    <app-layout>
        <template #header>
            Product List
        </template>

        <!-- <add-new-button :href="route('products.create')" /> -->

        <data-table :collections="products" :filters="filters" :top-links="true" :columns="columns"  :latest="true">
            <template #default="{ item: product }">
                <td class="py-2.5 px-2" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('products.show', product.id)" />
                        <action-button-edit :href="route('products.edit', product.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">{{ product.id }}</td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    <b>
                        {{ product.name }}
                    </b>
                </td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    {{ product.typeName }}
                </td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': product.active, 'bg-red-500': !product.active }">
                        {{ product.activeValue }}
                    </span>
                </td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-yellow-500': product.soft, 'bg-gray-500': !product.soft }">
                        {{ product.soft ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-2 text-center" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                <td class="py-3 px-2 text-right" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                <td class="py-3 px-2 text-right" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                                        {{ moderator.moderators_type.name }} :   {{ moderator.author.name }}
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
                <td class="py-3 px-2 text-right" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                                    <div class="py-1.5 flex gap-4" v-for="(storage, index) in product.storages" :key="index">
                                        <!-- {{ moderator.moderators_type.name }} :   {{ moderator.author.name }} -->
                                        <div :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">
                                            {{ storage.outlet.name }} : {{ storage.quantity || 0 }} pc
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
                <td class="py-3 px-2 text-center" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                                        <input type="radio" name="inOut" class="mr-2 checkBox" @click="form.type = 1; changeValue(product.id, product.storage_outlets);" value="1" required>
                                    </div>
                                    <div>
                                        <label for=""> Out </label>
                                        <input type="radio" name="inOut" class="checkBox" value="2"  @click="form.type = 2; changeValue(product.id, product.storage_outlets, product.storages);" required>
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="text-green-600">{{ message }}</div>
                                    <form @submit.prevent="submit('Circulation')" class="">
                                        <!-- <Input id="from" type="number" class="mt-1 block w-full" placeholder="From" v-model="form.from"/> -->
                                        <div class="mb-2 text-left">
                                            <Label value="From" />
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" :disabled="fromDisabled" required >
                                                    <option value="">-- Select From--</option>
                                                    <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                            </Select>
                                        </div>
                                        <div class="mb-2 text-left">
                                            <Label value="To" />
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.to" :disabled="toDisabled" required>
                                                <option value="">-- Select To --</option>
                                                <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                            </Select>
                                        </div>

                                        <Input id="type" type="number" class="mt-1 block w-full" placeholder="Quantity" v-model="form.quantity" required/>

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

                <td class="text-center" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
                    <div class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer" v-if="product.storages.length" @click="modalHandler">
                        Request Product
                    </div>
                    <div class="fixed inset-0 z-50" id="circulationWrapper" :class="{hidden : modalShow}">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-lg bg-white rounded border shadow z-50">
                                <div class="p-3">
                                    <div v-for="(storage, index) in product.storages" :key="index" class="text-lg">
                                        <div v-for="productRequest in storage.product_requests" :key="productRequest.id" class="grid grid-cols-4 items-center justify-center">
                                            <div class="col-span-3 flex flex-col bg-gray-200 p-2 text-left rounded mt-2">
                                                <span>Requeste Quantity : {{ productRequest.request_quantity}} </span>
                                                <span>Expected Date : {{ productRequest.expected_date}} </span>
                                                <span>Requeste By : {{ productRequest.storage.outlet.name }} </span>
                                                <div class="mx-auto mt-2">
                                                    <div class="flex items-center rounded mt-2" >
                                                        <div class="text-center text-sm border bg-green-500 text-white px-2 py-1 rounded cursor-pointer"
                                                        @click="modalHandler($event, productRequest.storage.outlet.id, productRequest.id) ">
                                                            SEND
                                                        </div>
                                                        <div class="fixed inset-0 z-50" id="circulationWrapper" :class="{hidden : modalShow}">
                                                            <div class="relative w-full h-full flex justify-center items-center">
                                                                <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                                                    <div class="p-3 text-center">
                                                                        <div class="text-green-600">{{ message }}</div>
                                                                        <form @submit.prevent="submit('Circulation')" class="">
                                                                            <div class="mb-2 text-left">
                                                                                <Label value="From" />
                                                                                <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" required >
                                                                                        <option value="">-- Select From--</option>
                                                                                        <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                                                                </Select>
                                                                            </div>
                                                                            <div class="mb-2 text-left" >
                                                                                <Label value="To" />
                                                                                <Select id="outlet_id" class="mt-1 block w-full" v-model="form.to" :disabled="true"  required>
                                                                                    <option value="">-- Select To --</option>
                                                                                    <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                                                                </Select>
                                                                            </div>

                                                                            <Input id="type" type="number" class="mt-1 block w-full" placeholder="Quantity" v-model="form.quantity" required/>

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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                 <a class="bg-green-500 p-2 text-white rounded-r-lg" :href="route('product-requests.show', productRequest.id)">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-30 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>


                <td class="py-3 px-2 text-center" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
                <!-- <td class="py-3 px-2 text-left">{{ product.publisherName ?? '' }}</td>
                <td class="py-3 px-2 text-right">{{ product.productionCost }}</td> -->
                <td class="py-3 px-2 text-right" :class="{'bg-red-200' : product.total_storage <= product.alert_quantity }">
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
import NavLink from "@/Components/NavLink.vue";
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
        Label,
        NavLink
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
                    {title: 'Moderators', align: 'right', sortable: 'moderator_type'},
                    {title: 'Storages', align: 'right'},
                    {title: 'Circulation', align: 'right'},
                    {title: 'Requested Product', align: 'right'},
                    // {title: 'Package', align: 'center'},
                    // {title: 'Publisher Name', align: 'left', sortable:'publisher.name'},
                    {title: 'Production Cost', align: 'right', sortable:'production_cost'},
                    {title: 'Alert', align: 'right', sortable: 'alert_quantity'},
                ],

            form: this.$inertia.form({
                from: '',
                to: '',
                quantity: '',
                type: '',
                product_id: '',
                request_id: '',
                alert_quantity: ''
            }),
            status: '',
            modalShow: true,
            alertQuantity : false,
            message : '',
            formToLabel : '-- Select To --',
        }
    },


    methods: {
        // changeValue(productId, storageOutlets, storages) {
        //     console.log(storages);
        //     let value = this.form.type;
        //     this.form.product_id = productId;
        //     this.formToLabel = value == 1 ? "--Storing In--" : "--Sending to--"
        //     let alertQuantity = this.form.to ? storageOutlets.includes(parseInt(this.form.to)) : false;

        //     if (value == 1 && !alertQuantity && this.form.to) {
        //         this.alertQuantity = true
        //         this.message ='';
        //     } else {
        //         this.alertQuantity = false
        //     }
        //     if(storages) {
        //         this.showMessage(storages);
        //     }
        // },
        showMessage(storages) {
            if(this.form.type == 2 && this.form.from) {
                storages.forEach((storage) => {
                    this.message = `This outlet has ${storage.outlet_id == this.form.from ? storage.quantity : 0} pieces`;
                })
            }
        },
        modalHandler(event, outlet_id = null, request_id = null) {
            document.querySelectorAll('.checkBox').forEach((element)=>{
                element.checked = false;
            });
            console.log(request_id)

            this.emptyValue();

            if(outlet_id) {
                this.form.to = outlet_id;
                this.form.type = 2,
                this.form.request_id = request_id
            }

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
        },
    }
};
</script>
