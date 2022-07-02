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
                        >{{ item.product_quantity }} pcs </span
                    >
                    to <span class="font-extrabold"> {{ item.requested_to.length ? item.requested_to.name : 'all'  }}</span>
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
            <!-- v-if="circulaitonShow" -->
            <div class="col-span-12" v-if="circulaitonShow">
                <div class="bg-white rounded border shadow z-50">
                    <div class="p-3 grid grid-cols-12 gap-2">
                        <div class="col-span-6 border-r-2">
                            <h1 class="underline font-extrabold">On The Way</h1>
                            <div
                                v-for="circulation in productRequest.circulations"
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
                                        <!-- {{
                                            $page.url.includes(
                                                `outlet_id=${circulation.circulation_of_id}`
                                            )
                                                ? " sends "
                                                : " recieved "
                                        }} -->
                                        {{
                                            circulation.quantity < 0
                                                ? " sends "
                                                : " recieved "
                                        }}
                                    </span>
                                    <span class="font-extrabold">
                                        {{ Math.abs(circulation.quantity) }} pcs
                                    </span>
                                    <span>
                                        <!-- {{
                                            $page.url.includes(
                                                `outlet_id=${circulation.circulation_of_id}`
                                            )
                                                ? " to "
                                                : " from "
                                        }} -->
                                        {{
                                            circulation.quantity < 0
                                                ? " to "
                                                : " from "
                                        }}
                                    </span>
                                    <span class="font-extrabold">
                                        {{ circulation.destination }}
                                    </span>

                                        <!-- v-for="button_access in productRequest.button_access"
                                        :key="button_access" -->
                                    <div
                                        class="float-right"
                                    >
                                        <!-- {{ button_access }} -->
                                        <div
                                            class="px-2 mr-2 bg-gray-500 text-white rounded"
                                        >
                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    productRequest.button_access.includes('stock_out')
                                                "
                                            >
                                                Send
                                            </span>
                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    productRequest.button_access.includes('stock_in')
                                                "
                                            >
                                                Recieve
                                            </span>
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
                                        <!-- {{
                                            $page.url.includes(
                                                `outlet_id=${circulation.circulation_of_id}`
                                            )
                                                ? " sends "
                                                : " recieved "
                                        }} -->
                                        {{
                                            circulation.quantity < 0
                                                ? " sends "
                                                : " recieved "
                                        }}
                                    </span>
                                    <span class="font-extrabold">
                                        {{ Math.abs(circulation.quantity) }} pcs
                                    </span>
                                    <span>
                                        <!-- {{
                                            $page.url.includes(
                                                `outlet_id=${circulation.circulation_of_id}`
                                            )
                                                ? " to "
                                                : " from "
                                        }} -->
                                        {{
                                            circulation.quantity < 0
                                                ? " to "
                                                : " from "
                                        }}
                                    </span>
                                    <span class="font-extrabold">
                                        {{ circulation.destination }}
                                    </span>
                                    <div
                                        class="float-right"
                                        v-for="button_access in productRequest.button_access"
                                        :key="button_access"
                                    >
                                        <!-- {{ button_access }} -->
                                        <!-- <div
                                            class="px-2 mr-2 bg-gray-500 text-white rounded"
                                        >
                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access == 'stock_out'
                                                "
                                            >
                                                Send
                                            </span>
                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access == 'stock_in'
                                                "
                                            >
                                                Recieve
                                            </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <h1 class="underline font-extrabold">Responses</h1>

                            <div
                            class="flex justify-between"
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
                                    reqeuest
                                </div>
                                <div class="flex">
                                    <div
                                        class=""
                                        v-for="button_access in productRequest.button_access"
                                        :key="button_access"
                                    >
                                        <div
                                            class="px-2 mr-2 bg-gray-500 text-white rounded"
                                        >
                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access ==
                                                    'request_accept'
                                                "
                                            >
                                                Accept
                                            </span>

                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access ==
                                                    'request_denie'
                                                "
                                            >
                                                Deny
                                            </span>

                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access ==
                                                    'request_edit'
                                                "
                                            >
                                                Edit
                                            </span>

                                            <span
                                                class="cursor-pointer"
                                                v-if="
                                                    button_access ==
                                                    'request_close'
                                                "
                                            >
                                                Close
                                            </span>
                                        </div>
                                    </div>
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
    },
    props: {
        productRequests: { type: Object, default: {} },
        your_outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} },
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
            productRequest: "",
            circulaitonShow: false,
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
        modalShow(event, index) {
            console.log(event.target.nextElementSibling);
            event.target.nextElementSibling.classList.toggle("hidden");
            console.log(this.items[index]);
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add(
                "hidden"
            );
        },
    },
};
</script>
