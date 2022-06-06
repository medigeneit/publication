<template>
    <div class="w-full max-w-md mx-auto p-4 bg-white border shadow rounded">

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="mb-4">
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
            </div>

            <div class="mb-4">
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mb-4">
                <Label for="phone" value="Phone" />
                <Input id="phone" type="number" class="mt-1 block w-full" v-model="form.phone" />
            </div>

            <div class="mb-4">
                <Label for="type" value="Type" />
                <Select name="type" class="mt-1 block w-full" v-model="form.type" required>
                    <option value="0"> --Select Type-- </option>
                    <option :value="type" v-for="(typeName, type) in userType" :key="type">{{ typeName }}</option>
                </Select>
            </div>

            <div class="mb-4">
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                <button type="button" class="px-5 border rounded-md mt-1 bg-green-600 text-white border-gray-500"
                    @click="passwordGenerate">
                    Generate
                </button>
                <span class="text-green-400" v-if="generatedPassword">
                    Generated :
                    <b>
                        {{ generatedPassword }}
                    </b>
                </span>
                <div class="text-red-500">Atleast 8 character</div>
            </div>

            <div class="mb-4">
                <Label for="active" value="Active" />
                <Select id="active" name="active" class="mt-1 block w-full" v-model="form.active">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
            </div>

            <hr class="w-full my-4">

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('users.index')" />
                </div>
                <Button class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ buttonValue }}
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import GoToList from '@/Components/GoToList.vue';
import Select from '@/Components/Select.vue';

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
        user: { type: Object, default: {} },
        userType: { type: Object, default: {} },
        moduleAction: String,
        buttonValue: { type: String, default: 'Submit' },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.user.name,
                email: this.user.email,
                phone: this.user.phone,
                type: this.user.type || 0,
                password: this.user.password || '',
                active: this.moduleAction == 'store' ? 1 : this.user.active,
            }),
            generatedPassword: '',
        }
    },

    methods: {
        passwordGenerate() {
            let charsB = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let charsS = 'abcdefghijklmnopqrstuvwxyz';
            let specialChars = '`~!@#$%^&*()_+/><';
            let numberChars = "0123456789";
            let allChars = charsB + charsS + specialChars + numberChars;
            let randPasswordArray = Array(8);

            randPasswordArray[0] = numberChars;
            randPasswordArray[1] = charsB;
            randPasswordArray[2] = specialChars;
            randPasswordArray[3] = charsS;
            randPasswordArray = randPasswordArray.fill(allChars, 4);
            
            let generatedPass = this.shuffleArray(randPasswordArray.map(function (x) { return x[Math.floor(Math.random() * x.length)] })).join('');
            this.generatedPassword = generatedPass; 
            // console.log(generatedPass);
            this.form.password =  generatedPass;
        },
       shuffleArray(array) {
            for (var i = array.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                let temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array;
        },
        submit() {
            if(this.moduleAction == 'store') {
                return this.form.post(this.route('users.store'));
            }

            if(this.moduleAction == 'update') {
                return this.form.put(this.route('users.update', this.user.id));
            }
        }
    }
};
</script>
