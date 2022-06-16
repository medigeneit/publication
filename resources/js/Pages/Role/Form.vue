<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input name="name" type="text" class="mt-1 block w-full" v-model="form.name" />
            </div>
            <!-- :class="{ hidden: selected.includes(permission.id) }" -->
            <div class="mb-4">
                <Label for="type" value="Permission" />
                <li class="
                        w-full
                        p-2
                        border-b
                        cursor-pointer
                        flex
                        justify-between
                    " v-for="(permission, permissionId) in data.permissions" :key="permissionId"
                    :class="{ 'bg-green-500': selected.includes(permissionId) }"
                    @click="selectPermissionHandler(permissionId)">
                    <div class="w-full">
                        {{ permission }}
                    </div>
                </li>
            </div>

            <hr class="w-full my-4">

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('roles.index')" />
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
                name: this.data.name,
                permissions: [],
            }),
            selected: [],
        }
    },

    methods: {
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('roles.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('roles.update', this.data.account.id));
            }
        },
        accountCategoryHandler() {
            const type = parseInt(this.form.type);
            console.log(typeof type)
            this.accountCategoryList = {};

            if(type === 1) {
                this.accountCategoryList = this.data.incomeCategoryList;
            }

            if(type === 2) {
                this.accountCategoryList = this.data.expenseCategoryList;
            }
        },
        selectPermissionHandler(permissionId) {
            let permission = this.data.permissions[permissionId];

            if (!this.selected.includes(permissionId)) {
                this.selected.push(permissionId)
            }
            else {
                let index = this.selected.indexOf(permissionId)
                this.selected.splice(index, 1);
            }
            this.form.permissions = this.selected;
            
        },
    }
};
</script>
