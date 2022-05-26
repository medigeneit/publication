<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            Storage List
        </template>

        <add-new-button :href="route('storages.create')" />

        <data-table :collections="storages" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: storage }">
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">{{ storage.id }}</td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">{{ storage.outletName }}</td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">{{ storage.productName }}</td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">{{ storage.quantity }}</td>
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">{{ storage.alert_quantity }}</td>
                <!-- {{ storage.id }} -->
                <td class="py-3 px-2 text-left" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">
                    <div class="flex justify-center items-center text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer" @click="modalHandler($event); form.storage_id = storage.id">
                        Request
                    </div>
                    <div class="fixed inset-0 hidden z-50 circulationWrapper">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Product Request</div>
                                <div class="p-3">
                                    <div class="text-green-600">{{ message }}</div>
                                    <form @submit.prevent="submit('Request')" class="">
                                        <div class="mb-2 text-left">
                                            <Label value="Quantity" />
                                           <Input type="number" class="mt-1 block w-full" placeholder="Quantity" v-model="form.request_quantity" required/>
                                        </div>

                                        <div class="mb-2 text-left">
                                            <Label value="Expected Date" />
                                           <Input type="date" class="mt-1 block w-full" placeholder="Quantity" v-model="form.expected_date" required/>
                                        </div>
                                        
                                        <Button type="submit" class="bg-gray-600 text-white px-2 py-1 rounded mt-2">
                                            Submit
                                        </Button>
                                    </form>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-2.5 px-2" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('storages.show', storage.id)" />
                        <action-button-edit :href="route('storages.edit', storage.id)" />
                        <!-- <action-button-cerculation @click="modalHandler" /> -->
                    </div>
                </td>
                <td class="py-3 px-2 text-center" :class="{'bg-red-200' : storage.quantity <= storage.alert_quantity}">
                    <div class="flex justify-center items-center text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer" @click="modalHandler">
                        Circulation
                    </div>
                    <div class="fixed inset-0 hidden z-50 circulationWrapper">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Circulation</div>
                                <div class="flex justify-center items-center gap-2 p-2">
                                    <div>
                                        <label for=""> In </label>
                                        <input type="radio" name="inOut" id="" class="mr-2" value="1" @change="changeValue($event, storage.outletId, storage.productId)"  required>
                                    </div>
                                    <div>
                                        <label for=""> Out </label>
                                        <input type="radio" name="inOut" id="" value="2" @change="changeValue($event,storage.outletId, storage.productId)" required>
                                    </div>
                                </div>
                                <hr class="my-1">

                                <div class="flex justify-center items-center gap-2 p-2" v-if="outStroage">
                                    <div>
                                        <label for=""> Press </label>
                                        <input type="radio" name="fromstorage" id="" class="mr-2" value="1" @change="changePress($event, presses.pressId)"  required>
                                    </div>
                                    <div>
                                        <label for=""> Outlet </label>
                                        <input type="radio" name="fromstorage" id="" value="2" @change="changePress($event,storage.outletId)" required>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="text-green-600">{{ message }}</div>
                                    <form @submit.prevent="submit('Circulation')" class="">
                                        <!-- <Input id="from" type="number" class="mt-1 block w-full" placeholder="From" v-model="form.from"/> -->
                                        <div class="mb-2 text-left" v-if="!pressDisabled">
                                            <Label value="From" />
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" :disabled="fromDisabled" required >
                                                    <option value="">-- Select From--</option>
                                                    <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                            </Select>
                                        </div>
                                        
                                        <div class="mb-2 text-left" v-if="pressDisabled">
                                            <Label value="From"/>
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" :disabled="fromDisabled" required >
                                                <option value="">-- Select From--</option>
                                                <option :value="pressesId" v-for="(pressesName, pressesId) in presses" :key="pressesId">{{ pressesName }}</option>
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
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
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
import Label from '@/Components/Label.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import Select from '@/Components/Select.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        Input,
        Button,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        Select,
        Label
    },
    props: {
        storages: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        presses: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Outlet Name', align : 'left', sortable : 'outlet.name'},
                {title: 'Product Name', align : 'left', sortable : 'product.name'},
                {title: 'Quantity', align : 'left', sortable : 'quantity'},
                {title: 'Alert Quantity', align : 'left', sortable : 'alert_quantity'},
                {title: 'Product Request', align : 'left'},
                {title: 'Action', align : 'center'},
                {title: 'Cerculation', align : 'center'},
            ],
            form: this.$inertia.form({
                from: '',
                to: '',
                quantity: '',
                type: '',
                product_id: '',
                storage_id: '',
                request_quantity: '',
                expected_date:'',
            }),

            // outlet_id: this.storages.data[0].outletId,
    

            fromDisabled: false,
            toDisabled: false,
            pressDisabled: false,
            outStroage:false,
            modalEvent: '',
            message : ''
        }
    },

    // created(){
    //     Object.entries(this.storages.data).filter((outletId) => {
    //         console.log( this.outlet_id = outletId[1].outletName)
    //     })
    // },

    methods : {
        changeValue(event, id, productId) {
            console.log(productId);
            let value = event.target.value;
            this.form.type = value;
            this.form.product_id = productId

            console.log(id);
            if (value == 1) {
                this.form.from = '';

                this.form.to = id;
                this.toDisabled = true
                this.fromDisabled = false
                this.outStroage = true
            }
            else {
                this.form.to = '';

                this.form.from = id;
                this.fromDisabled = true
                this.toDisabled = false
                this.outStroage = false
                this.pressDisabled = false

            }
        },

        changePress(event, id) {
            let value = event.target.value;
            console.log(value);
            this.form.type = value;
            console.log(this.form.type = value)
            if (value == 1) {
                this.form.from = '';
                this.fromDisabled = false
                this.pressDisabled = true
            }else{
                this.form.from = '';
                this.pressDisabled = false
                this.fromDisabled = false

            }
        },

        modalHandler(event, id) {
            this.emptyValue()
            event.target.nextElementSibling .classList.toggle('hidden');
        },

        closeModal(event) {
            this.emptyValue();
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
        submit(type) {
            console.log(type);
            if(type === 'Circulation')
            {
                this.message = "Your circulation is complete"
            // bangla code 
                this.form.post(this.route('circulations.store'));
                setTimeout(()=> {
                    document.querySelectorAll('.circulationWrapper').forEach(element => {
                        element.classList.add('hidden');
                    });
                },2000)
                
            }

            if(type === 'Request')
            {
                this.form.post(this.route('product-requests.store'));
                setTimeout(()=> {
                document.querySelectorAll('.circulationWrapper').forEach(element => {
                        element.classList.add('hidden');
                    });
                },2000)
            }

        
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
            this.pressDisabled = false;
            this.ouletDisabled = false;
        }
    }
};
</script>
