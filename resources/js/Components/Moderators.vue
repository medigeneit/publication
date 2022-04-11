<template>
    <h3 class="text-lg text-gray-600 font-bold">Moderator Information</h3>
    <div class="w-full p-4 bg-white border shadow rounded" v-for="(moderator, index) in form.moderators"
        :key="index">

        <div class="mb-4">
            <Label value="Contributor" />
            <Select
                class="mt-1 block w-full"
                v-model="form.moderators[index].Contributor_id"

            >
                <option value="">-- Select Contributor --</option>
                <option
                    :value="index" v-for="(Contributor, index) in data.contributors" :key="index"
                >
                    {{ Contributor }}
                </option>
            </Select>
        </div>

        <div class="mb-4">
            <Label value="Moderator Type" />
            <Select
                class="mt-1 block w-full"
                v-model="form.moderators[index].contribution_type"

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
            <Label for="active" value="Honorarium" />
            <Input
                type="number"
                class="mt-1 block w-full"
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
                ContributorId: "",
                ContributionType: "",
                honorariumType: "",
                honorarium: "",
            });
        },
    }
}
</script>
