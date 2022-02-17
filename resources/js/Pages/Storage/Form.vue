<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="outlet_id" value="Outlet Name" />
                <Select id="outlet_id" type="text" class="mt-1 block w-full" v-model="form.outlet_id" >
                    <option value="0">-- Select --</option>
                    <option :value="outletsId" v-for="(outletsName, outletsId) in data.outlets" :key="outletsId">{{ outletsName }}</option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="product_id" value="Product Name" />
                <Select id="product_id" class="mt-1 block w-full" v-model="form.product_id" >
                    <option value="0">-- Select --</option>
                    <option :value="id" v-for="(product, id) in data.products" :key="parseInt(id)">{{ product }}</option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="quantity" value="Quantity" />
                <Input id="quantity" type="number" class="mt-1 block w-full" v-model="form.quantity" />
            </div>

            <hr class="w-full my-4">

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('storages.index')"/>
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
// import GoToList from '@/Components/GoToList.vue';
import Select from '@/Components/Select.vue';

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        // GoToList,
        Select,
    },

    props: {
        data: {
            type: Object,
            default: {}
        },

        moduleAction: String,

        buttonValue: {
            type: String,
            default: 'Submit'
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                outlet_id: this.data.storage.outlet_id || 0,
                user_id: this.data.storage.user_id || 0,
                product_id: this.data.storage.product_id || 0,
                quantity: this.data.storage.quantity,
            })
        }
    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('storages.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('storages.update', this.data.storage.id));
            }
        }
    }
};
</script>
