<template>

    <Head title="User" />

    <app-layout>
        <template #header>
            User List
        </template>

        <add-new-button :href="route('users.create')" v-if="$can('Admin Create')" />

        <data-table :collections="users" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns"
            :latest="true">
            <!-- <template #head>
                <th class="py-3 px-2 text-left">ID</th>
                <th class="py-3 px-2 text-left">Name</th>
                <th class="py-3 px-2 text-left">Email</th>
                <th class="py-3 px-2 text-left">Phone</th>
                <th class="py-3 px-2 text-left">Type</th>
                <th class="py-3 px-2 text-left">Active</th>
                <th class="py-3 px-2 text-center">Action</th>
            </template> -->
            <template #default="{ item: user }">
                <td class="py-3 px-2 text-left">{{ user.id }}</td>
                <td class="py-3 px-2 text-left">{{ user.name }}</td>
                <td class="py-3 px-2 text-left">{{ user.email }}</td>
                <td class="py-3 px-2 text-left">{{ user.phone }}</td>
                <td class="py-3 px-2 text-left">{{ user.typeName }}</td>
                <td class="py-3 px-2 text-left">
                    <span class="py-1 px-3 rounded-full text-white font-bold"
                        :class="{ 'bg-green-500' : user.active, 'bg-red-500' : !user.active }">
                        {{ user.activeValue }}
                    </span>
                </td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('users.show', user.id)" v-if="$can('Admin List')" />
                        <action-button-edit :href="route('users.edit', user.id)" v-if="$can('Admin Edit')" />
                    </div>
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
        users: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns: [
                {title: 'ID', align: 'left', sortable: 'id'},
                {title: 'Name', align: 'left', sortable: 'name'},
                {title: 'Email', align: 'left', sortable: 'email'},
                {title: 'Phone', align: 'left', sortable: 'phone'},
                {title: 'Type', align: 'left', sortable : 'type'},
                {title: 'Active', align: 'center', sortable : 'active'},
                {title: 'Action', align: 'center'},
            ],
        }
    },
};
</script>
