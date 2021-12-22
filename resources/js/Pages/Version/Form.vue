<template>
    <div class="w-full flex gap-4">
        <div class="w-full max-w-2xl p-4 bg-white border shadow rounded">

            <ValidationErrors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4">
                    <div class="mb-4 col-span-2">
                        <Label for="type" value="Type" />
                        <Select name="type" class="mt-1 block w-full" @change="typeChange(parseInt(form.type))" v-model="form.type" required>
                            <option value=""> -- Select Type -- </option>
                            <option :value="type" v-for="(typeName, type) in data.versionType" :key="type">{{ typeName }}</option>
                        </Select>
                    </div>

                    <div class="mb-4 col-span-2" id="productWrapper">
                        <Label for="product_id" value="Product Name" />
                        <Select id="publisher_id" class="mt-1 block w-full" v-model="form.publisher_id">
                            <option value=""> -- Select Production -- </option>
                            <option :value="publisherId" v-for="(productionName, productionId) in data.productionList" :key="productionId">
                                {{ productionName }}
                            </option>
                        </Select>
                    </div>

                    <div class="mb-4">
                        <Label for="active" value="Active" />
                        <Select id="active" name="active" class="mt-1 block w-full" v-model="form.active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </Select>
                    </div>

                    <div class="mb-4 col-start-1">
                        <Label for="edition" value="Edition" />
                        <Input id="edition" name="edition" type="text" step="0.01" class="mt-1 block w-full" v-model="form.edition" />
                    </div>
                </div>

                <hr class="w-full my-4">
                
                <div class="flex items-center justify-between">
                    <div class="">
                        <go-to-list :href="route('versions.index')"/>
                    </div>
                    <Button class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ buttonValue }}
                    </Button>
                </div>
            </form>
        </div>
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
                type: this.data.version.type || '',
                production_id: this.data.production_id || '',
                active: this.moduleAction == 'store' ? 1 : this.data.version.active,
                product_ids: this.data.product_ids || [],
            }),
            categoryShow: false,
            productShow: false,
        }
    },

    methods: {

        typeChange(type) {
            console.log(this.data.version.type === 1)
            let publisherWrapper = document.getElementById('publisherWrapper');
            let productWrapper = document.getElementById('productWrapper');

            if(type === 1) {
                publisherWrapper.classList.add('hidden');
                productWrapper.classList.remove('hidden');
            } else {
                publisherWrapper.classList.remove('hidden');
                productWrapper.classList.add('hidden');
            }
        },

        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('versions.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('versions.update', this.data.version.id));
            }
        },

        itemClickHandler(event) {
            const category = event.target.closest('.parent');

            const subcategoryContainer = category.nextElementSibling;

            if(subcategoryContainer) {
                subcategoryContainer.classList.toggle('hidden');
            }

            category.firstElementChild.classList.toggle('rotate-180');
        },

        categorySelectHandler(categoryId) {
            categoryId = parseInt(categoryId);

            if (this.form.category_ids.includes(categoryId)) {
                this.form.category_ids.splice(this.form.category_ids.indexOf(categoryId), 1);
            } else {
                this.form.category_ids.push(categoryId);
            }
        },
        
        productSelectHandler(productId) {
            productId = parseInt(productId);

            if (this.form.product_ids.includes(productId)) {
                this.form.product_ids.splice(this.form.product_ids.indexOf(productId), 1);
            } else {
                this.form.product_ids.push(productId);
            }
        }
    }
};
</script>
