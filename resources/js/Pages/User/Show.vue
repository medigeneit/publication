<template>
    <Head title="User" />

    <app-layout>
        <template #header>
            {{ user.name }}
        </template>

        <add-new-button :href="route('users.create')" />
        
        <div class="overflow-auto bg-white border">
            <table class="table-auto">
                <show-table-row heading="ID">{{ user.id }}</show-table-row>

                <show-table-row heading="Name">{{ user.name }}</show-table-row>

                <show-table-row heading="Email">{{ user.email }}</show-table-row>

                <show-table-row heading="Phone">{{ user.phone }}</show-table-row>

                <show-table-row heading="Role">
                    <!-- <div v-for=" role in user.roles" :key="role">
                        {{ role }}
                    </div> -->
                    {{ Object.values(user.roles).join(', ') }}
                </show-table-row>
                <show-table-row heading="Outlets">
                    <!-- <span v-for=" outlet in user.outlets" :key="outlet">
                        {{ outlet }} {{ Object.values(user.outlets).join(',') }}
                    </span> -->
                    {{ Object.values(user.outlets).join(', ') || "All Outlets" }}
                </show-table-row>

                <show-table-row heading="Type">{{ user.typeName }}</show-table-row>

                <show-table-row heading="Active">
                    <span class="py-1 px-3 rounded-full text-white font-bold" :class="{ 'bg-green-500' : user.active, 'bg-red-500' : !user.active }">
                        {{ user.activeValue }}
                     </span>
                </show-table-row>

                <show-table-row heading="Action">
                    <div class="flex justify-start items-center gap-1 md:gap-2">
                        <action-button-edit :href="route('users.edit', user.id)" />
                    </div>
                </show-table-row>
            </table>
        </div>

        <div class="w-full mt-4 flex">
            <go-to-list :href="route('users.index')"/>
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

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
    },
    props: {
        user: { type: Object, default: {} },
    },
};
</script>
