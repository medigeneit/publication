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
                    <Label for="type" value="Type" />
                    <Select
                        name="type"
                        class="mt-1 block w-full"
                        v-model="form.type"
                        required
                    >
                        <option value="0">--Select Type--</option>
                        <option
                            :value="type"
                            v-for="(typeName, type) in data.distributorType"
                            :key="type"
                        >
                            {{ typeName }}
                        </option>
                    </Select>
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
                            <optgroup :label="division.name" v-for="division in divisions" :key="division.id">
                                <option :value="district.id" v-for="district in division.districts" :key="district.id">
                                    {{ district.name }}
                                </option>
                            </optgroup>
                        </Select>
                        <!-- {{ divisions }} -->
                        <Select
                            class="block w-full"
                            v-model="form.area_id"
                        >
                            <option value="">-- Area --</option>

                            <option :value="area.id" v-for="area in customAreas" :key="area.id">
                                {{ area.name }}
                            </option>
                        </Select>
                    </div>
            </div>

            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('distributors.index')" />
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
import Select from "@/Components/Select.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import axios from "axios";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
    Button,
    Input,
    Label,
    ValidationErrors,
    GoToList,
    Select,
    Textarea
},

    props: {
        data: { type: Object, default: {} },
        moduleAction: String,
        buttonValue: { type: String, default: "Submit" },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.distributor.name,
                address: this.data.distributor.address,
                phone: this.data.distributor.phone,
                email: this.data.distributor.email,
                type: this.data.distributor.type || 0,
                active:
                    this.moduleAction == "store"
                        ? 1
                        : this.data.distributor.active,
            }),
            userList: {},
        };
    },

    methods: {
        customerSearch() {
            console.log(this.form.phone);
            axios
                .post(this.route("user-list"), {
                    phone: this.form.phone,
                })
                .then((response) => {
                    console.log(response.data);
                    this.userList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        clientInfo(user) {
            this.form.name = user.name;
            this.form.phone = user.phone;
            this.form.email = user.email;
            this.userList = "";
        },
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("distributors.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("distributors.update", this.data.distributor.id)
                );
            }
        },
    },
};
</script>
