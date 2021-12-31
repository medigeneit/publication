<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label value="Name" />
                <Input
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                />
            </div>

            <div class="mb-4">
                <Label value="Phone" />
                <Input
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                />
            </div>

            <div class="mb-4">
                <Label value="Email" />
                <Input
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
            </div>

            <div class="mb-4">
                <Label value="Address" />
                <Textarea
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.address"
                ></Textarea>
            </div>

            <active-input class="mb-4" v-model="form.active" />

            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('publishers.index')" />
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
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        Textarea,
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
                name: this.data.publisher.name,
                phone: this.data.publisher.phone,
                email: this.data.publisher.email,
                address: this.data.publisher.address,
                active:
                    this.moduleAction == "store"
                        ? 1
                        : this.data.publisher.active,
            }),
        };
    },

    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("publishers.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("publishers.update", this.data.publisher.id)
                );
            }
        },
    },
};
</script>
