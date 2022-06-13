<template>
    <Head title="Register"/>

    <Page>
        <form @submit.prevent="submit">
            <div class="w-full mb-6">
                <Input id="first-name" class="inline-block w-1/2 pr-2" label="First Name" type="text"
                       v-model="form.first_name" required autofocus autocomplete="given-name"/>
                <Input id="last-name" class="inline-block w-1/2 pl-2" label="Last Name" type="text"
                       v-model="form.last_name" required autocomplete="family-name"/>
            </div>
            <Input id="email-address" class="w-full mb-6" label="Email Address" type="email" v-model="form.email"
                   required/>
            <Input id="password" class="w-full mb-6" label="Password" type="password" v-model="form.password" required
                   autocomplete="new-password"/>
            <Select id="district" class="w-full" label="District" v-model="form.district" required>
                <option value="null" selected>Select...</option>
                <option v-for="district of formattedDistricts" :key="district.id" :value="district.id">{{
                        district.name
                    }}
                </option>
            </Select>
            <Message class="mt-4"
                     v-show="this.districts.filter(district => district.name === 'Hampshire' && district.id === parseInt(form.district)).length === 1">
                If you have a Hampshire Scouts Microsoft account you should use that to
                <Link :href="route('login')" class="font-bold hover:text-blue">Sign In</Link>
                . You do not need to register for an account.
            </Message>
            <ValidationErrors class="mt-4"></ValidationErrors>
            <div class="mt-8 text-right w-full mb-6">
                <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                        :disabled="form.processing">Register
                </Button>
            </div>
        </form>
        <p class="w-full text-center border-t pt-4 border-gray-400 dark:border-gray-700">Already have an account?
            <Link :href="route('login')" class="font-bold hover:text-blue">Sign In</Link>
        </p>
    </Page>
</template>

<script>
import {defineComponent} from "vue";
import Logo from "@/Components/Logo";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import Button from "@/Components/Buttons/Button";
import {Head, Link} from '@inertiajs/inertia-vue3';
import ValidationErrors from "@/Components/Forms/ValidationErrors";
import Message from "@/Components/Interface/Message";
import Page from "@/Components/Auth/Page";

export default defineComponent({
    components: {Page, Message, ValidationErrors, Button, Input, Select, Logo, Head, Link},
    layout: null,

    props: {
        districts: Array,
    },

    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                district: 'null',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password')
            });
        }
    },

    computed: {
        formattedDistricts() {
            return this.districts.map(district => {
                return district.name === 'Hampshire' ? {id: district.id, name: 'Hampshire (County Role)'} : district
            });
        }
    }
})
</script>
