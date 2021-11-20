<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">

            <div class="mb-4">
                <Label for="outlet_id" value="Outlet Name" />
                <Select id="outlet_id" type="text" class="mt-1 block w-full" v-model="form.outlet_id">
                    <option value="0">-- Select --</option>
                    <option :value="outletId" v-for="outletname, outletId in data.outlets" :key="outletId">{{ outletname }}</option>
                </Select>
            </div>
            
            <div class="mb-4">
                <Label for="customer_name" value="Customer Name" />
                <Input id="customer_name" type="text" class="mt-1 block w-full" v-model="form.customer_name" />
            </div>

            <div class="mb-4">
                <Label for="customer_phone" value="Customer Phone" />
                <Input id="customer_phone" type="number" class="mt-1 block w-full" v-model="form.customer_phone"  />
            </div>

            <div class="mb-4">
                <Label for="customer_address" value="Customer Address" />
                <Input id="customer_address" type="text" class="mt-1 block w-full" v-model="form.customer_address"  />
            </div>

            <div class="mb-4">
                <Label for="subtotal" value="Subtotal" />
                <Input id="subtotal" type="number" class="mt-1 block w-full" v-model="form.subtotal"  />
            </div>

            <div class="mb-4">
                <Label for="discount" value="Discount" />
                <Input id="discount" type="number" class="mt-1 block w-full" v-model="form.discount"  />
            </div>

            <div class="mb-4">
                <Label for="discount_purpose" value="Discount Purpose" /> 
                <Textarea id="discount_purpose"  class="mt-1 block w-full" v-model="form.discount_purpose" />
            </div>

            <div class="mb-4">
                <Label for="amount" value="Amount" />
                <Input id="amount" type="number" class="mt-1 block w-full" v-model="form.amount"  />
            </div>

            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('sales.index')"/>
                </div>
                <Button class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ buttonValue }}
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import GoToList from '@/Components/GoToList.vue';
import Select from '@/Components/Select.vue';
import Textarea from '@/Components/Textarea.vue';

export default {
    components: {
        Button,
        Input,
        Textarea,
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

    data() {
        
        return {
            form: this.$inertia.form({
                outlet_id: this.data.sale.outlet_id || 0,
                customer_name: this.data.sale.customer_name,
                customer_phone: this.data.sale.customer_phone,
                customer_address: this.data.sale.customer_address,
                subtotal: this.data.sale.subtotal,
                discount: this.data.sale.discount,
                discount_purpose: this.data.sale.discount_purpose,
                amount: this.data.sale.amount,
            })
        }

    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('sales.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('sales.update', this.data.sale.id));
            }
        }
    }
};
</script>
