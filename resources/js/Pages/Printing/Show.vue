<template>
    <Head title="Print" />
    <app-layout>
        <div class="max-w-4xl print:max-w-6xl mx-auto space-y-4 bg-white">
            <div class="flex justify-center items-center print:hidden">
                <button
                    type="button"
                    onclick="window.print()"
                    class="px-2 py-1 mt-2 rounded bg-gray-500 text-white"
                >
                    Print
                </button>
            </div>

            <div class="max-w-2xl print:max-w-full mx-auto">
                <div class="flex flex-col">
                    <strong class="text-center text-4xl"
                        >BANGLAMED PUBLICATION</strong
                    >
                    <span class="text-center text-xl"
                        >All kinds of medical book publications</span
                    >
                </div>
                <span class="text-lg uppercase text-left"
                    ><strong>Book Name :</strong>
                    {{ printing_cost.book_name.name }}
                </span>
            </div>

            <div
                class="max-w-2xl grid grid-cols-2 print:max-w-full mx-auto border border-black p-2"
            >
                <div class="flex flex-col">
                    <span
                        v-for="author in printing_cost.version"
                        :key="author.id"
                    >
                        <strong>{{ author.moderators_type.name }} : </strong>
                        {{ author.author.name }}
                    </span>
                    <span>
                        <strong>Order Date :</strong>
                        {{ formactDate(printing_cost.order_date) }}</span
                    >
                </div>
                <div class="flex flex-col">
                    <span
                        ><strong>Page Amount :</strong>
                        {{ printing_cost.page_amount }} pages</span
                    >
                    <span>
                        <strong>Copy Quantity :</strong>
                        {{ printing_cost.copy_quantity }} pc</span
                    >
                    <span>
                        <strong>Binding Type :</strong>
                        {{ printing_cost.buinding_type }}</span
                    >
                </div>
            </div>
            <div class="max-w-2xl mx-auto print:max-w-full">
                <table
                    class="w-4/6 table table-auto border border-b-0 border-black print:border-gray-500 text-black"
                >
                    <tbody>
                        <tr
                            v-for="(
                                print_detail, index
                            ) in printing_cost.print_details"
                            :key="index"
                        >
                            <td
                                scope="row"
                                class="text-left px-2 py-1 border-b border-black"
                            >
                                {{
                                    print_detail.printing_details_category_value
                                        .parent.name ?? ""
                                }}
                            </td>
                            <td
                                class="text-left text-sm print:text-md px-2 py-1 border-b border-l border-black"
                            >
                                {{
                                    print_detail.printing_details_category_value
                                        .name
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="max-w-2xl mx-auto print:max-w-full bg-white">
                <table
                    class="w-full table table-auto border-b-0 print:w-full print:text-black"
                >
                    <thead class="">
                        <tr class="border-b print:border-black">
                            <td
                                scope="col"
                                class="border border-black px-2 py-1"
                            >
                                বিবরণ
                            </td>
                            <td
                                scope="col"
                                class="border border-black px-2 py-1"
                            >
                                পরিমান
                            </td>
                            <td
                                scope="col"
                                class="border border-black px-2 py-1"
                            >
                                রেট
                            </td>
                            <td
                                scope="col"
                                class="border border-black px-2 py-1"
                            >
                                টাকা
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="print:bg-transparent"
                            v-for="(
                                version_cost, index
                            ) in printing_cost.version_cost"
                            :key="index"
                        >
                            <td
                                scope="row"
                                class="text-left px-3 py-2 border-b border-l border-black print:text-sm"
                            >
                                {{ version_cost.cost_category.name ?? "" }}
                            </td>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-black"
                            >
                                {{ version_cost.quantity ?? "" }}
                            </td>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-black"
                            >
                                {{ version_cost.rate }}
                            </td>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black"
                            >
                                {{ version_cost.amount }}
                            </td>
                        </tr>

                        <tr class="print:bg-transparent">
                            <th></th>
                            <td></td>
                            <th
                                scope="row"
                                class="text-left px-3 py-2 border-b border-l border-black"
                            >
                                Total
                            </th>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black"
                            >
                                {{ sum }}
                            </td>
                        </tr>
                        <tr class="print:bg-transparent">
                            <th></th>
                            <td></td>
                            <th
                                scope="row"
                                class="text-left px-3 py-2 border-b border-l border-black"
                            >
                                Others
                            </th>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black"
                            >
                                {{ others }}
                            </td>
                        </tr>
                        <tr class="print:bg-transparent">
                            <th></th>
                            <td></td>
                            <th
                                scope="row"
                                class="text-left px-3 py-2 border-b border-l border-black"
                            >
                                Sub Toatal
                            </th>
                            <td
                                class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black"
                            >
                                {{ sum + others }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="max-w-2xl mx-auto print:max-w-full">
                <Label value="নোট" />
                <table
                    class="w-4/6 table table-auto border border-b-0 border-black text-black"
                >
                    <tbody>
                        <tr
                            class=""
                            v-for="(
                                print_notes, index
                            ) in printing_cost.printing_contributors"
                            :key="index"
                        >
                            <td
                                scope="row"
                                class="text-left px-2 py-1 border-b border-black"
                            >
                                {{ print_notes.contribution.name }}
                            </td>
                            <td
                                class="text-left text-sm print:text-md px-2 py-1 border-b border-l border-black"
                            >
                                {{ print_notes.contributor.name }}
                            </td>
                        </tr>
                        <tr class="">
                            <td
                                scope="row"
                                class="text-left px-2 py-1 border-b border-black"
                            >
                                প্লেট সংরক্ষন করা হবে কিনা
                            </td>
                            <td
                                v-if="printing_cost.stored_at.id"
                                class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black"
                            >
                                Yes
                            </td>
                            <td
                                class="text-left text-sm print:text-md px-2 py-1 border-b border-l border-black"
                                v-else
                            >
                                No
                            </td>
                        </tr>
                        <tr class="">
                            <td
                                scope="row"
                                class="text-left px-2 py-1 border-b border-black"
                            >
                                কোথায় সংরক্ষন করা হবে
                            </td>
                            <td
                                class="text-left text-sm print:text-md px-2 py-1 border-b border-l border-black"
                            >
                                {{ printing_cost.stored_at.name }}
                            </td>
                        </tr>
                        <tr class="">
                            <td
                                scope="row"
                                class="text-left px-2 py-1 border-b border-black"
                            >
                                ছাপাখানার নাম
                            </td>
                            <td
                                class="text-left text-sm print:text-md px-2 py-1 border-b border-l border-black"
                            >
                                {{ printing_cost.press }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="max-w-2xl print:max-w-full mx-auto flex justify-between items-center pt-4 pb-4"
            >
                <div>Prepared By</div>
                <div>Coordinator(Publication)</div>
                <div>Director(Publication)</div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import GoToList from "@/Components/GoToList.vue";
import Label from "@/Components/Label.vue";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
        Label,
    },

    data() {
        return {
            sum: 0,
            others: 10,
        };
    },

    props: {
        printing_cost: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },

    created() {
        Object.entries(this.printing_cost.version_cost).forEach((cost) => {
            this.sum += cost[1].amount;
        });
    },

    methods: {
        formactDate(input) {
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
    },
};
</script>
