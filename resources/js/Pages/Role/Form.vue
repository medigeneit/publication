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
                <div class="text-right">
                    <span class="mr-3">Select All</span>
                    <input type="checkbox" @click="allPermissionSelect">
                </div>
                <Label for="type" value="Permission" />
                <li class="
                        w-full
                        p-2
                        border-b
                        cursor-pointer
                        flex
                        justify-between
                    " v-for="(permission, permissionId) in data.permissions" :key="permissionId"
                    :class="{ 'bg-blue-500': selected.includes(permissionId), 'text-white': selected.includes(permissionId) }"
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
    created() {
        if (this.data.role.permissions) {
            for (let permission of this.data.role.permissions)
                this.selected.push(`${permission.id}`);
        }
        // console.log(this.data.selected); 
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.role.name || '',
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
                return this.form.put(this.route('roles.update', this.data.role.id));
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

            if (!this.selected.includes(permissionId)) {
                this.selected.push(permissionId)
            }
            else {
                let index = this.selected.indexOf(permissionId)
                this.selected.splice(index, 1);
            }
            console.log(this.selected);
            this.form.permissions = this.selected;
            
        },
        allPermissionSelect(event) {
            console.log(event.target.checked);
            if (event.target.checked) {
                this.selected.length = 0;
                for (const id in this.data.permissions) {
                    this.selected.push(id)
                }
            }
            else {
                if (this.data.role.permissions) {
                    this.selected.length = 0;
                    for (let permission of this.data.role.permissions)
                        this.selected.push(`${permission.id}`);

                    console.log(this.selected);
                }
                else {
                    this.selected.length = 0;
                }
            }
        }
    }
};
</script>
