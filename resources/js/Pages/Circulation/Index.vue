<template>
    <Head title="Circulation" />

    <app-layout>
        <template #header>
            Circulation List
        </template>

        <!-- <add-new-button :href="route('circulations.create')" /> -->

        <data-table :collections="circulations" :filters="filters" :dateFilter="true" :top-links="true" :columns="columns" :latest="true">
            <template #default="{ item: circulation }">
                <td class="py-3 px-2 text-left">{{ circulation.id }}</td>
                <td class="py-3 px-2 text-left">{{ circulation.destination }}</td>
                <td class="py-3 px-2 text-left">{{ circulation.productName }}</td>
                <td class="py-3 px-2 text-left">{{ circulation.quantity }}</td>
                <td class="py-2.5 px-2">
                    <div class="flex justify-center items-center gap-1 md:gap-2">
                        <action-button-show :href="route('circulations.show', circulation.id)" />
                        <action-button-edit :href="route('circulations.edit', circulation.id)" />
                        <!-- <action-button-cerculation @click="modalHandler" /> -->
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
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import Select from '@/Components/Select.vue';

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        Input,
        Button,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        Select,
    },
    props: {
        circulations: { type: Object, default: {} },
        outlets: { type: Object, default: {} },
        filters: { type: Object, default: {} },
    },
    data() {
        return {
            columns : [
                {title: 'ID', align : 'left', sortable : 'id'},
                {title: 'Outlet Name', align : 'left', sortable : 'outlet.name'},
                {title: 'Product Name', align : 'left', sortable : 'product.name'},
                {title: 'Quantity', align : 'left', sortable : 'quantity'},
                {title: 'Action', align : 'center'},
            ],
            form: this.$inertia.form({
                from: '',
                to: '',
                quantity: '',
                type: '',
                product_id: ''
            }),
            fromDisabled: false,
            toDisabled: false,
            modalEvent: ''
        }
    },
    methods : {
        changeValue(event, id, productId) {
            let value = event.target.value;
            this.form.type = value;
            this.form.product_id = productId

            console.log(id);
            if (value == 1) {
                this.form.from = '';

                this.form.to = id;
                this.toDisabled = true
                this.fromDisabled = false
            }
            else {
                this.form.to = '';

                this.form.from = id;
                this.fromDisabled = true
                this.toDisabled = false

            }
        },

        modalHandler(event, id) {
            this.modalEvent = event
            event.target.nextElementSibling .classList.toggle('hidden');
        },

        closeModal(event) {
            this.form.from = '';
            this.form.to = '';
            this.fromDisabled = false;
            this.toDisabled = false;

            event.target.parentElement.parentElement.parentElement.classList.add('hidden');
        },
        submit() {
            return this.form.post(this.route('circulations.store'));
            this.closeModal(this.modalEvent)
        },
    }
};
</script>
