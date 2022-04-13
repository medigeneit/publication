<template>
    <div class="w-full grid grid-cols-2 bg-white gap-4 p-4" v-for="(moderator, index) in form.contributors"
        :key="index">

        <div class="mb-4">
            <Label value="Contributor" />
            <Select
                class="mt-1 block w-full"
                v-model="form.contributors[index].authorId"

            >
                <option value="">-- Select Author --</option>
                <option
                    :value="index" v-for="(author, index) in data.authors" :key="index"
                >
                    {{ author }}
                </option>
            </Select>
        </div>

        <div class="mb-4">
            <Label value="Contributor Type" />
            <Select
                class="mt-1 block w-full"
                v-model="form.contributors[index].moderatorType">
                <option value="">-- Select Moderator --</option>
                <option :value="type" v-for="(moderator, type) in data.moderatorTypes" :key="type">
                    {{ moderator }}
                </option>
            </Select>
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
                authorId: "",
                moderatorType: "",
            });
        },
    }
}
</script>
