<template>
    <div class="w-full flex gap-4">
        <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

            <ValidationErrors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <Label for="production_id" value="Production Name" />
                    <Select id="production_id" class="mt-1 block w-full" v-model="form.production_id" required>
                        <option value=""> -- Select Production -- </option>
                        <option :value="productionId" v-for="(productionName, productionId) in data.productionList" :key="productionId">
                            {{ productionName }}
                        </option>
                    </Select>
                </div>

                <div class="mb-4">
                    <Label for="type" value="Type" />
                    <Select name="type" class="mt-1 block w-full" @change="typeChange(parseInt(form.type))" v-model="form.type" required>
                        <option value=""> -- Select Type -- </option>
                        <option :value="type" v-for="(typeName, type) in data.versionType" :key="type">{{ typeName }}</option>
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
                    <Input id="edition" name="edition" type="number" step="0.01" class="mt-1 block w-full" v-model="form.edition" />
                </div>

                <div class="mb-4 col-start-1">
                    <Label for="isbn" value="ISBN" />
                    <Input id="isbn" name="isbn" type="text" step="0.01" class="mt-1 block w-full" v-model="form.isbn" />
                </div>

                <div class="mb-4 col-start-1">
                    <Label for="crl" value="CRL" />
                    <Input id="crl" name="crl" type="text" step="0.01" class="mt-1 block w-full" v-model="form.crl" />
                </div>

                <div class="mb-4 col-start-1">
                    <Label for="productionCost" value="Production Cost" />
                    <Input id="productionCost" name="production_cost" type="number" step="0.01" class="mt-1 block w-full" v-model="form.production_cost" />
                </div>

                <div class="mb-4 col-start-1">
                    <Label for="link" value="Link" />
                    <Input id="link" name="link" type="text" step="0.01" class="mt-1 block w-full" v-model="form.link" />
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
        
        <div id="volumeWrapper" class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded" :class="{'hidden' : form.type !== 4 && (form.type !== 2 || form.type !== 3) }">
            <div class="mb-4 col-start-1">
                <Label for="volume_name" value="Volume Name" />
                <Input id="volumeName" name="volume_name" type="text" step="0.01" class="mt-1 block w-full" v-model="form.volumeName" />
            </div>
            <div class="mb-4 col-start-1">
                <Label for="volume_no" value="Volume No" />
                <Input id="volumeNo" name="volume_no" type="text" step="0.01" class="mt-1 block w-full" v-model="form.volumeNo" />
            </div>
            <div class="mb-4 col-start-1">
                <Label for="volume_link" value="Volume Link" />
                <Input id="volumeLink" name="volume_link" type="text" step="0.01" class="mt-1 block w-full" v-model="form.volumeLink" />
            </div>
            <div class="mb-4 col-start-1">
                <Label for="volume_cost" value="Volume Cost" />
                <Input id="volumeCost" name="volume_cost" type="text" step="0.01" class="mt-1 block w-full" v-model="form.volumeCost" />
            </div>
                <div class="mb-4">
                    <Label for="volumeActive" value="Active" />
                    <Select id="volumeActive" name="volume_active" class="mt-1 block w-full" v-model="form.volumeActive">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </Select>
                </div>
            </div>
        
        <!-- <div id="productWrapper" class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded" :class="{'hidden' : form.type !== 1 && (form.type !== 2 || form.type !== 3) }" >
            <input placeholder="Search..." @input="searchProduct" class=" px-2 py-2 w-full rounded border border-gray-500 focus:outline-none focus:ring-0"/>
            <div class="p-2 mb-2 border">
               
                <div class="w-full flex justify-between items-center overflow-auto" >
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="text-gray-600 text-sm font-light bg-white">
                                <th class="text-left">Name</th>
                                <th class="text-left">Cost</th>
                                <th>Mrp</th>
                                <th>Estimation</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light bg-white">
                            <tr class="border" v-for="(product) in data.productList" :key="product.id" :class="{ 'bg-green-200' : form.product_ids.includes(parseInt(product.id)), 'bg-white' : form.product_ids.includes(parseInt(product.id)) }">
                                <td class="w-40">{{ product.name }} {{form.packageProductPrice[product.id]}}</td>
                                <td>{{ product.production_cost }}</td>
                                <td>{{ product.mrp }}</td>
                                <td>
                                    <input type="number" class="cursor-pointer w-20 ml-auto text-center" v-model="form.packageProductPrice[product.id]" >
                                </td>
                                <td><Input type="checkbox" class="cursor-pointer" @change="productSelectHandler(product.id)" :checked="form.product_ids.includes(parseInt(product.id))" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>   
        </div> -->
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
                production_id: this.data.version.production_id || '',
                edition: this.data.version.edition || '',
                isbn: this.data.version.isbn || '',
                crl: this.data.version.crl || '',
                production_cost: this.data.version.production_cost || '',
                link: this.data.version.link || '',
                active: this.moduleAction == 'store' ? 1 : this.data.version.active,
                volumeName: '',
                volumeNo: '',
                volumeLink: '',
                volumeCost: '',
                volumeActive: '',
                product_ids: this.data.product_ids || [],
                product_prices: this.data.product_prices || [],
                packageProductPrice: this.data.product_prices || {},
            }),
            categoryShow: false,
            productShow: false,
            selected: [],
        }
    },

    methods: {

        typeChange(type) {
            let volumeWrapper = document.getElementById('volumeWrapper');
            // let productWrapper = document.getElementById('productWrapper');
            
            switch(type) {
                case 4:
                    volumeWrapper.classList.remove('hidden');
                    // productWrapper.classList.add('hidden');
                    break;
                case 1:
                    volumeWrapper.classList.add('hidden');
                    // productWrapper.classList.remove('hidden');
                    break;
                default:
                    // productWrapper.classList.add('hidden');
                    volumeWrapper.classList.add('hidden');
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
        productSelectHandler(productId) {
            productId = parseInt(productId);

            if (this.form.product_ids.includes(productId)) {
                this.form.product_ids.splice(this.form.product_ids.indexOf(productId), 1);
            } else {
                this.form.product_ids.push(productId);
            }
        },
        searchProduct(event) {
            let url = this.route(this.routeName || this.route().current(), {
                selected: this.selected.toString(),
                search: !event.target.value.includes('\\') ? event.target.value : '',
            });

            this.$inertia.get(url, {}, { preserveState: true });
        },
    }
};
</script>
