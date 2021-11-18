<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
            </div>

           <div class="mb-4">
                <Label for="active" value="Active" />
                <Select id="active" name="active" class="mt-1 block w-full" v-model="form.active">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
            </div>
            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('publishers.index')"/>
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
        publisher: { type: Object, default: {} },
        publisherType: { type: Object, default: {} },
        moduleAction: String,
        buttonValue: { type: String, default: 'Submit' },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.publisher.name,
                active: this.publisher.active || 1,
            })
        }
    },    

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('publishers.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('publishers.update', this.publisher.id));
            }
        }
    }
};
</script>
