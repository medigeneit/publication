<template>
    <Head title="Storage" />

    <app-layout>
        <template #header>
            Storage List
        </template>

        <add-new-button :href="route('storages.create')" />

        <data-table :collections="storages" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: storage }">
                <td class="py-3 px-2 text-left">{{ storage.id }}</td>
                <td class="py-3 px-2 text-left">{{ storage.outletName }}</td>
                <td class="py-3 px-2 text-left">{{ storage.productName }}</td>
                <td class="py-3 px-2 text-left">{{ storage.quantity }}</td>
                <td class="py-3 px-2 text-left">{{ storage.alert_quantity }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('storages.show', storage.id)" />
                        <action-button-edit :href="route('storages.edit', storage.id)" />
                        <!-- <action-button-cerculation @click="modalHandler" /> -->
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div class="flex justify-center items-center text-gray-700 cursor-pointer" @click="modalHandler">
                        Circulation
                        <!-- <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 font-weight-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 font-weight-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                        </div> -->
                    </div>
                    <div class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Circulaion</div>
                                <div class="flex justify-center">
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
                                <div class="p-3">
                                    <form @submit.prevent="submit" class="">
                                        <!-- <Input id="from" type="number" class="mt-1 block w-full" placeholder="From" v-model="form.from"/> -->
                                        <div class="mb-4">
                                            <Select id="outlet_id" class="mt-1 block w-full" v-model="form.from" :disabled="fromDisabled" required >
                                                <option value="">-- Select From--</option>
                                                <option :value="outletsId" v-for="(outletsName, outletsId) in outlets" :key="outletsId">{{ outletsName }}</option>
                                            </Select>
                                        </div>
                                        <div class="mb-4">
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
    },
    props: {
        storages: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
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
                {title: 'Action', align : 'center'},
                {title: 'Cerculation', align : 'center'},
            ],
            form: this.$inertia.form({
                from: '',
                to: '',
                quantity: '',
                type: '',
                product_id: ''
            }),
            fromDisabled: false,
            toDisabled: false,
            modalEvent: ''
        }
    },
    methods : {
        changeValue(event, id, productId) {
            let value = event.target.value;
            this.form.type = value;
            this.form.product_id = productId

            console.log(id);
            if (value == 1) {
                this.form.from = '';

                this.form.to = id;
                this.toDisabled = true
                this.fromDisabled = false
            }
            else {
                this.form.to = '';

                this.form.from = id;
                this.fromDisabled = true
                this.toDisabled = false

            }
        },

        modalHandler(event, id) {
            this.modalEvent = event
            event.target.nextElementSibling .classList.toggle('hidden');
        },

        closeModal(event) {
            this.form.from = '';
            this.form.to = '';
            this.fromDisabled = false;
            this.toDisabled = false;

            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
        submit() {
            return this.form.post(this.route('circulations.store'));
            this.closeModal(this.modalEvent)
        },
    }
};
</script>
