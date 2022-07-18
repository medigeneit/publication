<template>
    <Head title="Outlet" />

    <app-layout class="">
        <template #header> Request </template>
        
        <div class="grid grid-cols-12 gap-3">
            <product-recieve-item
                v-for="item in printingOrdersList"
                :key="item.id"
                :item="item"
                
                @clicked="itemClicked"
                :clicked="clicked[item.id]"
            ></product-recieve-item>
        </div>

        <product-recieve-modal
            v-model="modalShow"
            :item="selectedItem"
            :types="types"
            :outlets="outlets"
            :filters="filters"
            :from="from"
        ></product-recieve-modal>
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
import Swal from "sweetalert2";
import ProductRecieveItem from "./ProductRecieveItem.vue";
import ProductRecieveModal from "./ProductRecieveModal.vue";

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
        ProductRecieveItem,
        ProductRecieveModal,
    },
    props: {
        printingOrders: { type: Object, default: {} },
        types: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    created() {
        // this.from = this.$page.url.includes("outlet_id=")
        //     ? this.$page.url.split("?")[1].split("=")[1]
        //     : "";

        // console.log("FROM", s);

        // this.printingOrders.data.forEach((item, index) => {
        //     // console.log(id);
        //     item.responses.forEach((res) => {
        //         this.isClosed[index] = res.status == 5;
        //     });
        // });
    },
    data() {
        return {
            from: "",
            circulaitonShow: false,
            circulation: "",
            isClosed: [],
            clicked: [],
            modalShow: false,
            selectedId: null,
        };
    },
    computed: {
        printingOrdersList() {
            return Array.isArray(this.printingOrders?.data)
                ? this.printingOrders?.data
                : [];
        },

        selectedItem() {
            const filtered = this.printingOrdersList.filter(
                (requestItem) => this.selectedId == requestItem.id
            );

            return typeof filtered[0] == "object" ? filtered[0] : {};
        },
    },
    methods: {
        itemClicked({ item }) {
            // if (!this.from) {
            //     //    return alert("please select outlet")
            //     return Swal.fire({
            //         icon: "error",
            //         html: "<b>Please Select The Outlet</b>",
            //         width: 300,
            //         height: 5,
            //         showConfirmButton: true,
            //         // timer: 1000,
            //     });
            // }

            this.circulaitonShow = !this.circulaitonShow;
            this.productRequest = this.item;

            this.clicked[item.id] = true;

            this.clickHandler(item.id);
            this.from = 1
            //this.selectedItem = item;

            this.selectedId = item.id;

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
            console.log("clicked", this.clicked);
            if (this.clicked.length) {
                this.clicked.length = 0;
            }
            this.clicked[index] = true;
        },
    },
};
</script>
