<template>
    <Head title="Outlet" />

    <app-layout class="">
        <template #header> Request </template>
        <ul
            class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 p-2"
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
                    @click="from = outlet_id"
                    aria-current="page"
                    class="inline-block p-2 text-gray-600 bg-gray-300 rounded-t-lg hover:bg-gray-500 hover:text-gray-200"
                    :class="{
                        'font-extrabold bg-blue-500 text-gray-200':
                            $page.url.includes(`outlet_id=${outlet_id}`),
                    }"
                    >{{ outlet }}
                </Link>
            </li>
        </ul>

        <div class="grid grid-cols-12 gap-2" v-if="productRequests.data">
            <product-request-item
                v-for="item in productRequests.data"
                :key="item.id"
                :item="item"
                :class="{
                    'border border-green-600 bg-gradient-to-r from-gray-400 via-gray-200 to-white':
                        clicked[index],
                }"
                @clicked="itemClicked"
                :clicked="clicked[index]"
            ></product-request-item>
        </div>

        <product-request-modal
            v-model="modalShow"
            :item="selectedItem"
            :your_outlets="your_outlets"
            :types="types"
            :outlets="outlets"
            :filters="filters"
            :from="from"
        ></product-request-modal>
        
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import Button from "@/Components/Button.vue";
import DataTable from "@/Components/DataTable.vue";
import Label from "@/Components/Label.vue";
import Select from "@/Components/Select.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ProductRequestItem from "./ProductRequestItem.vue";
import ProductRequestModal from "./ProductRequestModal.vue";

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
        Select,
        ProductRequestItem,
        ProductRequestModal,
    },
    props: {
        productRequests: { type: Object, default: {} },
        your_outlets: { type: Object, default: {} },
        types: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    created() {
        this.from = this.$page.url.includes("outlet_id=")
            ? this.$page.url.split("?")[1].split("=")[1]
            : "";

        // console.log("FROM", s);

        this.productRequests.data.forEach((item, index) => {
            // console.log(id);
            item.responses.forEach((res) => {
                this.isClosed[index] = res.status == 5;
            });
        });
    },
    data() {
        return {
            from: "",
            productRequest: "",
            circulaitonShow: false,
            circulation: "",
            isClosed: [],
            clicked: [],
            modalShow: false,
            selectedItem: {},
        };
    },
    methods: {
        itemClicked({ item }) {
            this.circulaitonShow = !this.circulaitonShow;
            this.productRequest = this.item;

            this.clicked[item.id] = true;

            this.clickHandler(item.id);

            this.selectedItem = item;
            this.modalShow = true;
        },

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
            // this.form.from = "";
            this.form.to = "";
            this.form.quantity = "";
            this.form.type = "";
            this.form.note = "";
            this.form.expected_date = "";
            this.form.requested_to = "";
        },

        divShow(event, id) {
            console.log(event.target.nextElementSibling);
            event.target.nextElementSibling.classList.toggle("hidden");
        },
        clickHandler(index) {
            if (this.clicked.length) {
                this.clicked.length = 0;
            }
            this.clicked[index] = true;
        },
    },
};
</script>
