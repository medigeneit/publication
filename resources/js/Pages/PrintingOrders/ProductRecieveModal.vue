<template>
    <div class="fixed inset-0 z-50 text-black" :class="{ hidden: !modelValue }">
        <div class="relative w-full h-full flex justify-center items-center">
            <div
                class="relative p-2 w-full max-w-7xl bg-white rounded border shadow z-50"
            >
                <div class="text-center">
                    <div class="font-bold text-sm">Sl: {{ item.id }}</div>

                    <!-- <div>Show: {{ show }}</div> -->
                    <div
                        class="font-extrabold text-base"
                        v-if="item.product_name"
                    >
                        {{ item.product_name }}
                    </div>
                    <div class="text-base" v-if="item.current_storage">
                        Current Storage:
                        <span class="font-extrabold"
                            >{{ item.current_storage }} pcs</span
                        >
                    </div>
                    <div>
                        <span class="px-2 rounded-sm"> Copy Order </span>
                        <span class="font-bold text-base"
                            >{{ item.copy_quantity }} pcs</span
                        >
                        to
                        <span
                            class="font-extrabold text-base"
                            v-if="item.press"
                        >
                            {{ item.press }}</span
                        >
                        <div class="text-sm">
                            Order Date:
                            <span class="font-extrabold text-base">{{
                                item.expected_date
                            }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span
                        class="px-2 mr-2 bg-gray-500 text-white rounded cursor-pointer"
                        @click="enableRecieve($event)"
                    >
                        Recieve
                    </span>
                    <div class="fixed inset-0 z-50 hidden">
                        <div
                            class="relative w-full h-full flex justify-center items-center"
                        >
                            <div
                                class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                            >
                                <div class="text-sm text-center">Recieve</div>
                                <hr class="my-1" />
                                <div class="p-3">
                                    <form @submit.prevent="recieve" class="">
                                        <Label value="Recieve Quantity" />
                                        <input
                                            type="number"
                                            class="mt-1 block w-full"
                                            placeholder="Quantity"
                                            v-model="form.quantity"
                                            required
                                        />
                                        <Button
                                            type="submit"
                                            class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                        >
                                            Submit
                                        </Button>
                                    </form>
                                </div>
                            </div>
                            <div
                                class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                            >
                                <div
                                    class="w-full h-full"
                                    @click="closeSubModal"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <span
                        class="px-2 mr-2 bg-gray-500 text-white rounded cursor-pointer"
                        @click="close"
                    >
                        Close
                    </span>
                </div>

                <hr class="my-1" />
                <div class="p-3 overflow-scroll h-96">
                    <div class="bg-white rounded border shadow z-50">
                        <div class="p-3 gap-2">
                            <div class="text-center">
                                <h1>Recieve History</h1>
                                <div
                                    class="border-2 shadow rounded-md px-2 my-2 mr-2"
                                    :class="{
                                        'bg-green-200':
                                            Math.abs(circulation.quantity) <=
                                            circulation.total_received,
                                    }"
                                    v-for="circulation in item.circulations"
                                    :key="circulation"
                                >
                                    <div class="flex justify-between">
                                        <div>
                                            <span class="font-extrabold">
                                                {{ circulation.circulation_of }}
                                            </span>
                                            <span>
                                                {{
                                                    circulation.quantity < 0
                                                        ? " sends "
                                                        : " recieved "
                                                }}
                                            </span>
                                            <span class="font-extrabold">
                                                {{
                                                    Math.abs(
                                                        circulation.quantity
                                                    )
                                                }}
                                                pcs
                                            </span>
                                            <span>
                                                {{
                                                    circulation.quantity < 0
                                                        ? " to "
                                                        : " from "
                                                }}
                                            </span>
                                            <span class="font-extrabold">
                                                {{ circulation.destination }}
                                            </span>
                                            in
                                            <span class="font-extrabold">
                                                {{ circulation.circulationDate }}
                                            </span>
                                            by
                                            <span class="font-extrabold">
                                                {{ circulation.userName }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40"
                    @click="closeMainModal"
                >
                    &times;
                </div>
            </div>
            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                <div class="w-full h-full" @click="closeMainModal"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Select from "@/Components/Select.vue";

export default {
    name: "product-request-modal",
    props: [
        "item",
        "modelValue",
        "from",
        "types",
        "outlets",
        "filters",
    ],
    components: {
        Label,
        Select,
        Button,
        Input,
    },
    data() {
        return {
            form: this.$inertia.form({
                print_order_id: "",
                requastable_type: "",
                from: "",
                to: "",
                quantity: "",
                type: "",
            }),
        };
    },
    computed: {
        circulations() {
            return Array.isArray(this.item.circulations)
                ? this.item.circulations
                : [];
        },
        button_access() {
            return Array.isArray(this.item.button_access)
                ? this.item.button_access
                : [];
        },
    },
    methods: {
        closeMainModal() {
            this.$emit("update:modelValue", false);
        },
        modalHandler(event, id = null) {
            if (id) {
                // return console.log(id);
                return document
                    .getElementById(`${id}`)
                    .classList.toggle("hidden");
            }
            event.target.nextElementSibling.classList.toggle("hidden");
        },
        closeSubModal(event) {
            this.emptyValue();
            event.target.parentElement.parentElement.parentElement.classList.add(
                "hidden"
            );
        },
        emptyValue() {
            // this.form.from = "";
            this.form.print_order_id = "";
            this.form.requastable_type = "";
            this.form.from = "";
            this.form.to = "";
            this.form.quantity = "";
        },
        enableRecieve(event) {
            this.modalHandler(event);
            this.form.print_order_id = this.item.id;
            this.form.requastable_type = 1;
            this.form.from = this.item.press_id;
            this.form.to = 1;
            this.form.type = 1;
        },
        close() {
            // return console.log(this.item.id)
            return this.form.post(this.route("printing-close", this.item.id), {
                onSuccess: (data) => {
                    console.log("OK", data);
                    this.closeMainModal();
                },
            });
        },
        recieve() {
            return this.form.post(this.route("circulations.store"));
        },
    },
    components: { Label, Button, Select },
};
</script>
