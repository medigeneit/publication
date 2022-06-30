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
                    class="inline-block p-4 text-blue-600 bg-gray-300 rounded-t-lg active"
                    :class="{
                        'font-extrabold bg-blue-300': $page.url.includes(
                            `outlet_id=${outlet_id}`
                        ),
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
                        >{{ item.product_quantity }} pcs</span
                    >
                </div>
                <div class="mb-3">
                    <p class="font-extrabold text-sm unde">Expected Date:</p>
                    {{ item.expected_date }}
                </div>

                <div
                    class="inline-flex ite-ms-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                    @click="circulaitonShow = !circulaitonShow"
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
                    <div class="p-3">dfdfdfjkdhfjkdhf</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
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
