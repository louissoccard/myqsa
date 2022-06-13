<template>
    <Head title="Reset Password"/>

    <Page>
        <p class="mb-8 text-center">Thank you for verifying your email. Please enter your new password below. Once your
            password has been reset, you will be redirected to the sign in page.</p>
        <form @submit.prevent="submit" class="flex flex-col w-full">
            <Input id="password" class="w-full mb-6" label="Password" type="password" v-model="form.password"
                   required autocomplete="new-password"/>
            <Input id="password_confirmation" class="w-full" label="Password Confirmation" type="password"
                   v-model="form.password_confirmation"
                   required autocomplete="new-password"/>
            <ValidationErrors class="mt-4"></ValidationErrors>
            <div class="ml-auto mt-8">
                <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                        :disabled="form.processing">Reset Password
                </Button>
            </div>
        </form>

        <p class="w-full text-center border-t mt-4 pt-4 border-gray-400 dark:border-gray-700">Remembered your password?
            <Link :href="route('login')" class="font-bold hover:text-blue">Sign In</Link>
        </p>
    </Page>
</template>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Logo from "@/Components/Logo";
import Input from "@/Components/Forms/Input";
import Button from "@/Components/Buttons/Button";
import ValidationErrors from "@/Components/Forms/ValidationErrors";
import Page from "@/Components/Auth/Page";

export default defineComponent({
    components: {
        Page,
        Head,
        Link,
        Logo,
        Input,
        Button,
        ValidationErrors
    },

    props: {
        email: String,
        token: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
})
</script>
