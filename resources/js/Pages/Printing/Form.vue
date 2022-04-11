<template>

    <div class="w-full flex gap-4">
        <form @submit.prevent="submit" class="w-full max-w-7xl space-y-4">
            <div class="w-full  mt-2 mb-2">
                <div class="max-w-3xl p-2 gap-4 bg-white border shadow rounded">
                    <Label class="text-lg text-gray-600 font-bold" value="Document Details" />
                    <div class="flex gap-4">
                        <div class="">
                            <Label value="Date" />
                            <Input type="text" class="mt-1 block w-full"/>
                        </div>
                        <div>
                                <Label value="Page" />
                                <Input type="text" class="mt-1 block w-full"/>
                        </div>
                        <div>
                                <Label value="Copy" />
                                <Input type="text" class="mt-1 block w-full"/>
                        </div>
                        <div>
                                <Label value="Binding Category" />
                                <Input type="text" class="mt-1 block w-full"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full flex gap-6">
                <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                    <h3 class="text-lg text-gray-600 font-bold">Printing Section</h3>
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
                    <div class="w-full bg-white gap-4 p-4">
                        <table class="w-full min-w-max">

                            <tbody>
                                <tr
                                    class=""
                                    v-for="(priceDetailsCategoryKey, index) in data.printing_details_category_keys"
                                    :key="priceDetailsCategoryKey.id"
                                >
                                    <td class="text-right px-2 py-1">
                                        {{ priceDetailsCategoryKey.name }}
                                    </td>
                                    <td class="text-left px-2 py-1" >
                                        <Select
                                            class="mt-1 block w-full"
                                            v-model="form.price_details[index]"
                                            @change="test"
                                        >
                                        <option value="">Select Value</option>
                                        <option :value="priceCategoryValue.id" v-for="(priceCategoryValue) in priceDetailsCategoryKey.values" :key="priceCategoryValue.id">
                                            {{ priceCategoryValue.name }}
                                        </option>
                                        </Select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
               
            </div>
            <div class="w-full flex gap-4 mt-2">
                <form @submit.prevent="PrintingDetailssubmit" class="w-full max-w-7xl space-y-4">
                    <div class="w-full flex gap-6">
                        <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                            <h3 class="text-lg text-gray-600 font-bold">Printing Details</h3>
                            <div class="w-full bg-white gap-4 p-4">
                            <table class="w-full border">
                                    <thead>
                                        <tr>
                                            <th class="border">বিবরণ</th>
                                            <th class="border">পরিমান</th>
                                            <th class="border">রেট</th>
                                            <th class="border">টাকা</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(cost_category, index) in data.cost_categories" :key="index">
                                            <td class="p-2">{{ cost_category }}</td>
                                            <td class="">
                                                <Input  type="number"
                                                class="mt-1 py-1 block w-full"
                                                v-model="form.name"
                                                />
                                            </td>
                                            <td class="">
                                                <Input  type="number"
                                                class="mt-1 py-1 block w-full"
                                                v-model="form.name"
                                                />
                                            </td>
                                            <td class="">
                                                <Input  type="number"
                                                class="mt-1 py-1 block w-full"
                                                v-model="form.name"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>
                </form>
                
            </div>
            <div class="w-full gap-4 mt-2">
                <div class="max-w-3xl bg-white border rounded gap-2 p-2">
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

                        <div>
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
                                v-model="form.storing_at"
                            >
                                <option value="">-- Select Printing Press --</option>
                                <option v-for="(printingPress, printingId) in data.presses" :value="printingId" :key="printingId">{{ printingPress }}</option>
                            </Select>
                        </div>
                    </div>
                </div>
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
import Moderators from "@/Components/Moderators.vue";
import Multiselect from '@vueform/multiselect'

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
        Moderators,
        Multiselect
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
                name: '',
                price_details : [],
                key: "",
                values: [''],
                active: this.moduleAction == "store" ? 1 : this.data.printing.active,
                moduleAction: this.moduleAction
            }),
            storigngAtVisibility : false ,
            value: null,
            options: [
            'Batman',
            'Robin',
            'Joker',
            ]
        };
    },
    created() {
        for(let index in this.data.printing) {
            console.log('printings', index);
            this.form.printing[index] = this.data.printing[index] ? this.data.printing[index] : '';
        }

        for(let index in this.data.selectedModerators) {
            console.log(this.data.selectedModerators[index]);
            this.form.moderators[index] = this.data.selectedModerators[index] ? this.data.selectedModerators[index] : '';
        }
    },

    methods: {
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
            this.form.moderators.push({
                ContributorId: "",
                ContributionType: "",
                honorariumType: "",
                honorarium: "",
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
<style src="@vueform/multiselect/themes/default.css"></style>