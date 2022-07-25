<template>
    <div class="fixed inset-0 z-50 text-black" :class="{ hidden: !modelValue }">
        <div class="relative w-full h-full flex justify-center items-center">
            <div
                class="relative p-2 w-full max-w-7xl bg-white rounded border shadow z-50"
            >
                <div class="text-center">
                    <div class="font-bold text-sm">Sl: {{ item.id }}</div>

                    <div
                        class="font-bold text-lg"
                        v-if="your_outlets && item.requested_by"
                    >
                        {{ item.requested_by.name }}
                        {{
                            item.requested_by.name == "Your Outlet"
                                ? `(${your_outlets[from]})`
                                : ""
                        }}
                    </div>

                    <!-- <div>Show: {{ show }}</div> -->
                    <div
                        class="font-extrabold text-base"
                        v-if="item.product_info"
                    >
                        {{ item.product_info.product_name }}
                    </div>
                    <div class="text-base" v-if="item.current_storage">
                        Current Storage:
                        <span class="font-extrabold"
                            >{{ item.current_storage }} pcs</span
                        >
                    </div>
                    <div>
                        <span
                            class="px-2 rounded-sm font-extrabold"
                            :class="{
                                'text-blue-500': item.type == 1,
                                'text-red-500': item.type == 2,
                            }"
                        >
                            {{ item.type_name }}
                        </span>
                        <span class="font-bold text-base"
                            >{{ item.product_quantity }} pcs</span
                        >
                        to
                        <span
                            class="font-extrabold text-base"
                            v-if="item.requested_to"
                        >
                            {{ item.requested_to.name ?? "all" }}</span
                        >
                        <div class="text-sm">
                            Expected Date:
                            <span class="font-extrabold text-base">{{
                                item.expected_date
                            }}</span>
                        </div>
                    </div>
                </div>
                <hr class="my-1" />
                <div class="p-3 overflow-scroll h-96">
                    <div class="bg-white rounded border shadow z-50">
                        <div class="p-3 grid grid-cols-12 gap-2">
                            <div class="col-span-6 border-r-2">
                                <div class="flex justify-between">
                                    <h1 class="underline font-extrabold">
                                        On The Way
                                    </h1>
                                    <div
                                        class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                        v-if="
                                            button_access.includes('stock_out')
                                        "
                                        @click="enableSending"
                                    >
                                        Send
                                    </div>
                                    <div class="fixed inset-0 z-50 hidden sendModal">
                                        <div
                                            class="relative w-full h-full flex justify-center items-center"
                                        >
                                            <div
                                                class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                            >
                                                <div
                                                    class="text-lg font-bold text-center"
                                                >
                                                    Send
                                                </div>
                                                <div
                                                    class="text-center text-red-500"
                                                >
                                                    Currrent Storage :
                                                    <span class="font-bold"
                                                        >{{
                                                            item.current_storage
                                                        }}
                                                        pcs</span
                                                    >
                                                </div>
                                                <hr class="my-1" />
                                                <div class="p-3">
                                                    <form
                                                        @submit.prevent="send"
                                                        class=""
                                                    >
                                                        <Label
                                                            value="Send Quantity"
                                                        />
                                                        <input
                                                            type="number"
                                                            class="mt-1 block w-full"
                                                            placeholder="Quantity"
                                                            v-model="
                                                                form.quantity
                                                            "
                                                            required
                                                        />
                                                        <Select
                                                            v-if="
                                                                item.type ==
                                                                    2 &&
                                                                !item
                                                                    .requested_to
                                                                    .id
                                                            "
                                                            class="mt-1 block w-full"
                                                            name=""
                                                            id=""
                                                            v-model="form.to"
                                                            required
                                                        >
                                                            <option value="">
                                                                Select
                                                            </option>
                                                            <option
                                                                v-for="(
                                                                    outlet,
                                                                    index
                                                                ) in outlets"
                                                                :key="index"
                                                                :value="index"
                                                            >
                                                                {{ outlet }}
                                                            </option>
                                                        </Select>
                                                        <div
                                                            v-if="
                                                                item.type ==
                                                                    2 &&
                                                                item
                                                                    .requested_to
                                                                    .id
                                                            "
                                                        >
                                                            Send to
                                                            {{
                                                                item
                                                                    .requested_to
                                                                    .name
                                                            }}
                                                            {{
                                                                item
                                                                    .requested_to
                                                                    .id
                                                            }}
                                                        </div>
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
                                </div>

                                <div
                                    class="border-2 shadow rounded-md px-2 my-2 mr-2"
                                    :class="{
                                        'bg-green-200':
                                            Math.abs(circulation.quantity) <=
                                            circulation.total_received,
                                    }"
                                    v-for="circulation in circulations"
                                    :key="circulation"
                                >
                                    <span class="text-sm">
                                        {{ circulation.circulationDate }}
                                    </span>
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
                                        </div>
                                        <div class="pb-2">
                                            <div
                                                class="px-2 mr-2 bg-gray-500 text-white rounded cursor-pointer"
                                                v-if="
                                                    button_access.includes(
                                                        'stock_in'
                                                    ) &&
                                                    Math.abs(
                                                        circulation.quantity
                                                    ) >
                                                        circulation.total_received
                                                "
                                                @click="
                                                    form.circulation_id =
                                                        circulation.id;
                                                    enableRecieve($event);
                                                "
                                            >
                                                Recieve
                                            </div>

                                            <div
                                                class="fixed inset-0 z-50 hidden recieveModal"
                                            >
                                                <div
                                                    class="relative w-full h-full flex justify-center items-center"
                                                >
                                                    <div
                                                        class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                    >
                                                        <div
                                                            class="text-sm text-center"
                                                        >
                                                            {{
                                                                circulation.quantity <
                                                                0
                                                                    ? " Sends "
                                                                    : " Recieved "
                                                            }}
                                                            <span
                                                                class="font-bold"
                                                            >
                                                                {{
                                                                    Math.abs(
                                                                        circulation.quantity
                                                                    )
                                                                }}
                                                                pcs
                                                            </span>

                                                            and Recieved
                                                            <span
                                                                class="font-bold"
                                                            >
                                                                {{
                                                                    circulation.total_received
                                                                }}
                                                                pcs
                                                            </span>
                                                        </div>
                                                        <hr class="my-1" />
                                                        <div class="p-3">
                                                            <form
                                                                @submit.prevent="
                                                                    recieve
                                                                "
                                                                class=""
                                                            >
                                                                <Label
                                                                    value="Recieve Quantity"
                                                                />
                                                                <input
                                                                    type="number"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Quantity"
                                                                    v-model="
                                                                        form.quantity
                                                                    "
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
                                                            @click="
                                                                closeSubModal
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-5"
                                        v-for="circulation in circulation.circulations"
                                        :key="circulation"
                                    >
                                        <span class="text-sm">
                                            {{ circulation.circulationDate }}
                                        </span>
                                        <div>
                                            <!-- {{ circulation }} -->
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6">
                                <div class="flex justify-between">
                                    <h1 class="underline font-extrabold">
                                        Responses
                                    </h1>
                                    <div class="">
                                        <span
                                            class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                            v-if="
                                                button_access.includes(
                                                    'request_accept'
                                                )
                                            "
                                            @click="
                                                modalHandler($event);
                                                form.request_id = item.id;
                                            "
                                        >
                                            Accept
                                        </span>
                                        <div class="fixed inset-0 z-50 hidden acceptModal">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-sm text-center"
                                                    >
                                                        Accept
                                                    </div>
                                                    <hr class="my-1" />
                                                    <div class="p-3">
                                                        <form
                                                            @submit.prevent="
                                                                accept
                                                            "
                                                            class=""
                                                        >
                                                            <input
                                                                type="number"
                                                                class="mt-1 block w-full"
                                                                placeholder="Accept Quantity"
                                                                v-model="
                                                                    form.accept_quantity
                                                                "
                                                                required
                                                            />
                                                            <input
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                placeholder="Note"
                                                                v-model="
                                                                    form.note
                                                                "
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
                                            class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                            v-if="
                                                button_access.includes(
                                                    'request_deny'
                                                )
                                            "
                                            @click="
                                                modalHandler($event);
                                                form.request_id = item.id;
                                            "
                                        >
                                            Deny
                                        </span>
                                        <div class="fixed inset-0 z-50 hidden denyModal">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-sm text-center"
                                                    >
                                                        Deny
                                                    </div>
                                                    <hr class="my-1" />
                                                    <div class="p-3">
                                                        <form
                                                            @submit.prevent="
                                                                deny
                                                            "
                                                        >
                                                            <input
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                placeholder="Note"
                                                                v-model="
                                                                    form.note
                                                                "
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
                                            class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                            v-if="
                                                button_access.includes(
                                                    'request_edit'
                                                )
                                            "
                                            @click="enableEditing"
                                        >
                                            Edit
                                        </span>
                                        <div class="fixed inset-0 z-50 hidden editModal">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-sm text-center"
                                                    >
                                                        Edit
                                                    </div>
                                                    <hr class="my-1" />
                                                    <div class="p-3">
                                                        <form
                                                            @submit.prevent="
                                                                edit
                                                            "
                                                        >
                                                            <input
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                placeholder="Quantity"
                                                                v-model="
                                                                    form.request_quantity
                                                                "
                                                                required
                                                            />
                                                            <input
                                                                type="date"
                                                                class="mt-1 block w-full"
                                                                placeholder="Quantity"
                                                                v-model="
                                                                    form.expected_date
                                                                "
                                                                required
                                                            />

                                                            <Select
                                                                class="mt-1 block w-full"
                                                                name=""
                                                                id=""
                                                                v-model="
                                                                    form.type
                                                                "
                                                            >
                                                                <option
                                                                    v-for="(
                                                                        type,
                                                                        index
                                                                    ) in types"
                                                                    :key="index"
                                                                    :value="
                                                                        index
                                                                    "
                                                                >
                                                                    {{ type }}
                                                                </option>
                                                            </Select>
                                                            <Select
                                                                class="mt-1 block w-full"
                                                                name=""
                                                                id=""
                                                                v-model="
                                                                    form.requested_to
                                                                "
                                                            >
                                                                <option
                                                                    value=""
                                                                >
                                                                    To All
                                                                </option>
                                                                <option
                                                                    v-for="(
                                                                        outlet,
                                                                        index
                                                                    ) in outlets"
                                                                    :key="index"
                                                                    :value="
                                                                        index
                                                                    "
                                                                >
                                                                    {{ outlet }}
                                                                </option>
                                                            </Select>
                                                            <input
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                placeholder="Note"
                                                                v-model="
                                                                    form.note
                                                                "
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
                                            class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                            v-if="
                                                button_access.includes(
                                                    'request_close'
                                                )
                                            "
                                            @click="
                                                modalHandler($event);
                                                form.request_id = item.id;
                                            "
                                        >
                                            Close
                                        </span>
                                        <div class="fixed inset-0 z-50 hidden closeModal">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-sm text-center"
                                                    >
                                                        Close
                                                    </div>
                                                    <hr class="my-1" />
                                                    <div class="p-3">
                                                        <form
                                                            @submit.prevent="
                                                                close
                                                            "
                                                        >
                                                            <input
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                placeholder="Note"
                                                                v-model="
                                                                    form.note
                                                                "
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
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between border-2 shadow rounded-md px-2 py-1 my-2 mr-2"
                                    v-for="(response, index) in item.responses"
                                    :key="response"
                                >
                                    <div>
                                        <!-- {{ response }} -->
                                        <span class="font-extrabold">
                                            {{ `${response.outlet_name} ` }}
                                        </span>
                                        <span>
                                            {{
                                                `${
                                                    response.status_name
                                                        .charAt(0)
                                                        .toLowerCase() +
                                                    response.status_name.slice(
                                                        1
                                                    )
                                                } `
                                            }}
                                        </span>
                                        <span class="font-extrabold">
                                            {{ response.quantity }}
                                            pcs
                                        </span>
                                        responsed by
                                        <span class="font-extrabold">
                                            {{ response.user_name }}
                                        </span>

                                        <div
                                            class="overflow-auto hidden"
                                            v-if="response.note"
                                            :id="`noteShow${index}`"
                                        >
                                            <span class="text-sm font-bold"
                                                >Note:</span
                                            >
                                            <span v-html="response.note"></span>
                                        </div>
                                    </div>
                                    <div
                                        title="Details"
                                        @click="
                                            modalHandler(
                                                $event,
                                                `noteShow${index}`
                                            )
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 cursor-pointer"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            v-if="response.note"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
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
        "your_outlets",
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
                from: this.from,
                to: "",
                request_id: "",
                circulation_id: "",
                quantity: "",
                accept_quantity: "",
                type: "",
                requastable_type: "",
                note: "",
                outlet_id: "",
                expected_date: "",
                requested_to: "",
                request_quantity: "",
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
        closeSubModal(event, el) {
            this.emptyValue();
            if (el) {
                document.querySelectorAll(`${el}`).forEach((element) => {
                    element.classList.add('hidden')
                });
                return console.log(el)
            }
            event.target.parentElement.parentElement.parentElement.classList.add(
                "hidden"
            );
        },
        emptyValue() {
            // this.form.from = "";
            this.form.to = "";
            this.form.quantity = "";
            this.form.type = "";
            this.form.note = "";
            this.form.expected_date = "";
            this.form.requested_to = "";
        },
        enableSending(event) {
            console.log(this.item.requested_to.id);
            this.modalHandler(event);
            this.form.request_id = this.item.id;
            this.form.to = this.item.requested_to.id;
            // this.form.requested_to = this.item.requested_to.id ;
            this.form.type = 2;
            // this.form.requastable_type = 2;
        },
        enableRecieve(event) {
            this.modalHandler(event);
            this.form.requastable_type = 2;
            this.form.request_id = this.item.id;
            this.form.to = this.item.requested_by.id;
            this.form.type = 1;
        },
        enableEditing(event) {
            this.modalHandler(event);
            this.form.request_id = this.item.id;
            this.form.expected_date = this.item.expected_date;
            this.form.type = this.item.type;
            this.form.requested_to = this.item.requested_to.id;
            this.form.request_quantity = this.item.product_quantity;
            // this.form.note = this.item.responses[0].note;
        },
        edit() {
            return this.form.put(
                this.route("product-requests.update", this.form.request_id)
            );
        },
        close() {
             this.form.post(this.route("close", this.form.request_id), {
                onSuccess: (data) => {
                    console.log("OK", data);I
                    this.closeMainModal();
                },
             });
            return this.closeSubModal(null , '.closeModal')
        },
        send() {
            console.log(this.form.to);
            this.form.post(this.route("circulations.store"));
            return this.closeSubModal(null , '.sendModal')
             
        },
        recieve() {
            this.form.post(this.route("circulations.store"));
            return this.closeSubModal(null , '.recieveModal')

        },
        accept() {
            console.log(this.form);
            this.form.post(this.route("accept", this.form.request_id));
            return this.closeSubModal(null , '.acceptModal')
        },
        deny() {
            if (confirm("Are You sure to deny")) {
                this.form.post(this.route("deny", this.form.request_id));
                return this.closeSubModal(null , '.denyModal')

            }
            return;
            // return this.form.post(this.route("accept", this.form.request_id));
        },
    },
    components: { Label, Button, Select },
};
</script>
