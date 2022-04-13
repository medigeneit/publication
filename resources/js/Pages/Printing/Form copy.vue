<template>

    <div class="w-full flex gap-4">
        <form @submit.prevent="submit" class="w-full max-w-7xl space-y-4">
            <div class="flex gap-4">
                <div>
                    <div class="w-full  mt-2 mb-2">
                        <div class="max-w-3xl p-2 gap-4 bg-white border shadow rounded">
                            <Label class="text-lg text-gray-600 font-bold" value="Document Details" />
                            <div class="flex gap-4">
                                <div class="">
                                    <Label value="Date" />
                                    <Input type="date" class="mt-1 block w-full" v-model="form.order_date"/>
                                </div>
                                <div>
                                        <Label value="Page" />
                                        <Input type="text" class="mt-1 block w-full" v-model="form.page_amount"/>
                                </div>
                                <div>
                                        <Label value="Copy" />
                                        <Input type="text" class="mt-1 block w-full" v-model="form.copy_quantity"/>
                                </div>
                                <div>
                                        <Label value="Binding Category" />
                                        <Input type="text" class="mt-1 block w-full" v-model="form.bind_caterory_name" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex gap-6">
                        <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                            <h3 class="text-lg text-gray-600 font-bold">Printing Details</h3>
                            <div class="w-full text-right mb-2">
                                <Button @click="modalHandler" type="button" class="btn-danger border-4">
                                + Add Filed
                            </Button>
                                <div class="fixed inset-0 hidden z-50">
                                    <div class="relative w-full h-full flex justify-center items-center">
                                        <div class="relative p-2 w-full mx-auto max-w-lg bg-white rounded border shadow z-50">
                                            <div class="text-lg font-bold text-center">Printing key and value added</div>
                                            <hr class="my-1">
                                            <div class="p-3">
                                                <div class="py-1.5 flex gap-2 mr-10">
                                                    <div class="w-full max-w-7xl space-y-4">
                                                        <div class="text-left">
                                                            <Label value="Key" />
                                                            <Input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    v-model="form.key"
                                                                />
                                                        </div>
                                                        <div class="text-left p-2">
                                                            <Label value="Value"/>
                                                            <div class="block"  v-for="(value, index) in form.values" :key="index">
                                                                <Input
                                                                        type="text"
                                                                        class="mt-1 py-1 block w-full !text-sm"
                                                                        v-model="form.values[index]"
                                                                    />
                                                            </div>
                                                                <Button
                                                                type="button"
                                                                class="mt-2 btn-danger border-4"
                                                                @click="addPrintingValue()"
                                                            >
                                                                (+) Add
                                                            </Button>
                                                        </div>

                                                        <Button type="submit">Submit</Button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                                        </div>
                                        <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                            <div class="w-full h-full" @click="closeModal"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- {{ form.printing_details }} -->
                            <div class="w-full bg-white gap-4 p-4">
                                <table class="w-full min-w-max">
                                    <tbody>
                                        <tr
                                            class=""
                                            v-for="(printingDetail, index) in data.printing_details_category_keys"
                                            :key="printingDetail.id"
                                        >
                                            <td class="text-right px-2 py-1 text-sm">   
                                                {{ printingDetail.name }}
                                            </td>
                                            <td class="text-left px-2 py-1" >
                                                <Select
                                                    class="mt-1 block w-full"
                                                    v-model="form.category_value_id[index]"
                                                    @change="test"
                                                >
                                                <option value="">Select Value</option>
                                                <option :value="priceCategoryValue.id" v-for="(priceCategoryValue) in printingDetail.values" :key="priceCategoryValue.id">
                                                    {{ priceCategoryValue.name }}
                                                </option>
                                                </Select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                            <!-- <div class="w-full bg-white gap-4 p-4">
                                <table class="w-full min-w-max">
                                    <tbody>
                                        <tr
                                            class=""
                                            v-for="printingDetail in form.printing_details"
                                            :key="printingDetail.printing_detail_id"
                                        >
                                            <td class="text-right px-2 py-1 text-sm">
                                                {{ printingDetail.printing_detail_name }}
                                            </td>
                                            <td class="text-left px-2 py-1" >
                                                <Select
                                                    class="mt-1 block w-full"
                                                    v-model="printingDetail.category_value_id"
                                                    @change="test"
                                                >
                                                <option value="">Select Value</option>
                                                <option :value="priceCategoryValue.id" v-for="(priceCategoryValue) in printingDetail.options" :key="priceCategoryValue.id">
                                                    {{ priceCategoryValue.name }}
                                                </option>
                                                </Select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
<<<<<<< HEAD

                            </div>
=======
                                
                            </div> -->
>>>>>>> printingDetails2
                        </div>

                    </div>

                    <div class="w-full flex gap-4 mt-2">
                        <div class="w-full max-w-7xl space-y-4">
                            <div class="w-full flex gap-6">
                                <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                                    <h3 class="text-lg text-gray-600 font-bold">Cost Details</h3>
                                    <div class="w-full bg-white gap-4 p-4">
                                    <table class="w-full border">
                                            <thead>
                                                <tr class="text-center">
                                                    <td class="border text-sm">বিবরণ</td>
                                                    <td class="border text-sm">পরিমান</td>
                                                    <td class="border text-sm">রেট</td>
                                                    <td class="border text-sm">টাকা</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(costDetail, index) in form.cost_details" :key="index">
                                                    <td class="p-2 text-xs">{{ costDetail.cost_category_name }}</td>
                                                    <td class="">
                                                        <Input  type="number"
                                                        class="mt-1 py-1 block w-full"
                                                        v-model="costDetail.quantity"
                                                        @change="checkSubtotal(index)"
                                                        />
                                                    </td>
                                                    <td class="">
                                                        <Input  type="number"
                                                        class="mt-1 py-1 block w-full"
                                                        v-model="costDetail.rate"
                                                        @change="checkSubtotal(index)"
                                                        />
                                                    </td>
                                                    <td class="">
                                                        <Input  type="number"
                                                        class="mt-1 py-1 block w-full"
                                                        v-model="costDetail.subtotal"
                                                        />
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div>
                    <div class="w-full gap-4 mt-2">
                        <div class="max-w-3xl bg-white gap-2 p-2">
                        <Label class="text-lg text-gray-600 font-bold" value="Note" />
                            <div class="
                                    w-full
                                    grid grid-cols-2
                                    md:grid-cols-3
                                    bg-white
                                    border
                                    rounded
                                    gap-4
                                    p-4
                                ">
                                <div>
                                    <Label value="Printing Press" />
                                    <Select
                                        class="mt-1 block w-full"
                                        v-model="form.press"
                                    >
                                        <option value="">-- Select Printing Press --</option>
                                        <option v-for="(printingPress, printingId) in data.presses" :value="printingId" :key="printingId">{{ printingPress }}</option>
                                    </Select>
                                </div>

                                <div class="flex flex-col justify-start">
                                    <Label value="প্লেট সংরক্ষন করা হবে কিনা" />
                                    <div class="flex ml-10">
                                        <div class="mr-5">
                                            <Input
                                                type="radio"
                                                name="is_place_storable"
                                                class="mt-1 block"
                                                v-model="form.is_place_storable"
                                                value="1"
                                                @click="storigngAtVisibility = true"
                                            />
                                            <Label value="Yes" />
                                        </div>
                                        <div>
                                            <Input
                                                type="radio"
                                                name="is_place_storable"
                                                class="mt-1 block"
                                                v-model="form.is_place_storable"
                                                value="0"
                                                @click="storigngAtVisibility = false"
                                            />
                                            <Label value="No" />
                                        </div>
                                    </div>
                                </div>
                                <div v-if="storigngAtVisibility">
                                    <Label value="Storing At" />
                                    <Select
                                        class="mt-1 block w-full"
                                        v-model="form.plate_stored_at"
                                    >
                                        <option value="">-- Select Printing Press --</option>
                                        <option v-for="(printingPress, printingId) in data.presses" :value="printingId" :key="printingId">{{ printingPress }}</option>
                                    </Select>
                                </div>
                            </div>
                            <div class="w-full">
                                <Contributors :form ="form" :data="data"/>
                            </div>
                        </div>
                </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list />
                </div>
                <Button
                    class=""
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ buttonValue }}
                </Button>
            </div>
        </form>

    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import GoToList from "@/Components/GoToList.vue";
import Select from "@/Components/Select.vue";
import ActiveInput from "@/Components/ActiveInput.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import Contributors from "@/Components/Contributors.vue";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        ActiveInput,
        ActionButtonEdit,
        Contributors,
    },

    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "Submit",
        },
        data: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {

            form: this.$inertia.form({

                printing_details_category_key_id: this.data.printing_details_category_keys.id || "",

                version_id: this.data.version,

                name: '',

                printing_details: [

                ],

                category_value_id:[],

                key: " ",

                copy_quantity:" ",

                page_amount:" ",

                plate_stored_at:" ",

                order_date:" ",

                bind_caterory_name:" ",

                values: [''],

                press: " ",

                cost_details: [],

                 contributors: [
                    {
                        authorId: "",
                        moderatorType: "",
                    },
                ],

                is_place_storable:" ",
                active: this.moduleAction == "store" ? 1 : this.data.printing.active,
                moduleAction: this.moduleAction
            }),
            storigngAtVisibility : false ,
            value: null,
            options: [
            'Batman',
            'Robin',
            'Joker',
            ],
        };
    },
    created() {
        for(let index in this.data.printing) {
            console.log('printings', index);
            this.form.printing[index] = this.data.printing[index] ? this.data.printing[index] :'';
        }

        Object.entries(this.data.costCategories).forEach((cost_category) => {
            this.form.cost_details.push({
                cost_category_id: cost_category[0],
                cost_category_name: cost_category[1],
                quantity: '',
                rate: '',
                subtotal: '',
            });
        });

        Object.values(this.data.printing_details_category_keys).forEach((printing_details) => {
            console.log(printing_details)
            this.form.printing_details.push({
                printing_detail_id: printing_details['id'],
                printing_detail_name: printing_details['name'],
                options: printing_details['values'],
                category_value_id: '',
            });
        });


        for(let index in this.data.selectedModerators) {
            console.log(this.data.selectedModerators[index]);
            this.form.contributors[index] = this.data.selectedModerators[index] ? this.data.selectedModerators[index] : '';
        }
    },

    methods: {

        checkSubtotal(index) {
            let data = this.form.cost_details[index];
            if(data.quantity && data.rate) {
                data.subtotal = data.quantity * data.rate;
            }
        },

        test() {
            console.log(this.form.price_details);
        },

        checkSelect(select_index, option_id) {
            return option_id == this.selectedEvents[select_index]
        },

        addPrintingValue() {
            this.form.values.push([]);
        },

        addModertor() {
            this.form.contributors.push({
                authorId: "",
                moderatorType: "",
            });
        },

        copyVolume(id) {
            appendableDiv.innerHTML += singleWrapper;
        },

        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },

        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("printing-details.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("printing-details.update", this.data.version.id)
                );
            }
        },
    },
};
</script>
