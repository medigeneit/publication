<template>
    <div class="w-full flex gap-4">
        <form @submit.prevent="submit" class="w-full max-w-7xl space-y-4">
            <div class="w-full flex gap-6">
                <div class="w-full max-w-3xl p-4 bg-white border shadow rounded">
                    <h3 class="text-lg text-gray-600 font-bold">Version Information</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                    >
                        <div>
                            <Label value="Raw Product" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.production_id"
                                required
                            >
                                <option value="">-- Select Production --</option>
                                <option
                                    :value="productionId"
                                    v-for="(
                                        productionName, productionId
                                    ) in data.productionList"
                                    :key="productionId"
                                >
                                    {{ productionName }}
                                </option>
                            </Select>
                        </div>

                        <div>
                            <Label value="Edition" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.edition"
                            />
                        </div>

                        <div>
                            <Label value="Release Date" />
                            <Input
                                type="date"
                                class="mt-1 block w-full"
                                v-model="(form.release_date)"
                            />
                        </div>

                        <div>
                            <Label value="Cost" />
                            <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="(form.production_cost)"
                            />
                        </div>

                        <div>
                            <Label value="Link" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.link"
                            />
                        </div>

                        <active-input v-model="form.active" />

                        <div>
                            <Label value="Type" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.type"
                                required
                            >
                                <option value="">-- Select Type --</option>
                                <option
                                    :value="type"
                                    v-for="(typeName, type) in data.versionType"
                                    :key="type"
                                    :disabled ="type == 3"
                                    :hidden="(type == 3) && (this.data.version.type != 3) "
                                >
                                {{ typeName }}
                                </option>
                            </Select>
                        </div>
                    </div>
                    <h3 class="text-lg text-gray-600 font-bold">Volume Information</h3>
                    <div
                        class="
                            w-full
                            grid grid-cols-2
                            md:grid-cols-3
                            bg-white
                            border
                            rounded
                            gap-4
                            p-4
                        "
                        v-for="(volume, index) in form.volumes"
                        :key="index"
                    >
                        <div>
                            <Label value="Valume Name" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].name"
                            />
                        </div>

                        <!-- <div>
                            <Label value="Production Cost" />
                            <Input
                                type="number"
                                step="0.01"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].cost"
                            />
                        </div> -->

                        <div>
                            <Label value="ISBN" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].isbn"
                            />
                        </div>

                        <div>
                            <Label value="CRL" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].crl"
                            />
                        </div>

                        <!-- <div>
                            <Label value="Link" />
                            <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.volumes[index].link"
                            />
                        </div> -->
                    </div>

                    <div class="w-full text-right">
                        <Button
                            type="button"
                            class="btn-danger border-4"
                            @click="addVolume()"
                        >
                            (+) Add Volume
                        </Button>
                    </div>
                </div>
                <div class="w-full max-w-md">
                    <h3 class="text-lg text-gray-600 font-bold">Moderator Information</h3>
                    <div class="w-full p-4 bg-white border shadow rounded" v-for="(moderator, index) in form.moderators"
                        :key="index">

                        <div class="mb-4">
                            <Label value="Author" />
                            <!-- <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.moderators[index].authorId"
                            /> -->
                             <!-- <Select
                                id="author"
                                name="active"
                                class="mt-1 block w-full"
                                v-model="form.moderators[index].authorId"
                            >
                                <option value="">Select Author</option>
                                <option :value="id" v-for="(author, id) in data.authors" :key="id">{{ author }}</option>
                            </Select> -->
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.moderators[index].authorId"
                                required
                            >
                                <option value="">-- Select Author --</option>
                                <option
                                    :value="id" v-for="(author, id) in data.authors" :key="id"
                                >
                                    {{ author }}
                                </option>
                            </Select>
                        </div>

                        <div class="mb-4">
                            <Label value="Moderator Type" />
                            <Select
                                class="mt-1 block w-full"
                                v-model="form.moderators[index].moderatorType"
                                required
                            >
                                <option value="">-- Select Moderator --</option>
                                <option
                                    :value="id" v-for="(moderator, type) in data.moderatorTypes" :key="type"
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
                                v-model="form.moderators[index].honorariumType"
                                required
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
                </div>
            </div>

            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('versions.index')" />
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
        <!-- <div class="">
            Calculator
        </div> -->
    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import GoToList from "@/Components/GoToList.vue";
import Select from "@/Components/Select.vue";
import ActiveInput from "@/Components/ActiveInput.vue";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        ActiveInput,
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
                production_id: this.data.version.production_id || "",
                edition: this.data.version.edition || "",
                release_date: this.data.version.release_date || "",
                production_cost: this.data.version.production_cost || "",
                link: this.data.version.link || "",
                type: this.data.version.type || "",
                active: this.moduleAction == "store" ? 1 : this.data.version.active,
                volumes: [
                    {
                        name: "",
                        isbn: "",
                        crl: "",
                    },
                ],
                moderators: [
                    {
                        authorId: "",
                        moderatorType: "",
                        honorariumType: "",
                        honorarium: "",
                    },
                ],
            }),
        };
    },
    created() {
        for(let index in this.data.volumes) {
            this.form.volumes[index] = this.data.volumes[index] ? this.data.volumes[index] : '';
        } 
    },
    methods: {
        addVolume() {
            this.form.volumes.push({
                name: "",
                isbn: "",
                crl: "",
            });
        },
        addModertor() {
            this.form.moderators.push({
                authorId: "",
                moderatorType: "",
                honorariumType: "",
                honorarium: "",
            });
        },

        copyVolume(id) {
            appendableDiv.innerHTML += singleWrapper;
        },

        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("versions.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("versions.update", this.data.version.id)
                );
            }
        },
    },
};
</script>
