<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
            </div>
            <div class="mb-4">
                <Label for="address" value="Address" />
                <Input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
            </div>
            <div class="mb-4">
                <Label for="phone" value="Phone" />
                <Input id="phone" type="number" class="mt-1 block w-full" v-model="form.phone" />
            </div>
            <div class="mb-4">
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
            </div>

            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('outlets.index')"/>
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

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
    },

    props: {
        outlet: { type: Object, default: {} },
        outletType: { type: Object, default: {} },
        moduleAction: String,
        buttonValue: { type: String, default: 'Submit' },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.outlet.name,
                address: this.outlet.address,
                phone: this.outlet.phone,
                email: this.outlet.email,
            })
        }
    },    

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('outlets.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('outlets.update', this.outlet.id));
            }
        }
    }
};
</script>
