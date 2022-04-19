<template>
    <Head title="Version" />

    <app-layout>
        <template #header>
            Version List
        </template>

        <add-new-button :href="route('versions.create')" />

        <data-table :collections="versions" :filters="filters" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: version }">
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('versions.show', version.id)" />
                        <action-button-edit :href="route('versions.edit', version.id)" />
                    </div>
                </td>
                <td class="py-3 px-2 text-left">{{ version.id }}</td>
                <td class="py-3 px-2 text-left">{{ version.name }}</td>
                <td class="py-3 px-2 text-left">{{ version.edition }}</td>
                <td class="py-3 px-2 text-left">{{ version.typeName }}</td>
                <td class="py-3 px-2 text-left">{{ version.releaseDate }}</td>
                <td class="py-3 px-2 text-center">
                    <div  @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ version.printings.length }} Cost Details
                    </div>
                    <div class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Cost Details</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2 bg-gray-200" v-for="(printing, index) in version.printings" :key="index">
                                        <div class="w-full flex flex-col text-left p-2">
                                            <span>Copy Quantity: {{ printing.copy_quantity }} Pc</span>
                                            <span>Page Amount: {{ printing.page_amount }} Pages</span>
                                            <span>Order Date: {{ this.formatDate(printing.order_date) }} </span>
                                            <span>Stored At: {{ printing.stored_at.name }} </span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <nav-link class="bg-green-500 hover:bg-green-600" :href="route('cost-categories',version.id)">
                                            Add New
                                        </nav-link>
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="version.type == 3" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ version.volumes.length }} Volumes
                    </div>
                    <div v-if="version.type == 3" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Volumes</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2" v-for="(volume, index) in version.volumes" :key="index">
                                        <span>{{ index + 1 }}.</span>
                                            {{ `Name: ${volume.name}` }}
                                            , {{ `ISBN: ${volume.isbn}` }}
                                            , {{ `CRL: ${volume.crl}` }}
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-center">
                    <div v-if="version.moderators.length" @click="modalHandler" class="text-center border bg-gray-500 text-white px-2 py-0.5 rounded cursor-pointer">
                        View {{ version.moderators.length }} Moderators
                    </div>
                    <div v-if="version.moderators.length" class="fixed inset-0 hidden z-50">
                        <div class="relative w-full h-full flex justify-center items-center">
                            <div class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50">
                                <div class="text-lg font-bold text-center">Moderators</div>
                                <hr class="my-1">
                                <div class="p-3">
                                    <div class="py-1.5 flex gap-2 mr-10" v-for="(moderator, index) in version.moderators" :key="index">
                                        {{ moderator.moderators_type.name }} :   {{ moderator.author.name }}
                                    </div>
                                </div>
                                <div class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40" @click="closeModal">&times;</div>
                            </div>
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                                <div class="w-full h-full" @click="closeModal"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500': version.active, 'bg-red-500': !version.active }">
                        {{ version.activeValue }}
                    </span>
                </td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from '@/Components/AddNewButton.vue';
import NavLink from "@/Components/NavLink.vue";

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        NavLink
    },
    props: {
        versions: { type: Object, default: {} },
        filters: { type: Object, default: {} }
    },
    methods: {
        modalHandler(event) {
            event.target.nextElementSibling.classList.toggle('hidden');
        },
        closeModal(event) {
            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
        formatDate(input) {

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
    },
    data() {
        return {
           columns: [
                    {title: 'Action', align: 'center'},
                    {title: 'ID', align: 'left', sortable: 'id'},
                    {title: 'Production', align: 'left', sortable: 'production_id'},
                    {title: 'Edition', align: 'left', sortable: 'edition'},
                    {title: 'Type', align: 'left', sortable: 'type'},
                    {title: 'Date', align: 'left', sortable: 'release_date'},
                    {title: 'Cost Details', align: 'left'},
                    {title: 'Show Volumes', align: 'left'},
                    {title: 'Show Moderators', align: 'left'},
                    {title: 'Active', align: 'left', sortable: 'active'},
                ],
        }
    },
};
</script>
