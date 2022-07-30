<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                You're logged in!
            </div>
        </div> -->

        <!-- <app-layout> -->
            <div class="w-ful flex flex-wrap gap-4">
                <dashboard-card title="Admins" :count="adminCount" :href="route('users.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </dashboard-card>

                <dashboard-card title="Categories" :count="categoryCount" :href="route('categories.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Authors" :count="authorCount" :href="route('authors.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Publishers" :count="publisherCount" :href="route('publishers.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Products" :count="productCount" :href="route('products.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Outlets" :count="outletCount" :href="route('outlets.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Clients" :count="clientCount" :href="route('clients.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Sales" :count="saleCount" :href="route('sales.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>

                <dashboard-card title="Storages" :count="storageCount" :href="route('storages.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>
                
                <dashboard-card title="Accounts" :count="accountCount" :href="route('accounts.index')">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                </dashboard-card>
            </div>
        <!-- </app-layout> -->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/App.vue'
import { Head } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/App.vue";
import { Link } from "@inertiajs/inertia-vue3";
import DashboardCard from '@/Components/DashboardCard.vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppLayout,
        DashboardCard,
    },

    props: {
        adminCount: {
            type: Number,
            default: 0
        },
        categoryCount: {
            type: Number,
            default: 0
        },
        authorCount: {
            type: Number,
            default: 0
        },
        publisherCount: {
            type: Number,
            default: 0
        },
        productCount: {
            type: Number,
            default: 0
        },
        outletCount: {
            type: Number,
            default: 0
        },
        clientCount: {
            type: Number,
            default: 0
        },
        saleCount: {
            type: Number,
            default: 0
        },
        storageCount: {
            type: Number,
            default: 0
        },
        accountCount: {
            type: Number,
            default: 0
        },
    },
}
</script>
