<template>
    <Head title="Outlet" />

    <app-layout>
        <template #header> Request </template>
        <ul
            class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200"
        >
            <li
                class="mr-2"
                v-for="(outlet, outlet_id) in your_outlets"
                :key="outlet_id"
            >
                <Link
                    :href="
                        route('product-requests.index', {
                            outlet_id: outlet_id,
                        })
                    "
                    @click="form.from = outlet_id"
                    aria-current="page"
                    class="inline-block p-2 text-gray-600 bg-gray-300 rounded-t-lg hover:bg-gray-500 hover:text-gray-200"
                    :class="{
                        'font-extrabold bg-gray-500 text-gray-200':
                            $page.url.includes(`outlet_id=${outlet_id}`),
                    }"
                    >{{ outlet }}</Link
                >
            </li>
        </ul>
        <div class="grid grid-cols-12 gap-2">
            <div
                class="col-span-6 md:col-span-4 lg:col-span-2 p-6 bg-white rounded-lg border border-white-200 shadow-md dark:bg-white-800 dark:border-white-700"
                v-for="(item, index) in productRequests.data"
                :key="index"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-white-900"
                    >
                        {{ item.requested_by.name }}
                    </h5>
                </a>
                <div class="mb-3 font-extrabold">
                    {{ item.product_info.product_name }}
                </div>
                <div class="mb-3 text-sm">
                    {{ item.type_name }}
                    <span class="text-sm font-extrabold"
                        >{{ item.product_quantity }} pcs
                    </span>
                    to
                    <span class="font-extrabold">
                        {{
                            item.requested_to.length
                                ? item.requested_to.name
                                : "all"
                        }}</span
                    >
                </div>
                <div class="mb-3">
                    <p class="font-extrabold text-sm unde">Expected Date:</p>
                    {{ item.expected_date }}
                </div>

                <div
                    class="inline-flex ite-ms-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                    @click="
                        circulaitonShow = !circulaitonShow;
                        productRequest = item;
                        form.request_id = item.id;
                    "
                >
                    See
                    <svg
                        class="ml-2 -mr-1 w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>
            </div>

            <div class="col-span-12" v-if="circulaitonShow">
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
                                        productRequest.button_access.includes(
                                            'stock_out'
                                        )
                                    "
                                    @click="modalHandler"
                                >
                                    Send
                                </div>
                                <div class="fixed inset-0 z-50 hidden">
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
                                                @click="closeModal"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="border-2 shadow rounded-md px-2 my-2 mr-2"
                                v-for="(
                                    circulation, index
                                ) in productRequest.circulations"
                                :key="circulation"
                            >
                                <span class="text-sm">
                                    {{ circulation.circulationDate }}
                                </span>
                                <div class="flex justify-between">
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
                                            {{ Math.abs(circulation.quantity) }}
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
                                                productRequest.button_access.includes(
                                                    'stock_in'
                                                )
                                            "
                                            @click="
                                                form.circulation_id =
                                                    circulation.id;
                                                modalHandler($event);
                                            "
                                        >
                                            Recieve
                                        </div>
                                        <div class="fixed inset-0 z-50 hidden">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-lg font-bold text-center"
                                                    >
                                                        {{
                                                            `${
                                                                circulation.quantity <
                                                                0
                                                                    ? " Sends "
                                                                    : " Recieved "
                                                            } ${Math.abs(
                                                                circulation.quantity
                                                            )} pcs`
                                                        }}
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
                                                        @click="closeModal"
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
                                            {{ Math.abs(circulation.quantity) }}
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
                                        <!-- <div
                                            class="float-right"
                                            v-for="button_access in productRequest.button_access"
                                            :key="button_access"
                                        ></div> -->
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
                                            productRequest.button_access.includes(
                                                'request_accept'
                                            )
                                        "
                                    >
                                        Accept
                                    </span>

                                    <span
                                        class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                        v-if="
                                            productRequest.button_access.includes(
                                                'request_denie'
                                            )
                                        "
                                    >
                                        Deny
                                    </span>

                                    <span
                                        class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                        v-if="
                                            productRequest.button_access.includes(
                                                'request_edit'
                                            )
                                        "
                                    >
                                        Edit
                                    </span>

                                    <span
                                        class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                        v-if="
                                            productRequest.button_access.includes(
                                                'request_close'
                                            )
                                        "
                                    >
                                        Close
                                    </span>
                                </div>
                            </div>
                            <div
                                class="flex justify-between border-2 shadow rounded-md px-2 py-1 my-2 mr-2"
                                v-for="response in productRequest.responses"
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
                                                response.status_name.slice(1)
                                            } `
                                        }}
                                    </span>
                                    <span class="font-extrabold">
                                        {{ response.quantity }} pcs
                                    </span>
                                    reqeuest by
                                    <span class="font-extrabold">
                                        {{ response.user_name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import Button from "@/Components/Button.vue";
import DataTable from "@/Components/DataTable.vue";
import Label from "@/Components/Label.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        Button,
        Label,
    },
    props: {
        productRequests: { type: Object, default: {} },
        your_outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    created() {
        this.form.from = this.$page.url.includes("outlet_id=")
            ? this.$page.url.split("?")[1].split("=")[1]
            : "";
    },
    data() {
        return {
            columns: [
                { title: "Request Quantity", align: "left" },
                { title: "Expected Date", align: "center" },
                { title: "Outlet", align: "center" },
                { title: "Status", align: "center" },
                { title: "Action", align: "center" },
            ],
            form: this.$inertia.form({
                from: "",
                to: "",
                request_id: "",
                circulation_id: "",
                quantity: "",
                type: "",
                requastable_type: "",
            }),
            productRequest: "",
            circulaitonShow: false,
            circulation: "",
        };
    },
    methods: {
        formatDate(input) {
            console.log(input);

            let date = new Date(input);
            let month = "" + (date.getMonth() + 1);
            let day = "" + date.getDate();
            let year = date.getFullYear();

            if (month.length < 2) {
                month = "0" + month;
            }

            if (day.length < 2) {
                day = "0" + day;
            }

            return [year, month, day].join("-");
        },
        modalHandler(event) {
            console.log(event.target.nextElementSibling);
            event.target.nextElementSibling.classList.toggle("hidden");
        },

        closeModal(event) {
            this.emptyValue();
            event.target.parentElement.parentElement.parentElement.classList.add(
                "hidden"
            );
        },
        emptyValue() {
            this.form.from = "";
            this.form.to = "";
            this.form.quantity = "";
            this.form.type = "";
        },
        send(event) {
            this.form.type = 2;
            console.log(this.form);
            return this.form.post(this.route("circulations.store"));
        },
        recieve(event) {
            this.form.type = 1;
            this.form.from = "";
            this.form.requastable_type = 2;
            console.log(this.form);
            return this.form.post(this.route("circulations.store"));
        },
    },
};
</script>
