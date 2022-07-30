<template>
    <div class="w-full max-w-full mx-auto p-4 bg-white border shadow rounded">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="flex justify-center items-center mb-4 mt-4">
                <div class="flex relative">
                    <Input
                        type="text"
                        v-model="form.phone"
                        class="block w-44"
                        placeholder="Phone"
                        required
                    />
                    <button
                        class="absolute right-0 top-2 text-sm"
                        type="button"
                        @click="customerSearch"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-center font-bold text-xl underline">
                Client Details
            </div>

            <div class="flex justify-center items-center mb-4 mt-4">
                <div>
                    <ul
                        class="bg-gray-100 text-center mb-1"
                        id="customers"
                        v-for="user in userList"
                        :key="user.id"
                        @click="clientInfo(user)"
                    >
                        <!-- {{ customer }} -->
                        {{
                            user.name
                        }}
                        {{
                            user.phone
                        }}
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="mb-4">
                    <Label for="name" value="Name" />
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autofocus
                    />
                </div>
                <div class="mb-4">
                    <Label for="email" value="Email" />
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                    />
                </div>

                <div class="mb-4">
                    <Label for="active" value="Active" />
                    <Select
                        id="active"
                        name="active"
                        class="mt-1 block w-full"
                        v-model="form.active"
                    >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </Select>
                </div>

                <div class="mb-4">
                    <Label for="address" value="Address" />
                    <Textarea
                        id="address"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.address"
                    />
                </div>
                <div class="flex gap-2 items-end mb-4">
                    <Select
                        class="block w-full"
                        v-model="form.district_id"
                        @input="selectDistrict"
                    >
                        <option value="">-- District --</option>
                        <optgroup
                            :label="division.name"
                            v-for="division in data.divisions"
                            :key="division.id"
                        >
                            <option
                                :value="district.id"
                                v-for="district in division.districts"
                                :key="district.id"
                            >
                                {{ district.name }}
                            </option>
                        </optgroup>
                    </Select>
                </div>
                <!-- {{ divisions }} -->
                <div class="flex gap-2 items-end mb-4">
                    <Select class="block w-full" v-model="form.area_id">
                        <option value="">-- Area --</option>

                        <option
                            :value="area.id"
                            v-for="area in customAreas"
                            :key="area.id"
                        >
                            {{ area.name }}
                        </option>
                    </Select>
                </div>

                <!-- <div class="flex gap-2 items-end mb-4">
                    <div class="flex">
                        <div class="w-full">
                            <Input
                                id="password"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.client_id"
                                placeholder="Client ID"
                            />
                        </div>
                        <div>
                            <button
                                type="button"
                                class="px-2 py-2 ml-2 border rounded-md mt-1 bg-green-600 text-white border-gray-500"
                                @click="clientIdGenerate"
                            >
                                Generate
                            </button>
                        </div>
                    </div>
                </div> -->
            </div>

            <hr class="w-full my-4" />

            <!-- ~~~~~~~price type card start~~~~~~~~  -->
            <div class="grid grid-cols-4 gap-2 mb-4">
                <div
                    class="border-2 p-2"
                    v-for="(priceType, index) in form.price_type_infos"
                    :key="index"
                >
                    <Select
                        id="active"
                        name="active"
                        class="mt-1 block w-full"
                        v-model="form.price_type_infos[index].id"
                    >
                        <option value="">--Price Type--</option>
                        <option
                            v-for="(priceType, priceId) of data.priceCategories"
                            :value="priceId"
                            :key="priceId"
                        >
                            {{ priceType }}
                        </option>
                    </Select>
                    <product-list
                        :products="data.productList"
                        :index="index"
                        :form="form"
                        @productSelected="selectProductHandler"
                    />
                </div>

                <div class="my-auto">
                    <Button
                        type="button"
                        class="btn-danger border-4 px-2"
                        @click="addPriceTypeInfo"
                    >
                        (+)
                    </Button>
                </div>
            </div>
            <!-- ~~~~~~~price type card end~~~~~~~~  -->

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('clients.index')" />
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
import GoToList from "@/Components/GoToList.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ProductList from "@/Components/ProductList.vue";
import Select from "@/Components/Select.vue";
import Textarea from "@/Components/Textarea.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import axios from "axios";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        Textarea,
        ProductList,
    },

    props: {
        data: { type: Object, default: {} },
        moduleAction: String,
        buttonValue: { type: String, default: "Submit" },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.client.name,
                address: this.data.client.address,
                phone: this.data.client.phone,
                email: this.data.client.email,
                area_id: "",
                client_id: "",
                address: "",
                district_id: "",
                area_id: "",
                price_type_infos: [
                    {
                        id: "",
                        product_ids: [],
                    },
                ],
                active:
                    this.moduleAction == "store" ? 1 : this.data.client.active,
            }),
            userList: {},
            customAreas: {},
            selected: [],
        };
    },

    created() {
        this.customAreas = this.data.areas;
    },

    methods: {
        customerSearch() {
            console.log(this.form.phone);
            axios
                .get(this.route("customer-list"), {
                    params: {
                     phone: this.form.phone
                   },
                })
                .then((response) => {
                    console.log(response.data.address);
                    this.userList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        selectDistrict(event) {
            this.form.area_id = "";
            if (!event.target.value) {
                return (this.customAreas = this.areas);
            }
            let customDistricts = Object.values(this.data.divisions).find(
                (division) =>
                    Object.values(division.districts).find(
                        (district) => district.id == event.target.value
                    )
            ).districts;

            return (this.customAreas = Object.values(customDistricts).find(
                (district) => district.id == event.target.value
            ).areas);
        },

        selectProductHandler(data) {
            this.form.price_type_infos[data.index].product_ids = data.selected;
        },

        clientInfo(user) {
            this.form.name = user.name;
            this.form.phone = user.phone;
            this.form.email = user.email;
            this.form.area_id = user.address.area_id;
            this.form.district_id = user.address.area.district_id;
            this.form.address = user.address.address;
            this.userList = "";
        },

        addPriceTypeInfo() {
            this.form.price_type_infos.push({
                id: "",
                product_ids: [],
            });
        },

        searchProduct(event) {
            let url = this.route(this.routeName || this.route().current(), {
                selected: this.selected.toString(),
                search: !event.target.value.includes("\\")
                    ? event.target.value
                    : "",
            });

            this.$inertia.get(url, {}, { preserveState: true });
        },
        // clientIdGenerate() {
        //     axios.get(this.route('client-id-generate'))
        //         .then((res) => {
        //             this.form.client_id = res.data;
        //         })
        //         .catch((err) => {
        //             console.log(err)
        //         })
        // },

        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("clients.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("clients.update", this.data.client.id)
                );
            }
        },
    },
};
</script>
