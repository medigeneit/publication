<template>
    <div class="w-full flex gap-4">
        <form @submit.prevent="submit" class="w-full max-w-7xl space-y-4">
            <div class="w-full flex gap-6">
                <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                    <h3 class="text-lg text-gray-600 font-bold">Version Information</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                    >
                        <div>
                            <Label value="Raw Product" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.production_id"
                                required
                            >
                                <option value="">-- Select Production --</option>
                                <option
                                    :value="productionId"
                                    v-for="(
                                        productionName, productionId
                                    ) in data.productionList"
                                    :key="productionId"
                                >
                                    {{ productionName }}
                                </option>
                            </Select>
                        </div>

                        <div>
                            <Label value="Edition" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.edition"
                            />
                        </div>

                        <div>
                            <Label value="Release Date" />
                            <Input
                                type="date"
                                class="mt-1 block w-full"
                                v-model="(form.release_date)"
                            />
                        </div>

                        <div>
                            <Label value="Cost per unit" />
                            <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="(form.production_cost)"
                            />
                        </div>

                        <div>
                            <Label value="Link" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.link"
                            />
                        </div>

                        <active-input v-model="form.active" />

                        <div>
                            <Label value="Type" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.type"
                                required
                            >
                                <option value="">-- Select Type --</option>
                                <option
                                    :value="type"
                                    v-for="(typeName, type) in data.versionType"
                                    :key="type"
                                    :disabled ="type == 3"
                                    :hidden="(type == 3) && (this.data.version.type != 3) "
                                >
                                {{ typeName }}
                                </option>
                            </Select>
                        </div>
                        
                        <div>
                            <Label value="Page" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.page"
                            />
                        </div>
                        
                        <div>
                            <Label value="Copy Quantity" />
                            <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.copy_quantity"
                            />
                        </div>

                        <div>
                            <Label value="Binding Type" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.binding_type"
                                required
                            >
                                <option value="">-- Select Binding Type --</option>
                                <option value="1">Juce and Auto Binding</option>
                                <option value="2">Dessert and Manual Binding</option>
                                
                            </Select>
                        </div>
                    </div>
                    <h3 class="text-lg text-gray-600 font-bold">Volume Information</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                        v-for="(volume, index) in form.volumes"
                        :key="index"
                    >
                        <div>
                            <Label value="Valume Name" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].name"
                            />
                        </div>

                        <!-- <div>
                            <Label value="Production Cost" />
                            <Input
                                type="number"
                                step="0.01"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].cost"
                            />
                        </div> -->

                        <div>
                            <Label value="ISBN" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].isbn"
                            />
                        </div>

                        <div>
                            <Label value="CRL" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].crl"
                            />
                        </div>

                        <!-- <div>
                            <Label value="Link" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].link"
                            />
                        </div> -->
                    </div>

                    <div class="w-full text-right">
                        <Button
                            type="button"
                            class="btn-danger border-4"
                            @click="addVolume()"
                        >
                            (+) Add Volume
                        </Button>
                    </div>
                    <h3 class="text-lg text-gray-600 font-bold">Printing Section</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                    >
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
                                <!-- <option value="1">Juce and Auto Binding</option> -->
                                <option v-for="(printingPress, printingId) in data.presses" :value="printingId" :key="printingId">{{ printingPress }}</option>
                            </Select>
                        </div>

                    </div>
                        <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                        >
                            <div>
                                <table class="w-full min-w-max">

                                    <tbody>
                                        <tr
                                            class="border-b"
                                            v-for="(priceDetailsCategoryKey,index) in data.printing_details_category_keys"
                                            :key="priceDetailsCategoryKey.id"
                                        >
                                            <td
                                                class="
                                                    text-right
                                                    px-2
                                                    py-1
                                                    border-r border-l
                                                "
                                            >
                                                {{ priceDetailsCategoryKey.name }}
                                            </td>
                                            <td class="text-left px-2 py-1 border-r" >
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
                <div class="w-full max-w-md">
                   <Moderators :form ="form" :data="data"/>
                </div>
            </div>

             <!-- <div class="w-full max-w-md">
                  <nav-link class="" :href="route('printing-details.create',data.version.id)">
                        Cost Details
                 </nav-link>
            </div> -->
            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('versions.index')" />
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
        <!-- <div class="">
            Calculator
        </div> -->
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
import NavLink from "@/Components/NavLink.vue";

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
        NavLink
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
                production_id: this.data.version.production_id || "",
                edition: this.data.version.edition || "",
                release_date: this.data.version.release_date || "",
                production_cost: this.data.version.production_cost || "",
                link: this.data.version.link || "",
                type: this.data.version.type || "",
                page: '',
                copy_quantity: '',
                binding_type: '',
                press: '',
                storing_at: '',
                is_place_storable: '',
                price_details : [],
                active: this.moduleAction == "store" ? 1 : this.data.version.active,
                volumes: [
                    {
                        name: "",
                        isbn: "",
                        crl: "",
                    },
                ],
                moderators: [
                    {
                        author_id: "",
                        moderator_type: "",
                        honorarium_type: "",
                        honorarium: "",
                    },
                ],
                moduleAction: this.moduleAction
            }),
            storigngAtVisibility : false
        };
    },
    created() {
        for(let index in this.data.volumes) {
            console.log('volumes', index);
            this.form.volumes[index] = this.data.volumes[index] ? this.data.volumes[index] : '';
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
        addVolume() {
            this.form.volumes.push({
                name: "",
                isbn: "",
                crl: "",
            });
        },
        addModertor() {
            this.form.moderators.push({
                authorId: "",
                moderatorType: "",
                honorariumType: "",
                honorarium: "",
            });
        },

        copyVolume(id) {
            appendableDiv.innerHTML += singleWrapper;
        },

        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("versions.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("versions.update", this.data.version.id)
                );
            }
        },
    },
};
</script>
