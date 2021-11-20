<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="publisher" value="Publisher" />
                <Select id="publisher" class="mt-1 block w-full" v-model="form.publisher_id">
                    <option value="0">--Select --</option>
                    <option :value="publisherId" v-for="publisherName, publisherId in data.publishers" :key="publisherId">{{ publisherName }}</option>
                </Select>
            </div>
            <div class="mb-4">
                <Label for="purpose" value="Purpose"/>
                <Textarea name="purpose" type="text" class="mt-1 block w-full" v-model="form.purpose" />
            </div>

            <div class="mb-4">
                <Label for="amount" value="Amount" />
                <Input name="amount" type="number" class="mt-1 block w-full" v-model="form.amount"/>
            </div>

            <div class="mb-4">
                <Label for="type" value="Type" />
                <Select name="type" class="mt-1 block w-full" v-model="form.type" required>
                     <option value="0"> -- Select Type -- </option>
                    <option :value="type" v-for="(typeName, type) in data.accountType" :key="type">{{ typeName }}</option>
                </Select>
            </div>
            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('products.index')"/>
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
import Textarea from '@/Components/Textarea.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import GoToList from '@/Components/GoToList.vue';
import Select from '@/Components/Select.vue';

export default {
    components: {
        Button,
        Textarea,
        Input,
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
                publisher_id: this.moduleAction == 'store' ? 0 : this.data.account.accountable_id,
                purpose: this.data.account.purpose,
                amount: this.data.account.amount,
                type: this.data.account.type || 0,

            })
        }
    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('accounts.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('accounts.update', this.data.account.id));
            }
        }
    }
};
</script>
