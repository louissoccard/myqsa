<template>
    <Head title="Register" />

    <div class="flex items-center justify-center w-screen h-full bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-col items-center w-full max-w-md bg-white dark:bg-black shadow-md px-8 sm:px-16 py-8">
            <Logo width="w-40" class="mb-8 max-h-20" />
            <form @submit.prevent="submit">
                <div class="w-full mb-6">
                    <Input id="first-name" class="inline-block w-1/2 pr-2" label="First Name" type="text" v-model="form.first_name" required autofocus autocomplete="given-name" />
                    <Input id="last-name" class="inline-block w-1/2 pl-2" label="Last Name" type="text" v-model="form.last_name" required autocomplete="family-name" />
                </div>
                <Input id="email-address" class="w-full mb-6" label="Email Address" type="email" v-model="form.email" required />
                <Input id="password" class="w-full" label="Password" type="password" v-model="form.password" required autocomplete="new-password" />
                <ValidationErrors class="mt-4"></ValidationErrors>
                <div class="mt-8 text-right w-full mb-6">
                    <Button class="inline bg-navy w-32 hover:bg-navy-darkened disabled:bg-navy-darkened" :disabled="form.processing" :loading="form.processing">Register</Button>
                </div>
            </form>
            <p class="w-full text-center border-t pt-4 border-gray-400 dark:border-gray-700">Already have an account? <Link :href="route('sign-in')" class="font-bold hover:text-blue">Sign In</Link></p>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Logo from "@/Components/Logo";
import Input from "@/Components/Forms/Input";
import Button from "@/Components/Buttons/Button";
import { Head, Link } from '@inertiajs/inertia-vue3';
import ValidationErrors from "@/Components/Forms/ValidationErrors";

export default defineComponent({
    components: {ValidationErrors, Button, Input, Logo, Head, Link},
    layout: null,

    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
               onFinish: () => this.form.reset('password')
            });
        }
    }
})
</script>
