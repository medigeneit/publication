<template>
    <h3 class="text-lg text-gray-600 font-bold">Moderator Information</h3>
    <div class="w-full p-4 bg-white border shadow rounded" v-for="(moderator, index) in form.moderators"
        :key="index">

        <div class="text-right mt-0">
            <button class="text-red-400 hover:text-red-600 text-2xl" @click="removeProduct(index)" type="button" >
                    &times;
            </button>
        </div>

        <div class="mb-4">
            <Label value="Author" />
            <Select
                class="mt-1 block w-full"
                v-model="form.moderators[index].author_id"

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
                v-model="form.moderators[index].moderator_type"

            >
                <option value="">-- Select Moderator --</option>
                <option
                    :value="type" v-for="(moderator, type) in data.moderatorTypes" :key="type"
                >
                    {{ moderator }}
                </option>
            </Select>
        </div>

        <div class="mb-4">
            <Label value="Honorarium Type" />
            <!-- <Input
                type="email"
                class="mt-1 block w-full"
                v-model="form.moderators[index].honorariumType"
            /> -->
            <Select
                class="mt-1 block w-full"
                v-model="form.moderators[index].honorarium_type"

            >
                <option value="">-- Select Moderator --</option>
                <option
                    :value="1"
                >
                    One Time
                </option>
                <option
                    :value="2"
                >
                    Percentage
                </option>
            </Select>
        </div>

        <div class="mb-4">
            <Label for="active" :value=" form.moderators[index].honorarium_type == 2 ? 'Honorarium(%)' : 'Honorarium(Tk)'" />
            <Input
                type="number"
                class="mt-1 block w-full"
                :placeholder="form.moderators[index].honorarium_type == 2 ? 'e.g: 2%' : 'e.g: 1000**/-'"
                v-model="form.moderators[index].honorarium"
                
            />
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
            this.form.moderators.push({
                authorId: "",
                moderatorType: "",
                honorariumType: "",
                honorarium: "",
            });
        },
        removeProduct(index) {
            this.form.moderators.splice(index, 1);

        },
    }
}
</script>
