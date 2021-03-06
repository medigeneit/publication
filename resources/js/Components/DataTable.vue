<template>

    <div class="w-full flex flex-wrap gap-2 py-2">
        <div class="flex order-1 lg:order-2 w-full sm:w-auto" v-for="(filter, key) in filters" :key="key">
            <select @change="searchHandler" v-model="filterData[key]" :name="key" class="block w-full rounded-md shadow-sm focus:outline-none focus:ring-0">
                <option value="" selected>
                    {{ key.replaceAll('_', ' ').toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    }) }} (All)
                </option>
                <option v-for="(property, index) in filter" :key="index" :value="index">{{ property }}</option>
            </select>
        </div>

        <div v-if="dateFilter" class="ml-auto w-full lg:max-w-xl lg:w-auto flex flex-col sm:flex-row justify-between items-end gap-2 order-1 lg:order-2">
            <div class="w-full max-w-sm flex justify-end items-center gap-1">
                <select @change="dateSearchHandler" v-model="valueDateFilter" class="block w-full rounded-md min-w-max shadow-sm focus:outline-none focus:ring-0 cursor-pointer">
                    <option value="">Custom Date</option>
                    <option v-for="(varient, index) in varientDateFilter" :key="index" :value="index">{{ varient }}</option>
                </select>
            </div>
            <div class="w-full max-w-sm flex justify-end items-center gap-1">
                <!-- <label class="w-12 text-right">From</label> -->
                <input v-show="!valueDateFilter" @input="searchHandler" v-model="dateFrom" :max="this.dateTo" type="date" class="block w-full max-w-xs rounded-md shadow-sm focus:outline-none focus:ring-0" />
            </div>
            <div class="w-full max-w-sm flex justify-end items-center gap-1">
                <!-- <label class="w-12 text-right">To</label> -->
                <input v-show="!valueDateFilter" @input="searchHandler" v-model="dateTo" :min="this.dateFrom" type="date" class="block w-full max-w-xs rounded-md shadow-sm focus:outline-none focus:ring-0" />
            </div>
        </div>

        <div class="sm:w-24 flex order-2 lg:order-1">
            <select @change="searchHandler" v-model="perpage" class="block w-full rounded-md shadow-sm focus:outline-none focus:ring-0 cursor-pointer">
                <option v-for="pageLengthItem in pageLength" :key="pageLengthItem" :value="pageLengthItem">{{ pageLengthItem }}</option>
            </select>
        </div>

        <div class="ml-auto w-2/3 max-w-xs lg:w-auto flex order-4 lg:order-4">
            <input @input="searchHandler" class="block w-full rounded-md shadow-sm focus:outline-none focus:ring-0" type="search" v-model="search" placeholder="Search here ..." />
        </div>
    </div>

    <div v-if="collections.meta.total && topLinks" class="w-full p-1">
        <paginator-links :collections="collections" />
    </div>

    <div class="overflow-auto relative">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                    <!-- <th v-if="serialColumn" class="py-3 px-2 text-left sticky left-0 bg-blue-600">SL</th> -->

                    <th v-if="serialColumn" class="py-3 px-2 text-left sticky left-0 bg-blue-600">
                        <div class="inline-flex items-center gap-1">
                            <div>SL</div>
                            <div class="flex flex-col cursor-pointer"  @click="sortDirectionHandler">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </div>
                        </div>
                    </th>

                    <th v-for="(column, index) in columns" :key="index" class="py-3 px-2 bg-blue-600" :class="{ 'text-left': column.align == 'left', 'text-center': column.align == 'center', 'text-right': column.align == 'right' }">
                        <div class="inline-flex items-center gap-1">
                            <div v-html="column.title"></div>
                            <div v-if="column.sortable" class="flex flex-col cursor-pointer"  @click="sortHandler(column.sortable)" :class="{ 'text-gray-900': column.sortable != this.sort }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </div>
                        </div>
                    </th>

                    <slot name="head"/>

                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm font-light bg-white">

                <tr v-for="(item, index) in collections.data" :key="index" class="border-b border-gray-200 hover:bg-gray-50">
                    <td v-if="serialColumn" class="py-3 px-2 text-left sticky left-0 bg-white">
                        {{ sortNewToOld ? (collections.meta.total + 1) - (collections.meta.from + index) : (collections.meta.from + index) }}
                    </td>

                    <slot :item="item" />
                </tr>

                <tr v-if="! collections.meta.total" class="border-b border-gray-200 hover:bg-gray-50">
                    <td colspan="100" class="py-3 px-2 text-center text-red-500">
                        No data found !!
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="collections.meta.total && bottomLinks" class="w-full p-1">
        <paginator-links :collections="collections" />
    </div>

</template>

<script>
import Label from './Label.vue';
import PaginatorLinks from './PaginatorLinks.vue';
import { usePage } from '@inertiajs/inertia-vue3'
export default {
    components: { 
        PaginatorLinks,
        Label,
    },
    computed:{
		request() {
			return usePage().props.value.request;
		}
	},
    props: {
        dateFilter: {
            type: Boolean,
            default: false
        },
        serialColumn: {
            type: Boolean,
            default: true
        },
        latest: {
            type: Boolean,
            default: false
        },
        routeName: {
            type: String,
            default: null
        },
        topLinks: {
            type: Boolean,
            default: false
        },
        bottomLinks: { 
            type: Boolean,
            default: true
        },
        pageLength: {
            type: Array,
            default: [100, 50, 25, 15, 10]
        },
        varientDateFilter: {
            type: Object,
            default: {
                7: "Last 7 days",
                15: "Last 15 days",
                30: "Last 30 days",
                90: "Last 90 days",
                180: "Last 180 days",
                365: "Last 365 days",
            }
        },
        collections: {
            type: Object,
            default: {}
        },
        filters: {
            type: Object,
            default: {}
        },
        columns: {
            type: Array,
            default: []
        },
    },
    created() {
        Object.entries(this.filters).forEach( ([key, value]) => {
            this.filterData[key] = this.request[key] || ''
        });

        this.dateFrom = this.request.from || '';

        this.dateTo = this.request.to || '';

        this.search = this.request.search || '';

        this.sortNewToOld = this.request.order == 'desc' ? true : this.latest;

        localStorage.setItem('historyOfList', this.route(this.routeName || this.route().current()));
    },
    data() {
        return {
            perpage: this.collections.meta.per_page,
            search: '',
            filterData: {},
            data: {},
            dateFrom: '',
            dateTo: '',
            valueDateFilter: '',
            sortDirection: '',
            sort: '',
        }
    },
    methods: {
        searchHandler() {
            this.data['perpage'] = this.perpage;

            Object.entries(this.filterData).forEach( ([key, value]) => {
                this.data[key] = value;
            });

            this.data['from'] = this.dateFrom;

            this.data['to'] = this.dateTo;

            this.data['sort'] = this.sort;

            this.data['order'] = this.sortDirection;

            this.data['search'] = this.search;

            let url = this.route((this.routeName || this.route().current()), this.clean(this.data));

            localStorage.setItem('historyOfList', url);

            this.$inertia.get(url, {}, { preserveState: true });
        },
        dateSearchHandler(event) {
            const days = parseInt(event.target.value);

            const dateForTo = new Date();

            const dateForFrom = new Date(dateForTo.getTime() - (days * 24 * 60 * 60 * 1000));

            if(days) {
                this.dateFrom = `${dateForFrom.getFullYear()}-${(dateForFrom.getMonth() + 1).toString().padStart(2, '0')}-${dateForFrom.getDate().toString().padStart(2, '0')}`;
                this.dateTo = `${dateForTo.getFullYear()}-${(dateForTo.getMonth() + 1).toString().padStart(2, '0')}-${dateForTo.getDate().toString().padStart(2, '0')}`;
            } else {
                this.dateFrom = "";
                this.dateTo = "";
            }

            this.searchHandler();
        },
        clean(obj) {
            for (var propName in obj) {
                if (obj[propName] === '' || obj[propName] === null || obj[propName] === undefined) {
                    delete obj[propName];
                }
            }
            return obj;
        },
        sortHandler(value) {
            this.sortDirection = (this.sort == value && this.sortDirection == 'asc') ? 'desc' : 'asc';

            this.sort = value;

            this.sortNewToOld = this.sortDirection == 'desc' ? true : false;

            this.searchHandler();
        },
        sortDirectionHandler() {
            this.sortDirection = this.sortDirection == 'asc' ? 'desc' : 'asc';

            this.sortNewToOld = this.sortDirection == 'desc' ? true : false;

            this.searchHandler();
        }
    }
}
</script>
