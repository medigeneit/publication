<template>
    <div class="w-full flex justify-between items-center bg-white gap-2 p-2" v-for="(moderator, index) in form.contributors"
        :key="index">

        <div class="md:w-1/2">
            <Label value="Contributor" />
            <Select
                class="mt-1 block w-full"
                v-model="form.contributors[index].author_id"

            >
                <option value="">-- Select Author --</option>
                <option
                    :value="index" v-for="(author, index) in data.authors" :key="index"
                >
                    {{ author }}
                </option>
            </Select>
        </div>

        <div class="md:w-1/2">
            <Label value="Contributor Type" />
            <Select
                class="mt-1 block w-full"
                v-model="form.contributors[index].moderator_type_id">
                <option value="">-- Select Moderator --</option>
                <option :value="type" v-for="(moderator, type) in data.moderatorTypes" :key="type">
                    {{ moderator }}
                </option>
            </Select>
        </div>
         <div class="text-center mt-4">
            <button class="text-red-500 text-2xl" @click="removeProduct(index)" type="button" >
                    &times;
            </button>
        </div>
    </div>
    <div class="w-full text-right">
        <Button
            type="button"
            class="btn-danger border-4"
            @click="addModertor()"
        >
            (+) Add Moderator
        </Button>
    </div>
    
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Select from "@/Components/Select.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
export default {
    components: {
        Button,
        Input,
        Label,
        Select,
        ActionButtonEdit
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        form: {
            type: Object,
            default: {},
        },
    },

    methods: {
        addModertor() {
            this.form.contributors.push({
                author_id: "",
                moderator_type_id: "",
            });
        },

        removeProduct(index) {
            this.form.contributors.splice(index, 1);

        },
    }
}
</script>
