<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                />
            </div>

            <div class="mb-4">
                <Label for="publisher" value="Publisher" />
                <Select
                    id="publisher"
                    class="mt-1 block w-full"
                    v-model="form.publisher_id"
                    required
                >
                    <option value="">-- Select Publisher --</option>
                    <option
                        v-for="(publisher, index) of data.publishers"
                        :key="index"
                        :value="publisher.id"
                    >
                        {{ publisher.name }}
                    </option>
                </Select>
            </div>

            <active-input class="mb-4" v-model="form.active" />

            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('productions.index')" />
                </div>
                <Button
                    class=""
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ buttonValue }}
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import GoToList from "@/Components/GoToList.vue";
import Select from "@/Components/Select.vue";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
    },

    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "Submit",
        },
        data: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.production.name,
                publisher_id: this.data.production.publisher_id,
                active:
                    this.moduleAction == "store"
                        ? 1
                        : this.data.production.active,
            }),
        };
    },

    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("productions.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("productions.update", this.data.production.id)
                );
            }
        },
    },
};
</script>
