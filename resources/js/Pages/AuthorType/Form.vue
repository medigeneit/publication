<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name"/>
                <Input name="name" type="text" class="mt-1 block w-full" v-model="form.name" />
            </div>

            <hr class="w-full my-4">
            
            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('price-categories.index')"/>
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

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
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
                name: this.data.authorType.name || '',
            })
        }
    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('author-types.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('author-types.update', this.data.authorType.id));
            }
        }
    }
};
</script>
