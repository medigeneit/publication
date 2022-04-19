<template>
    <Head title="Print" />

    <app-layout>
        <div class="text-center">
            <button type="button" onclick="window.print()" class="px-3 py-2 rounded bg-gray-500 text-white">
                Print
            </button>
        </div>

       <div class="">
           <span class="text-xl uppercase"><strong>Book Name :</strong> {{ printing_cost.book_name.name }} </span>
       </div>

        <div class="w-1/2 grid grid-cols-2 border border-black p-2 mb-4">
            <div class="flex flex-col">
                <span> <strong>Author : </strong> Abdur Rahman </span>
                <span> <strong>Order Date :</strong> {{ formactDate(printing_cost.order_date) }}</span>
                <span><strong>Page Amount :</strong> {{ printing_cost.page_amount }} pages</span>
            </div>
            <div class="flex flex-col">
                 <span> <strong>Copy Quantity :</strong> {{ printing_cost.copy_quantity }} pc</span> 
                 <span> <strong>Press :</strong> {{ printing_cost.press }}</span>
                 <span> <strong>Binding Type :</strong> {{ printing_cost.buinding_type }}</span>
            </div>
        </div>

        <div class="overflow-auto">
            <table class="w-1/2 table table-auto border border-b-0 print:border-black print:text-black">
                <thead class="bg-gray-100 print:bg-transparent">
                    <tr class="border-b print:border-black">
                        <th scope="col" class="border border-black px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="border border-black px-6 py-3">
                            Quantity
                        </th>
                        <th scope="col" class="border border-black px-6 py-3">
                            Rate
                        </th>
                        <th scope="col" class="border border-black px-6 py-3">
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-gray-100 print:bg-transparent" v-for="(version_cost, index) in printing_cost.version_cost" :key="index">
                        <th scope="row" class="text-left px-3 py-2 border-b border-l border-black">
                            {{ version_cost.cost_category.name }}
                        </th>
                        <td class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            {{ version_cost.quantity }} 
                        </td>
                        <td class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            {{ version_cost.rate }}
                        </td>
                        <td class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black">
                            {{ version_cost.subtotal }}
                        </td>
                    </tr>

                    <tr class="bg-gray-100 print:bg-transparent">
                        <th></th>
                        <td></td>
                        <th scope="row" class="text-left px-3 py-2 border-b border-l border-black">
                            Toatl
                        </th>
                        <td  class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black">
                           {{ sum }}
                        </td>
                    </tr>
                    <tr class="bg-gray-100 print:bg-transparent">
                        <th></th>
                        <td></td>
                        <th scope="row" class="text-left px-3 py-2 border-b border-l border-black">
                            Others
                        </th>
                        <td class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black">
                            {{ others }}
                        </td>
                    </tr>
                    <tr class="bg-gray-100 print:bg-transparent">
                        <th></th>
                        <td></td>
                        <th scope="row" class="text-left px-3 py-2 border-b border-l border-black">
                            Sub Toatal
                        </th>
                        <td class="text-center text-sm print:text-md px-3 py-2 border-b border-l border-r border-black">
                            {{ sum+others }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="overflow-auto mt-4">
            <table class="w-1/2 table table-auto border border-b-0 border-black text-black">
                <tbody>
                    <tr class="bg-gray-100 print:bg-transparent" v-for="(print_detail, index) in printing_cost.print_details" :key="index">
                        <th scope="row" class="text-left px-3 py-2 border-b border-black">
                            {{ print_detail.printing_details_category_value.printing_category_keys.name }}
                        </th>
                        <td class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            {{ print_detail.printing_details_category_value.name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="overflow-auto mt-4">
            <Label value="Note"/>
            <table class="w-1/3 table table-auto border border-b-0 border-black text-black">
                <tbody>
                    <tr class="bg-gray-100 print:bg-transparent" v-for="(print_notes, index) in printing_cost.printing_contributors" :key="index">
                        <th scope="row" class="text-left px-3 py-2 border-b border-black">
                            {{ print_notes.contribution.name}}
                        </th>
                        <td class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            {{ print_notes.contributor.name }}
                        </td>
                    </tr>
                    <tr class="bg-gray-100 print:bg-transparent">
                        <th scope="row" class="text-left px-3 py-2 border-b border-black">
                            প্লেট সংরক্ষন করা হবে কিনা
                        </th>
                        <td v-if="printing_cost.plate_stored_at.id" class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            Yes 
                        </td>
                        <td class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black" v-else>
                            No
                        </td>
                    </tr>
                    <tr class="bg-gray-100 print:bg-transparent">
                        <th scope="row" class="text-left px-3 py-2 border-b border-black">
                            কোথায় সংরক্ষন করা হবে
                        </th>
                        <td class="text-left text-sm print:text-md px-3 py-2 border-b border-l border-black">
                            {{ printing_cost.plate_stored_at.name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="w-full mt-4 flex">
            <go-to-list :href="route('printing-costs.index')"/>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from '@/Components/GoToList.vue';
import AddNewButton from '@/Components/AddNewButton.vue';
import Label from "@/Components/Label.vue";


export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
        Label
    },

    data(){
        return {
            sum:0,
            others:10
        }
    },

    props: {
        printing_cost: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },

     created(){
            Object.entries(this.printing_cost.version_cost).forEach((cost) =>{
              this.sum += cost[1].subtotal
            })
     },

     methods:{

          formactDate(input) {
            let date = new Date(input);
            let month = '' + (date.getMonth() + 1);
            let day = '' + date.getDate();
            let year = date.getFullYear();

            if (month.length < 2) {
                month = '0' + month;
            }

            if (day.length < 2) {
                day = '0' + day;
            }

            return [year, month, day].join('-');
        },

     }
};
</script>
